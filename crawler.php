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
$start = isset($_GET['url']) ? $_GET['url'] : '';
$depth = isset($_GET['depth']) ? $_GET['depth'] : 0;
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
// for robots.txt compliance requiremtn
function isUrlAllowedByRobotsTxt($url) {
    // Construct the robots.txt URL
    $robotsTxtUrl = rtrim($url, '/') . '/robots.txt';

    // Initialize cURL session
    $ch = curl_init($robotsTxtUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and get the content of robots.txt
    $robotsTxtContent = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Check if robots.txt content is retrieved successfully
    if ($robotsTxtContent === false) {
        // Handle the error, e.g., by returning false
        return false;
    }

    // Parse robots.txt content to extract rules
    $rules = parseRobotsTxt($robotsTxtContent);

    // Check if the URL is allowed by robots.txt rules
    return checkRobotsRules($url, $rules);
}

// Function to parse robots.txt content and extract rules
function parseRobotsTxt($content) {
    $rules = array();
    $lines = explode("\n", $content);

    $currentUserAgent = '*'; // Default user agent is "*"

    foreach ($lines as $line) {
        $line = trim($line);

        // Skip comments and empty lines
        if (empty($line) || $line[0] == '#') {
            continue;
        }

        // Parse User-agent directive
        if (strtolower(substr($line, 0, 11)) == 'user-agent:') {
            $currentUserAgent = trim(substr($line, 11));
        }

        // Parse Disallow and Allow directives
        if (strtolower(substr($line, 0, 8)) == 'disallow') {
            $path = trim(substr($line, 8));

            // Add rule to the $rules array
            $rules[] = array(
                'userAgent' => $currentUserAgent,
                'type' => 'disallow',
                'path' => $path,
            );
        } elseif (strtolower(substr($line, 0, 5)) == 'allow') {
            $path = trim(substr($line, 5));

            // Add rule to the $rules array
            $rules[] = array(
                'userAgent' => $currentUserAgent,
                'type' => 'allow',
                'path' => $path,
            );
        }
    }

    return $rules;
}

// Function to check if a URL complies with robots.txt rules
function checkRobotsRules($url, $robotsRules) {
    $urlPath = parse_url($url, PHP_URL_PATH);
    $urlUserAgent = '*'; // Default user agent is "*"

    foreach ($robotsRules as $rule) {
        // Check if the rule is applicable to the current user agent
        if ($rule['userAgent'] == '*' || $rule['userAgent'] == $urlUserAgent) {
            // Check if the URL path matches the Disallow rule
            if ($rule['type'] == 'disallow' && strpos($urlPath, $rule['path']) === 0) {
                return false; // URL is disallowed
            }

            // Check if the URL path matches the Allow rule
            if ($rule['type'] == 'allow' && strpos($urlPath, $rule['path']) === 0) {
                return true; // URL is allowed
            }
        }
    }

    return true; // If no specific rule matched, consider it allowed
}


function follow_links($url , $depth = 0){

    if ($url == ''){
        exit();
    }
    if (!isUrlAllowedByRobotsTxt($url)){
        echo "this page cannot be crawled because of robots.txt compliance";
        exit();
    }
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
        // for now max depth limit is set to 5
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



    header('Location: index.php');
    exit();
}

// search part
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

function search_content() {
    global $searchQuery, $conn;

    // Fetch data from the database based on search conditions
    $sql = "SELECT * FROM crawler_data WHERE keywords LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR title LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display or log the URL and matched content
            echo "<li>";
            echo "<strong>URL:</strong> " . $row['url'] . "<br>";
            echo "<strong>Title:</strong> " . $row['title'] . "<br>";
            echo "<strong>Description:</strong> " . $row['description'] . "<br>";
            echo "<strong>Keywords:</strong> " . $row['keywords'] . "<br>";
            echo "</li>";            
            echo "<hr>";
        }
    }
    else{
        echo "no match found";
    }
}

if($searchQuery){
search_content();

}

// start crawling
follow_links($start, $depth);
// Close the database connection
$conn->close();
?>
