<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('googleapi/vendor/autoload.php');

define("ARTFROOT", 'https://iscoralil.mtacloud.co.il/');
define("ARTFUPLOADPATH", '/home/iscoralil/public_html/paintings/');
define("ARTFUPLOADURL", 'https://iscoralil.mtacloud.co.il/paintings/');
 

 
$mysqli = new mysqli("localhost","iscoralil","katlanim","iscorali_ART");
if($mysqli->connect_error) {
  exit('Error connecting to database'); 
}


$client = new Google_Client();
$client->setAuthConfig("googleapi/credentials.json");
$client->setApplicationName("OAuth client");
$client->setRedirectUri("http://iscoralil.mtacloud.co.il/gauth.php");
$client->addScope("email");
$client->addScope("profile");
 