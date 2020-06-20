<?php
include("config.php");
$db = mysqli_connect($dbhost, $dbuser, $dbpassword,$database) or die('[[["Error:1","'. mysqli_error($db).'"]]]' ); 
$id=(int)$_REQUEST['id'];

$SQL = "
SELECT * FROM `tack`
Where 
Disable = 0 and
((`Replay` = 0) and (`Begin` <= now() ) and (`End` >=now()))
or
((`Replay` = 1) )
or
((`Replay` = 2) and ( (day(`Begin`) = day(now())) )    )
or
((`Replay` = 3) and ((month(`Begin`) = month(now())) and (day(`Begin`) = day(now())) ))
order by `Position`
";
$result = mysqli_query($db, $SQL ) or die('[[["Error:2","'. mysqli_error($db).'"]]]');
$inf ='';// удалить 
$Arr = array();
$Arr_Rez = array();

while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
	$Arr[] = $row;
}
//var_dump($Arr);


// foreach ($Arr as $key => $value){
	// echo $value['Delay'].'<br>';
// }
// echo '<br>';
// echo '-----<br><table>';

$bool = false ;
//foreach ($Arr as $key => $value){
	
for($i=count($Arr)-1;$i>=0;$i--)	{
	//echo  '<tr><td>'.$Arr[$i]['Delay'].'</td><td>';
	if ($bool) {
		$Delay2 = $Arr[$i]['Delay'];
		$Arr[$i]['Delay'] =$Delay1;
		$Delay1 = $Delay2;
	
	} else {
		$Delay1 = $Arr[$i]['Delay'];
		$Delay2 = $Arr[$i]['Delay'];
		$bool=true;
	}
	//echo  $Arr[$i]['Delay']."</td><td> $Delay1 </td><td> $Delay2 </td></tr>";
}
//echo '</table>-----<br>';

	 $Arr[count($Arr)-1]['Delay'] =$Delay1;


// foreach ($Arr as $key => $value){
	// echo $value['Delay'].'<br>';
// }


$bool = false ;
if ($id == -1) ($bool=true);

foreach ($Arr as $key => $value){
 //while($row = mysqli_fetch_array($result,MYSQL_ASSOC)) {
	 // if ($bool) {
		 // echo $value['id'].':B:TRUE <br>';
	 // } else {
		// echo $value['id'].':B:FALSE <br>'; 
	 // }

	if ($bool) {
		$Arr_Rez[] = $value;
		$bool=false;
	}
	if ($id == $value['id']) {$bool=true;}
} 
//если пустой то выковыриваем первый
if  (empty($Arr_Rez)) {
	foreach ($Arr as $key => $value){
		$Arr_Rez[] = $value;
		break;
	}
}


echo json_encode($Arr_Rez); 

//echo json_encode($Arr); 




mysqli_close($db);

?>