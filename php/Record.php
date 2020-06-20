<?php
include("downloadpic/zalivkafile.php");
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include($_SERVER['DOCUMENT_ROOT'] . "/config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error());
//var_dump($_POST);


//id+Position++Disable+Name+Replay+Type+Begin+End+Delay++Content,
// if id 
if (isset($_GET['Add'])) {
  $id = (int) $_GET['id'];
  $Position = (int) $_GET['Position'];
  $Disable = (int) $_GET['Disable'];
  $Name = $_GET['Name'];
  $Replay = (int) $_GET['Replay'];
  $Type = $_GET['Type'];

  $Begin = new DateTime($_GET['Begin']);
  $Begin = $Begin->format('Y-m-d');

  $End = new DateTime($_GET['End']);
  $End = $End->format('Y-m-d');
  var_dump($End);
  $Delay = (int) $_GET['Delay'];
 // $Content = $_POST['Content'];
  $proverkaId = mysqli_query($db,"SELECT id FROM `tack` WHERE id = '$id'"); 
  $ID_sql=mysqli_num_rows($proverkaId);
  //var_dump($proverkaId);
  //1. есть ли такой id 
  //2. если нету то идет добавление
  //2.1. если есть то update
  if($ID_sql == 0){
  $sql = mysqli_query($db, "INSERT INTO `tack` ( id, Position, Disable, Name, Replay, Type, Begin, End, Delay)
    						  VALUES ($id,$Position,$Disable,'$Name',$Replay,'$Type','$Begin','$End',$Delay)");
  }else{
  $sql = mysqli_query($db, "UPDATE 'tack' SET 
  Position = '$Position', 
  Disable='$Disable', 
  Name='$Name', 
  Replay='$Replay', 
  Type='$Type', 
  Begin='$Begin',
  End='$End', 
  Delay='$Delay' 
  WHERE id = '$id' ");
  }
  //Если вставка прошла успешно то вставляем контент
  if ($sql) {
    //параметрический запрос для Content
    $sqlContent = $db->prepare("UPDATE `tack` SET Content=? WHERE id = '$id' ");

    //варианты загрузки Content в базу в зависимости от Type
    if($Type == 'html'){ //если html то загружается как обработанная строка
		$sqlContent->bind_param("s", $Content);
		$sqlContent->execute();
    }elseif($Type == 'pic'){ //если pic 
    //файл 
		//
		$path_f=download($_FILES["file"]);
		//var_dump($path_f);
		//$Content = $_FILES['Content'];
		if($path_f["status"] ==  'Ok'){
		$sqlContent->bind_param("s", $path_f["message"]);
		$sqlContent->execute();
		}else echo $path_f["message"];
		
    }else{  //если weather
      //добавить сюда Ссылку на Вовин файл

      $sqlContent->bind_param("s", $Content);
      $sqlContent->execute();
    }

    if ($sqlContent) {
      echo '<p>Данные успешно добавлены в таблицу.</p>';
    }
  } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($db) . '</p>';
  } 
  
} elseif (isset($_GET['Del'])) {
  $id = (int)$_GET['id'];
  $query = mysqli_query($db, "DELETE FROM Tack WHERE id = '$id' ");

} elseif (isset($_GET['select'])) {
  $id = (int)$_GET['id'];
  $query = mysqli_query($db, "SELECT * FROM Tack WHERE id = '$id' ");
  $data = array(); // в этот массив запишем то, что выберем из базы

  while ($row = mysqli_fetch_assoc($query)) { // оформим каждую строку результата
    // как ассоциативный массив
    $data[] = $row; // допишем строку из выборки как новый элемент результирующего массива
  }
  echo json_encode($data);

}elseif(isset($_GET['delpic'])){
  $id = (int)$_GET['id'];
  $query = mysqli_query($db, "SELECT Type FROM Tack WHERE id = '$id' ");
  //1.делаю запрос на тип, если пик то
  $row = mysqli_fetch_assoc($query);
  $Type = $row['Type'];
  $Content = mysqli_query($db, "SELECT Content FROM Tack WHERE id = '$id' ");
  $row2 = mysqli_fetch_assoc($Content);
  $Content2=$row2['Content'];

  if($Type == 'pic'){
  //2.если удаляется физически, то делает update
  if(unlink('../data/'.$Content2) || $Content2 == ""){
    //сказать что удалилось
    
    $data['Error'] = '1';
    echo json_encode($data);
  
    $query = mysqli_query($db, "UPDATE `tack` SET Content='' WHERE id = '$id' ");
    
  }else{//не удалилось
    $data['Error'] = '2';
    echo json_encode($data);
  }
  
}else{//не картинка
  $data['Error'] = '3';
  echo json_encode($data);
} 

}


//trash

  /*elseif (isset($_GET['Edit'])) {
  $id = (int) $_GET['id'];
  $Position = (int) $_GET['Position'];
  $Disable = (int) $_GET['Disable'];
  $Name = $_GET['Name'];
  $Replay = (int) $_GET['Replay'];
  $Type = $_GET['Type'];

  $Begin = new DateTime($_GET['Begin']);
  $Begin = $Begin->format('Y-m-d');

  $End = new DateTime($_GET['End']);
  $End = $End->format('Y-m-d');
  $Delay = (int) $_GET['Delay'];
  $Content = $_POST['Content'];
    
  $sql = mysqli_query($db, "UPDATE 'tack' SET Position = '$Position', Disable='$Disable', Name='$Name', Replay='$Replay', Type='$Type', Begin='$Begin',
     						  End='$End', Delay='$Delay' WHERE id = '$id' ");

  //Если вставка прошла успешно
  if ($sql) {
    $sqlContent = $db->prepare("UPDATE `tack` SET Content=? WHERE id = '$id' ");
    $sqlContent->bind_param("s", $Content);
    $sqlContent->execute();
    if ($sqlContent) {
      echo '<p>Данные успешно добавлены в таблицу.</p>';
    }
  } else {
    echo '<p>Произошла ошибка: ' . mysqli_error($db) . '</p>';
  }*/
?>