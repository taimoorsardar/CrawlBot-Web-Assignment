<?php
$start = "https://google.com";

$alreadycrawled = array();

function  get_details($url){
    // for giving custome headers
    $options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: crawlBot/0.1 \n"));
    $context  = stream_context_create($options); // to mess with headers
    
    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="UTF-8">'.@file_get_contents($url, false, $context)); //@ sign is to deal with warning
}


function follow_links($url){

    global $alreadycrawled;
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
            echo get_details($l);
        }
    }
}

follow_links($start);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include_once("index.php");
?>