<?php
//set_time_limit(300);

// Your database credentials
$servername = "localhost";
$username = "root";
$password = "Ts1516232628";
$dbname = "web_assignment_2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// for crawling
$start = "https://google.com";

$alreadycrawled = array();
$crawling = array();

// this function is used to get details from the urls 
function  get_details($url){
    // for giving custom headers
    $options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: crawlBot/0.1 \n")); // just giving a name to the bot
    $context  = stream_context_create($options); // to mess with headers
    
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="UTF-8">'.@file_get_contents($url, false, $context)); //@ sign is to deal with warning
    
    $title = $doc->getElementsByTagName("title");
    if ($title !== null) {
        @$title = $title->item(0)->nodeValue;
    } else {
        $title = "Title Not Found"; // Provide a default value or handle it as needed
    }


    $description = "";
    $keywords = "";
    $metas = $doc->getElementsByTagName("meta");
    for ($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		// Get the description and the keywords.
        $descriptionElement = $doc->getElementsByTagName("meta")->item($i);
        if ($descriptionElement !==null){
		    if (strtolower($meta->getAttribute("name")) == "description"){
	    	    $description = $meta->getAttribute("content");
            }
        }

        $keywordsElement = $doc->getElementsByTagName("meta")->item($i);
		if ($keywordsElement !== null) {
            if (strtolower($keywordsElement->getAttribute("name")) == "keywords") {
                $keywords = $keywordsElement->getAttribute("content");
            }
        }

    $data = array(
            'Title' => str_replace("\n", "", $title),
            'Description' => str_replace("\n", "", $description),
            'Keywords' => str_replace("\n", "", $keywords),
            'URL' => $url
        );
        
    return $data;

    }
}


// this will be used to send info to database
function insert_data_into_database($data) {
    global $conn;

    // Escape values to prevent SQL injection
    @$title = mysqli_real_escape_string($conn, $data["Title"]);
    @$description = mysqli_real_escape_string($conn, $data['Description']);
    @$keywords = mysqli_real_escape_string($conn, $data['Keywords']);
    @$url = mysqli_real_escape_string($conn, $data['URL']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO crawler_data (`title`, `description`, `keywords`, `url`) VALUES ('$title', '$description', '$keywords', '$url')";

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function follow_links($url , $depth = 0){

    global $alreadycrawled;
    global $crawling;
    // for giving custome headers
    $options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: crawlBot/0.1 \n"));
    $context  = stream_context_create($options); // to mess with headers
    
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="UTF-8">'.@file_get_contents($url, false, $context)); //@ sign is to deal with warning
    // to get the list of all links
    $linklist = $doc->getElementsByTagName("a");

    // loops through all of the links
    foreach ($linklist as $link){
        $l = $link->getAttribute("href");
        
        // dealing with urls so our crawler can easily crawl any type of link it is given
        // dealing urls with single slash
        if (substr($l, 0, 1) == "/" && substr ($l, 0, 2) != "//") {
            $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
        }

        //dealing urls with double slash
        else if (substr ($l, 0, 2) == "//") {
            $l = parse_url($url)["scheme"].":".$l;
        }

        //dealing urls with a dot and slash
        else if (substr ($l, 0, 2) == "./") {
            $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].dirname(parse_url($url)["path"]).substr($l,1);
        }
        //dealing urls with a hash
        else if (substr ($l, 0, 2) == "#") {
            $l = parse_url($url)["scheme"]."://".parse_url($url)["host"].parse_url($url)["path"].$l;
        }
        //dealing wiht two dots and single slash
        else if (substr ($l, 0, 2) == "../") {
            $l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
        }
        // ignore js 
        else if(substr ($l, 0, 11) == "javascript:"){continue;}
        else if (substr($l, 0, 5) != "https" && substr($l, 0, 4) != "http"){
            parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
        }
        // for now depth limit is set to 5
        if (in_array($url, $alreadycrawled) || $depth > 5) {
            return;
        }
    

        // to check for duplicate links
        if (!in_array ($l, $alreadycrawled)){
            $alreadycrawled[] = $l;
            $crawling[] = $l;
            $data = get_details($l);
            // Insert data into the database
            insert_data_into_database($data);

        }
    }
    array_shift($crawling); // so it doesn't move throught the first item again and again
    foreach($crawling as $site){
        follow_links($site, $depth+1);
    }
}

// for search module
// Get the search query from the form
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';
function search_content($content, $url) {
    global $searchQuery;

    // Perform a case-insensitive search for the query in the content
    if (stripos($content, $searchQuery) !== false) {
        // Display or log the URL and matched content
        echo "URL: $url\n";
        echo "Matched Content: $content\n";
        // You can also customize how the results are displayed
        echo "<hr>";
    }
}


// start crawling
follow_links($start);


// Fetch data from the database
$sql = "SELECT * FROM crawler_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Search for the query in the content
        search_content($row['description'], $row['url']);
        search_content($row['keywords'], $row['url']);
        search_content($row['title'], $row['url']);
        // You can extend this to search in other content as needed
    }
} else {
    echo "No results found";
}
// Close the database connection
$conn->close();
?>