<?php

require('config.php');
require('include/twitteroauth.php');

function get_twitter_op(){
    $doc = "^".$_SERVER['DOCUMENT_URI'];
    $uri = "^".$_SERVER['REQUEST_URI'];
    if (substr($doc, -1) !== "/") {
        $doc .= "$";
    } else {
        $doc = substr($doc, 0, -1) . '$';
    }

    $base_doc = str_replace('index.php$', '', $doc);
    $op = str_replace($base_doc, '', $uri);
    $op .= ".json";
    return explode('.', $op);
}


#date_default_timezone_set('GMT-8');
$response = "request method is not support.";
$args = get_twitter_op();
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_TOKEN_SECRET);
$connection->decode_json = false;
$connection->format = $args[1];
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $response = $connection->get($args[0], $_GET);
} else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $response = $connection->post($args[0], $_POST);
}

echo $response;

?>
