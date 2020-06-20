<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error());

if ($_POST['oper']=='del') {
  $user_id = (int)$_POST['id'];
  $query = mysqli_query($db, "DELETE FROM black_list_id WHERE user_id = '$user_id' ");
}

?>