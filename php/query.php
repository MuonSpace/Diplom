<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT']."/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword,$database) or die("Connection Error: " . mysql_error()); 
$query = mysqli_query($db, "SELECT MAX(id)+1 AS id FROM doc.tack");
$row = mysqli_fetch_assoc($query);
$return=[];
$return['id'] = $row['id'];

$query2 = mysqli_query($db, "SELECT MAX(Position)+1 AS Position FROM doc.tack");
$row = mysqli_fetch_assoc($query2);
$return['Position'] = $row['Position'];

$query3=mysqli_query($db, "SELECT MAX(user_id)+1 AS user_id FROM doc.users");
$row = mysqli_fetch_assoc($query3);
$return['user_id'] = $row['user_id'];

echo json_encode($return);
?>