<?php
include ("weather_pic.php");// подключаем файл с графиком
function testGismetio()
{
	$retern="";
	//header("Content-Type: text/html; charset=UTF8");
	$retern .= "<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'/></head>";
	$days = array( 1 => 'Понедельник' , 'Вторник' , 'Среда' , 'Четверг' , 'Пятница' , 'Суббота' , 'Воскресенье' );

	 $api_key='59f20cc12d9896.24642531';	
	 $basicurl="https://api.gismeteo.ru/v2/weather/forecast/aggregate/?latitude=61.666668&longitude=50.816666&days=7" ;
	 $ch = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $basicurl);
	 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Gismeteo-Token: '.$api_key));
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 $json_reply =curl_exec($ch);
	 curl_close($ch);
	 
	 //echo $json_reply;
	// $retern .=  $_SERVER['DOCUMENT_ROOT'];
	
	$json = json_decode($json_reply,true);
	$res=$json['response'];
	
	//var_dump($json);
	//var_dump($res);
	// <table>
	// <tr>
    // <td>...</td>
	// </tr>
	// </table>
	
	
	$retern .= "<style>
	tr {
		text-align: center;
		color: black;
		font-family: MS Sans Serif;
	}

	.datatext {
		background: #87CEEB;
		font-weight:bold;
		font-family: Arial;
	}
 
	.temperaturetext {
		color: #FF4500;
		font-weight:bold;
		font-family: arial;
		padding-top: 3px;
	} 

	table {
		width: 1500px;
		text-align: center;
		border-spacing: 2px 0px;
		border: 5px solid #F5F5F5;
		color: black;
		margin-bottom: 5px;
		margin: auto;
	}

	td {
		width: 200px;
		border: 2px solid black;
		padding: 3px;
		border-bottom: 1px solid black;
		border-top: 1px solid black;
	}

	.pic{
		margin-top: 5px;
		text-align: center;
	}

   .Calm{
	   transform: scaleY(1); //Штиль
   }
   .N {
    transform: scaleY(1); /* Отражаем по вертикали юг */ 
   }
   
   .NE {
	   transform: rotate(45deg); /* Отражаем по вертикали Юго-Запад */
   }
   
   .E {
	   transform: rotate(90deg); /* Отражаем по вертикали Запад */
   }
   
   .SE{
	   transform: rotate(135deg); /* Отражаем по вертикали Северо-Запад */
   }
   
   .S {
	   transform: scaleY(-1); /* Отражаем по вертикали Север */
	  }
   .SW {
	   transform: rotate(225deg); /* Отражаем по вертикали Северо-Восток */
   }
   .W {
	   transform: rotate(270deg); /* Отражаем по вертикали Восток */
   }
   .NW {
	   transform: rotate(315deg); /* Отражаем по вертикали Юго-Восток */
   }
  </style>";
  
	$retern .='<p class = "pic"><img src="../data/weather_pic.png"</p>';//готов картинка
	
	//$retern .='<class = "pic"><img src="'.include ("weather_pic.php").'">';
	$retern .= '<table border=1>';
	// дату
	$retern .= '<tr class="datatext"><td height="44.4">Дата</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		$a=$res[$i]['date']['local'];
		$newDate = date("d.m.Y", strtotime($a));
		$retern .= '<td>' .$newDate. "<br>";
		//if ($z=0; )
		$retern .=  $days[date( 'N', strtotime($a) )] ;
		
	} 
	$retern .= '</tr>';
	//температуру
	$retern .= '<tr class="temperaturetext"><td height="44.4">T=Ощущается</td>';
	for ($i = 0; $i < count($res); $i++)
		if ($res[$i]['temperature']['comfort']['max']['C']==$res[$i]['temperature']['comfort']['min']['C'])
		{
			$retern .= '<td >'.$res[$i]['temperature']['comfort']['max']['C']. ' маx t<br>';
		}
		else 
		{
		$retern .= '<td>' .'от ' .$res[$i]['temperature']['comfort']['min']['C']. ' до '.$res[$i]['temperature']['comfort']['max']['C']. '</td>';
		} 
	$retern .= '</tr>';
	
	//температуру
	$retern .= '<tr class="temperaturetext"><td height="40">T=Воздуха</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		$retern .= '<td>'.$res[$i]['temperature']['air']['avg']['C'].'</td>';
	} 
	$retern .= '</tr>';
	
	//иконка
	$retern .= '<tr><td height="60">Иконка</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		$retern .= '<td><img src="../ico/'.$res[$i]['icon'].'.png"  ></td>';
	} 
	$retern .= '</tr>';
	
	//Давление
	$retern .= '<tr><td height="44.4">Давление</td>';
	for ($i = 0; $i < count($res); $i++)
		if ($res[$i]['pressure']['mm_hg_atm']['min']==$res[$i]['pressure']['mm_hg_atm']['max'])
		{
			$retern .= '<td>'.$res[$i]['pressure']['mm_hg_atm']['max']. ' мм.р.с<br>';
		}
		else
		{
		//$davlMM=$res[$i]['pressure']['mm_hg_atm']['max'];
		//$davlMM=$res[$i]['pressure']['mm_hg_atm']['min'];
		//$retern .= "<td>$davlMM "-"$davlMM мм.р.с  </td>";
		$retern .= '<td>'.$res[$i]['pressure']['mm_hg_atm']['min']. '-'.$res[$i]['pressure']['mm_hg_atm']['max']. ' мм.р.с</td>';
		} 
	$retern .= '</tr>';
	
	//Влажность
	$retern .= '<tr><td height="40">Влажность</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		$retern .= '<td>'.$res[$i]['humidity']['percent']['avg'].'%</td>';
	} 
	$retern .= '</tr>';
	
	//Осадки
	// type  Тип осадков
	// 0 	Нет осадков
	// 1 	Дождь
	// 2 	Снег
	// 3 	Смешанные осадки
	// amount  Количество осадков в мм.
	// intensity   Интенсивность осадков
	// 0 	Нет осадков
	// 1 	Небольшой дождь / снег
	// 2 	Дождь / снег
	// 3 	Сильный дождь / снег
	$retern .= '<tr><td height="44.4">Осадки</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		if ($res[$i]['precipitation']['intensity'] == 0) {
			$retern .= '<td>Нет осадков</td>';
			} else {
			switch ($res[$i]['precipitation']['type']) {
				case 1:	$retern .= "<td>Дождь<br>".$res[$i]['precipitation']['amount']." мм.</td>";
				break;
				case 2:	$retern .= "<td>Снег<br>".$res[$i]['precipitation']['amount']." мм.</td>";
				break;
				case 3:	$retern .= "<td>Смешанные осадки<br>".$res[$i]['precipitation']['amount']." мм.</td>";
				break;
			}
		}
		
	} 
	$retern .= '</tr>';
	
	$retern .= '</tr>';	
	//Ветер
	// 0 	Штиль
	// 1 	Северный
	// 2 	Северо-восточный
	// 3 	Восточный
	// 4 	Юго-восточный
	// 5 	Южный
	// 6 	Юго-западный
	// 7 	Западный
	// 8 	Северо-западный
	$retern .= '<tr><td height="44.4">Ветер</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		switch ($res[$i]['wind']['direction']['max']['scale_8']) {
			case 0:	$retern .= "<td>Штиль<br>".'<img src="../ico/круг.png" width="55" height="55" alt="Штиль" class="Calm">';   // также добавить штиль
			break;
			case 1:	$retern .= "<td>Северный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Север" class="S">';
			break;
			case 2:	$retern .= "<td>Северо-восточный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Север-Восток" class="SW">';
			break;
			case 3:	$retern .= "<td>Восточный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Восток" class="W">';
			break;
			case 4:	$retern .= "<td>Юго-восточный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Юго-Восток" class="NW">';
			break;
			case 5:	$retern .= "<td>Южный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Юг" class="N">';
			break;
			case 6:	$retern .= "<td>Юго-западный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Юго-Запад" class="NE">';
			break;
			case 7:	$retern .= "<td>Западный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Запад" class="E">';
			break;
			case 8:	$retern .= "<td>Северо-западный<br>".'<img src="../ico/24215.png" width="25" height="25" alt="Северо-Запад" class="SE">';
			break;
		} 
			
		if ($res[$i]['wind']['direction']['max']['scale_8'] != 0 and $res[$i]['wind']['speed']['min']['m_s']==$res[$i]['wind']['speed']['max']['m_s'])	
		{
			$retern .= "<br>".$res[$i]['wind']['speed']['max']['m_s'].' м/с';
		} 
		else if ($res[$i]['wind']['direction']['max']['scale_8'] != 0 and $res[$i]['wind']['speed']['min']['m_s']<>$res[$i]['wind']['speed']['max']['m_s'])
		{
			
			$retern .= '<br>'.$res[$i]['wind']['speed']['min']['m_s']. '-'.$res[$i]['wind']['speed']['max']['m_s']. ' м/c';
		}
		$retern .= "</td>";
	}	
	$retern .= '</tr>';	
	
	/* //Облачность
	// 0 	Ясно
	// 1 	Малооблачно
	// 2 	Облачно
	// 3 	Пасмурно
	// 101 	Переменная облачность
	$retern .= '<tr><td>Облачность</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		switch ($res[$i]['cloudiness']['type']) {
			case 0:	$retern .= "<td>Ясно<br>";
			break;
			case 1:	$retern .= "<td>Малооблачно<br>".$res[$i]['cloudiness']['percent'].'%</td>';
			break;
			case 2:	$retern .= "<td>Облачно<br>".$res[$i]['cloudiness']['percent'].'%</td>';
			break;
			case 3:	$retern .= "<td>Пасмурно<br>".$res[$i]['cloudiness']['percent'].'%</td>';
			break;
			case 101:	$retern .= "<td>Переменная облачность<br>".$res[$i]['cloudiness']['percent'].'%</td>';
			break;	
		} 
	} 
	$retern .= '</tr>'; */	
	
	/* //Описание
	$retern .= '<tr><td>Описание</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		$retern .= '<td>'.$res[$i]['description']['full'].'</td>';
	} 
	$retern .= '</tr>'; */
	
	//Геомагнитное поле
	// 1 	Нет заметных возмущений
	// 2 	Небольшие возмущения
	// 3 	Слабая геомагнитная буря
	// 4 	Малая геомагнитная буря
	// 5 	Умеренная геомагнитная буря
	// 6 	Сильная геомагнитная буря
	// 7 	Жесткий геомагнитный шторм
	// 8 	Экстремальный шторм
	$retern .= '<tr><td height="44.4">Геомагнитное поле</td>';
	for ($i = 0; $i < count($res); $i++)
	{
		switch ($res[$i]['gm']) {
			case 1:	$retern .= "<td>Нет заметных возмущений</td>";
			break;
			case 2:	$retern .= "<td>Небольшие возмущения</td>";
			break;
			case 3:	$retern .= "<td>Слабая геомагнитная буря</td>";
			break;
			case 4:	$retern .= "<td>Малая геомагнитная буря</td>";
			break;
			case 5:	$retern .= "<td>Умеренная геомагнитная буря</td>";
			break;
			case 6:	$retern .= "<td>Сильная геомагнитная буря</td>";
			break;
			case 7:	$retern .= "<td>Жесткий геомагнитный шторм</td>";
			break;
			case 8:	$retern .= "<td>Экстремальный шторм</td>";
			break;	
		}
	} 
	
	$retern .= '</table>' ;
	return $retern;
}

ob_start();
$output = testGismetio();

$file = fopen("../data/weather.html","wt") or die("err");
fputs($file,$output);
fclose($file);
?>	