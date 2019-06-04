<?php
 define("ARTFROOT", 'https://home/kynetuweb/art/includes/');
 define("ARTFUPLOADPATH", '/home/kynetuweb/public_html/art/paintings/');
 define("ARTFUPLOADURL", 'http://kynetweb.com/art/paintings/');
 
$mysqli = new mysqli("localhost","iscoralil","katlanim@2019","iscorali_ART");
if($mysqli->connect_error) {
  exit('Error connecting to database'); 
}