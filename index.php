<?php
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
    $title = $title->item(0)->nodeValue;

    $description = "";
    $keywords = "";
    $metas = $doc->getElementsByTagName("meta");
    for ($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		// Get the description and the keywords.
		if (strtolower($meta->getAttribute("name")) == "description")
			$description = $meta->getAttribute("content");
		if (strtolower($meta->getAttribute("name")) == "keywords")
			$keywords = $meta->getAttribute("content");

    // return in json the relevant information
	return '{ "Title": "'.str_replace("\n", "", $title).'", "Description": "'.str_replace("\n", "", $description).'", "Keywords": "'.str_replace("\n", "", $keywords).'", "URL": "'.$url.'"},';

    }
}

function follow_links($url){

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


        // to check for duplicate links
        if (!in_array ($l, $alreadycrawled)){
            $alreadycrawled[] = $l;
            $crawling[] = $l;
            echo get_details($l);
        }
    }
    array_shift($crawling); // so it doesn't move throught the first item again and again
    foreach($crawling as $site){
        follow_links($site);
    }
}

follow_links($start);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>