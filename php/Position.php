<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT']."/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword,$database) or die("Connection Error: " . mysqli_error()); 
$id = $_GET['id']; 
 isset($_GET['up']);
	if(isset($_GET['up'])){
	$serchSQL1 = "SELECT id, Position ";
	$serchSQL1 .= "FROM doc.Tack ";
	$serchSQL1 .= "WHERE id = '$id'";
	$result = mysqli_query($db, $serchSQL1) or die($serchSQL1."<<Couldn't execute query. ".mysqli_error($db)); ; 
	$row = mysqli_fetch_array($result,MYSQL_ASSOC); 
	
	$Position = $row['Position']-1;
	$serchSQL2 = "SELECT id, Position ";
	$serchSQL2 .= "FROM doc.Tack ";
	$serchSQL2 .= "WHERE Position = '$Position'";
	$result = mysqli_query($db, $serchSQL2) or die($serchSQL2."<<Couldn't execute query. ".mysqli_error($db)); ; 
	$row = mysqli_fetch_array($result,MYSQL_ASSOC); 
	$id2 = $row['id']; 
	$update1 = "UPDATE doc.Tack SET Position = $Position WHERE id = $id";
	$result = mysqli_query($db, $update1) or die($update1."<<Couldn't execute query. ".mysqli_error($db)); ; 
	
	$update2 = "UPDATE doc.Tack SET Position = $Position+1 WHERE id = $id2";
	$result = mysqli_query($db, $update2) or die($update2."<<Couldn't execute query. ".mysqli_error($db)); ; 
	
	}
	elseif(isset($_GET['down'])){
	$serchSQL1 = "SELECT id, Position ";
	$serchSQL1 .= "FROM doc.Tack ";
	$serchSQL1 .= "WHERE id = '$id'";
	$result = mysqli_query($db, $serchSQL1) or die($serchSQL1."<<Couldn't execute query. ".mysqli_error($db)); ; 
	$row = mysqli_fetch_array($result,MYSQL_ASSOC); 
	
	$Position = $row['Position']+1;
	$serchSQL2 = "SELECT id, Position ";
	$serchSQL2 .= "FROM doc.Tack ";
	$serchSQL2 .= "WHERE Position = '$Position'";
	$result = mysqli_query($db, $serchSQL2) or die($serchSQL2."<<Couldn't execute query. ".mysqli_error($db)); ; 
	$row = mysqli_fetch_array($result,MYSQL_ASSOC); 
	$id2 = $row['id']; 
	$update1 = "UPDATE doc.Tack SET Position = $Position WHERE id = $id";
	$result = mysqli_query($db, $update1) or die($update1."<<Couldn't execute query. ".mysqli_error($db)); ; 
	
	$update2 = "UPDATE doc.Tack SET Position = $Position-1 WHERE id = $id2";
	$result = mysqli_query($db, $update2) or die($update2."<<Couldn't execute query. ".mysqli_error($db)); ; 
	
	}
	





/* $("down").click(function(){
	//Получаем id и Position записи, которую поднимаем
	$serchSQL1 = "SELECT id, Position";
	$serchSQL1 .= "FROM doc.Tack";
	$serchSQL1 .= "WHERE id = 'id'";
	//в переменную помещаем поицию записи сверху
	$position = $serchSQL1.Position++;
	//ищем id и позицию записи сверху
	$serchSQL2 = "SELECT id, Position";
	$serchSQL2 .= "FROM doc.Tack";
	$serchSQL2 .= "WHERE Position = '$position'";
	//меняем позиции в записях
	$update1 = "UPDATE doc.Tack SET Position = $position WHERE id = $searchSQL1.id";
	$update2 = "UPDATE doc.Tack SET Position = $position-1 WHERE id = $searchSQL2.id";
	});

 
echo $s; */
?>