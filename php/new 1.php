<?php
include("downloadpic/zalivkafile.php");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error());

$proverkaId = mysqli_query($db,"SELECT user_id FROM `users` WHERE user_id = '$user_id'"); 
  $ID_sql=mysqli_num_rows($proverkaId);
  
?>