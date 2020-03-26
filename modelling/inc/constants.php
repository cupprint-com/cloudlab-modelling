<?php 
if(!defined('CP_MODELLING_RUNNING')){
    exit(1);
}

# check if development file exists (must be excluded from GIT)
$filename=dirname(__FILE__) . '/development.txt';
error_log($filename);
$apiAddress="https://api.cupprint.com/";
$apiKey="0b51182b3a3a81642eb35ff7fae4b9d5";

if (file_exists($filename)){
    $apiAddress='https://sandbox.cupprint.com/';
}

define('CP_API_ENDPOINT',$apiAddress);
define('CP_API_KEY',$apiKey);


