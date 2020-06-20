<?php 
// Содержит информацию, необходимую для подключения к базе данных
// MySQL. Мы храним здесь логин, пароль, имя базы.

//echo $_SERVER['DOCUMENT_ROOT'];
include($_SERVER['DOCUMENT_ROOT']."/config.php");
 
// К параметру url добавляются 4 параметра, как описано в colModel.
// Мы должны считать эти параметры, чтобы создать SQL-запрос.
// В настройках таблицы мы указали, что используем GET-метод.
// И мы должны использовать подходящий способ, чтобы считать их.
// В нашем случае это $_GET. Если бы мы указали, что хотим
// использовать POST-метод, то мы бы использовали $_POST.
// Можно использовать $_REQUEST, который содержит переменные 
// с GET и POST одновременно.. 
// Обратитесь к документации для большей информации.
// Получаем номер страницы. Сначала jqGrid ставит его в 1. 
$page = $_POST['page']; 
 
// сколько строк мы хотим иметь в таблице - rowNum параметр 
$limit = $_POST['rows']; 
 
// Колонка для сортировки. Сначала sortname параметр 
// затем index из colModel 
$sidx = $_POST['sidx']; 
 
// Порядок сортировки.
$sord = $_POST['sord']; 
 
// Если колонка сортировки не указана, то будем
// сортировать по первой колонке.
if(!$sidx) $sidx =1; 

 
// Подключаемся к MySQL

$db = mysqli_connect($dbhost, $dbuser, $dbpassword,$database) or die("Connection Error: " . mysqli_error()); 


/// Обрабатываем поисковые запросы
 $WhereSql = ' ';
// if ($_POST['_search'] == 'true') {
		// $WhereSql = ' WHERE ';
		// $WhereCOND = ' and ';
		// $W_N = 0;
		// if (isset($_POST['Metod'])) 		{if ($W_N > 0) $WhereSql .=$WhereCOND;$WhereSql .= "Metod like '%".$_POST['Metod']."%'";$W_N++; };
		// if (isset($_POST['Type_Isl'])) 	{if ($W_N > 0) $WhereSql .=$WhereCOND;$WhereSql .= "Type_Isl like '%".$_POST['Type_Isl']."%'";$W_N++;};
		// if (isset($_POST['Name'])) 		{if ($W_N > 0) $WhereSql .=$WhereCOND;$WhereSql .= "Name like '%".$_POST['Name']."%'";$W_N++;};
		// if (isset($_POST['Date'])) 		{if ($W_N > 0) $WhereSql .=$WhereCOND;$WhereSql .= "Date like '%".$_POST['Date']."%'";$W_N++;};
		// if (isset($_POST['Instrument'])) {if ($W_N > 0) $WhereSql .=$WhereCOND;$WhereSql .= "Instrument like '%".$_POST['Instrument']."%'";$W_N++;};
// };





// Вычисляем количество строк. Это необходимо для постраничной навигации.
$SQL ="SELECT COUNT(*) AS count FROM doc.black_list_id ".$WhereSql ;
//echo $SQL.'<br>';
$result = mysqli_query($db, $SQL) or die($SQL."<<Couldn't execute query. ".mysqli_error($db)); ; 
$row = mysqli_fetch_array($result,MYSQL_ASSOC); 
$count = $row['count']; 

// Вычисляем общее количество страниц.
if( $count > 0 && $limit > 0) { 
              $total_pages = ceil($count/$limit); 
} else { 
              $total_pages = 0; 
} 
 
// Если запрашиваемый номер страницы больше общего количества страниц,
// то устанавливаем номер страницы в максимальный.
if ($page > $total_pages) $page=$total_pages;
 
// Вычисляем начальное смещение строк.
$start = $limit*$page - $limit;
 
// Если начальное смещение отрицательно,
// то устанавливаем его в 0.
// Например, когда пользователь
// выбрал 0 в качестве запрашиваемой страницы.
if($start <0) $start = 0; 
 
// Запрос для получения данных.
$SQL = "SELECT * ";
$SQL .= "FROM doc.black_list_id ";
$SQL .= $WhereSql;
$SQL .= "ORDER BY  ".$sidx." " .$sord. " LIMIT ". $start . " , " . $limit .";" ;

//echo $SQL.'<br>';
$result = mysqli_query($db, $SQL ) or die($SQL."<<Couldn't execute query. ".mysqli_error($db)); 
//$sidx $sord LIMIT $start , $limit";


// Заголовок с указанием содержимого.
header("Content-type: text/xml;charset=utf-8");
 
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .=  "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";

 
// Обязательно передайте текстовые данные в CDATA
while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
    
	$s .= "<row id='". $row['user_id']."'>";
 	//$s .= "<cell><![CDATA[". $row['user_id']."]]></cell>";
	$s .= "<cell><![CDATA[". $row['user_ip']."]]></cell>";
	$s .= "<cell><![CDATA[". $row['date']."]]></cell>";
	
    $s .= "</row>";
}
$s .= "</rows>";

echo $s;
?>