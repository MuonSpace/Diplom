<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error());

// утебя в таблице метод предачи $_POST .. используй везеде такой метод

if ($_POST['oper']=='add') {
	// если добавили пользователя
//	$user_id = (int)$_GET['user_id'];
	$user_login = $_POST['user_login'];
	$user_password =  md5(md5($_POST['user_password']));
// ПИХАЕМ В БАЗУ ШИФРУЯ ПАРОЛЬ!!!

	$SQL = mysqli_query($db, "INSERT INTO `users` (user_login, user_password) VALUES ('$user_login','$user_password')");
	//$result = mysqli_query($db, "INSERT INTO `users` (user_login, user_password) VALUES ('$user_login','$user_password')") or die("Couldn't execute query. >>>" . "INSERT INTO `users` (user_login, user_password) VALUES ('$user_login','$user_password')" . "<<<< " . mysqli_error($db));

}
elseif ($_POST['oper']=='del') {
  $user_id = (int)$_POST['id'];
  $query = mysqli_query($db, "DELETE FROM users WHERE user_id = '$user_id' ");
  
}
elseif ($_POST['oper']=='edit') {
	// тоже читаем пост параметры
	$user_id = (int)$_POST['id'];
	$user_login = $_POST['user_login'];
	$user_password =  md5(md5($_POST['user_password']));
	$sql = mysqli_query($db, "UPDATE `users` SET 
  user_login='$user_login', 
  user_password='$user_password' 
  WHERE user_id = '$user_id' ");
}
/*elseif ($_POST['oper']=='search') {
	if (isset($_POST['user_login'])){
		$WhereSql .="and `users`.`user_login` likes '%". $_POST['user_login']. "%'";
		}
	*/



?>