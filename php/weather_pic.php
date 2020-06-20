<?php
/* Размеры экраны */
 $x_h=1500;    //1920
 $y_h=630;   //1080
 
 /* Переменные */
 $fale_name= "../data/weather_pic.png"; //Путь к картинке с графиком
 $pre="";
 $x_initial="";
 $x=round($x_h*(1/30.4))+5;
 $x_step =(round($x_h*(49.5/50.5))-round($x_h*(1/30.4)))/24 ;
 $p=15;
 $y=22;
 $Dates = [];
 $osad = array();
 $rs = array();
 
 //if (file_exists($fale_name)){ unlink($fale_name);// удаление картики для перезаписи графика} else { }
	
 if ($_SERVER['DOCUMENT_ROOT']="W:/domains/localhost")
 {
	$pre=$_SERVER['DOCUMENT_ROOT'].'/pChart2.1.4/';
 }
	
 include("../pChart2.1.4/class/pData.class.php");  /* Include the pData class */ 
 include("../pChart2.1.4/class/pDraw.class.php");
 include("../pChart2.1.4/class/pImage.class.php");

 $api_key='59f20cc12d9896.24642531';	
 $basicurl="https://api.gismeteo.ru/v2/weather/forecast/?latitude=61.666668&longitude=50.816666&days=3" ; // запрос с помощью координат ширины и долготы
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $basicurl);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Gismeteo-Token: '.$api_key));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 $json_reply =curl_exec($ch);
 curl_close($ch);
	 
 //echo $json_reply;
	 
 $json = json_decode($json_reply,true);
 $res=$json['response'];	
	
 for ($i = 0; $i < count($res); $i++)
 {
	$a=$res[$i]['date']['local'];
	$newDate = date("d.m.Y", strtotime($a));
	echo  $days[date( 'N', strtotime($a) )] ;
	$Dates[]= $newDate;
 }
	
 $Number1Date = $Dates[0]; // Вывод даты в textBox1
 $Number2Date = $Dates[8];
 $Number3Date = $Dates[16];
	
 //Воздух температура
 for ($i = 0; $i < count($res); $i++)
 {
	$aT[]=$res[$i]['temperature']['air']['C'];
 }
 
 $max = max($aT); // поиск максимального значения температуры
 $mins = min($aT);
 if ($mins > 0 )
 {
	 $mins = 0;
	 }
 $min = min($aT)-100; // поиск минимального значения температуры
	
 for ($i=0;$i<25;$i++)//цикл для настройки нежнего значения для BarChar
 {
	$osad[]=round($min,0);
 }
 
 //Осадки
 for ($i = 0; $i < count($res); $i++)
 {
	$tOs=$res[$i]['precipitation']['amount'];
	if($tOs>0)
	{
		$aO[]=$tOs-abs(round($mins));
		$aE[]=$tOs;
		
	}
	 else
	{
		if ($aO[$i]==0)
			{
				$aO[$i]=NULL;
				$aE[]=$tOs;
			}
	} 
 }
 
 /* CAT:Line chart */
 
 /* Create the pData object */
 $MyData = new pData(); 
 $MyData->addPoints($aO,"Осадки"); //создает ряд точек 
 $MyData->addPoints($aT,"Температура"); //создает ряд точек 
//$MyData->addPoints(array("-5","-13","-36","-25","-32","-4","-45","-27","-12","-44","-3","-14","-35","-21","-34","-25","-40","-7","-21","-33","0","-5","-17","-9"),"Температура");
 $MyData->setSerieWeight("Probe 1",2); // рисовать график с указанным весом px
 $MyData->setAxisName(0,"Температура"); // пишем имя оси y
 $MyData->addPoints(array("00:00","03:00","06:00","9:00","12:00","15:00","18:00","21:00","00:00","03:00","06:00","9:00","12:00","15:00","18:00","21:00","00:00","03:00","06:00","9:00","12:00","15:00","18:00","21:00"),"Labels");
 $MyData->setSerieDescription("Labels","la"); //запихать сюда числа
 $MyData->setAbscissa("Labels");
 $MyData->setPalette("Осадки",array("R"=>135,"G"=>206,"B"=>235));
 
  /* Create the floating 0 data serie */
 $MyData->addPoints($osad,"Floating 0");
 $MyData->setSerieDrawable("Floating 0",FALSE);
 
 /* Create a pChart object and associate your dataset */
 $myPicture = new pImage($x_h,$y_h,$MyData);
 
 /* Create a solid background */
 $Settings = array("R"=>0, "G"=>0, "B"=>0, "Dash"=>FALSE, "DashR"=>199, "DashG"=>237, "DashB"=>111);
 $myPicture->drawFilledRectangle(0,0,$x_h,$y_h,$Settings);
 
 /* Do a gradient overlay (Сделать градиент наложения) */
 $Settings = array("StartR"=>255, "StartG"=>255, "StartB"=>255, "EndR"=>255, "EndG"=>255, "EndB"=>255, "Alpha"=>255);
 $myPicture->drawGradientArea(0,0,$x_h,$y_h,DIRECTION_VERTICAL,$Settings);
 $myPicture->drawGradientArea(0,0,$x_h,round($y_h*(1/32.5)),DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));

 /* Add a border to the picture */
 $myPicture->drawRectangle(0,0,$x_h-1,$y_h-1,array("R"=>0,"G"=>0,"B"=>0));
 
 /* Write the picture title Напишите название картинки*/ 
 $myPicture->setFontProperties(array("FontName"=>$pre."fonts/times.ttf","FontSize"=>14));
 $myPicture->drawText(round($x_h*(1/150)),round($y_h*(1/36)),"График погоды представлен сайтом Gismeteo.Последние обновление данных ".date("d.m.Y H:i"),array("R"=>255,"G"=>255,"B"=>255));
 
 /* Draw the scale */
 $AxisBoundaries = "";
 $AxisBoundaries[0] = array("Min"=>$mins,"Max"=>$max+3);
 $myPicture->setFontProperties(array("FontName"=>$pre."fonts/times.ttf","FontSize"=>11));
 $myPicture->setGraphArea(round($x_h*(1/30.4)),round($y_h*(1/6.5)),round($x_h*(49.5/50.5)),round($y_h*(9.8/10.8)));//здесь устанавливаются координаты прямоугольника верх
 $myPicture->drawFilledRectangle(round($x_h*(1/30.4)),round($y_h*(1/6.5)),round($x_h*(49.5/50.5)),round($y_h*(9.8/10.8)),array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
 $myPicture->drawScale(array("Mode"=>SCALE_MODE_MANUAL,"ManualScale"=>$AxisBoundaries,"CycleBackground"=>TRUE,"RemoveXAxis"=>FALSE,"GridR"=>0,"GridG"=>0,"GridB"=>0));

  /* Turn on Antialiasing */
 $myPicture->Antialias = TRUE; //включение сглаживания
 
 /* Draw the bar chart chart (Рисуем гистограмму)*/
 $myPicture->setFontProperties(array("FontName"=>$pre."fonts/times.ttf","FontSize"=>16));
 $MyData->setSerieDrawable("Температура",FALSE);                                       
 $myPicture->drawBarChart(array("Floating0Serie"=>"Floating 0","DisplayColor"=>DISPLAY_AUTO,"DisplayValues"=>FALSE,"Rounded"=>TRUE,"Surrounding"=>60,"Floating0Value"=>""));

 /* Draw the line and plot chart (линия на графике) */
 $MyData->setSerieDrawable("Температура",TRUE);
 $MyData->setSerieDrawable("Осадки",FALSE);
 $myPicture->drawSplineChart();
 $myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));

 /* Write some text */
 $TextSettings = array("DrawBox"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>18);// Вывод даты 
 $myPicture->drawText($x,round($y_h*(127/130)),"$Number1Date",$TextSettings);
 $TextSettings = array("DrawBox"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>18);
 $myPicture->drawText($x+($x_step*8),round($y_h*(127/130)),"$Number2Date",$TextSettings);
 $TextSettings = array("DrawBox"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>18);
 $myPicture->drawText($x+($x_step*16),round($y_h*(127/130)),"$Number3Date",$TextSettings); 
 
 /* Make sure all series are drawable before writing the scale */
 $MyData->setSerieDrawable("Осадки",TRUE);
 
 /* Write the legend Рисует лигенду*/
 $myPicture->drawLegend(round($x_h*(12.5/15)),round($y_h*(25/26)),array("Style"=>LEGEND_ROUND,"Alpha"=>20,"Mode"=>LEGEND_HORIZONTAL)); 
 $myPicture->setShadow(FALSE);
 
 $TextSettings = array("DrawBox"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>14);
  
 for ($i = 0; $i < 24; $i++)
 {
	$x_initial=$x_initial+$x_step;
	$p=$p+($x_step-0.5);
	$z=92;
	$myPicture->drawFromPNG($x_initial,$y,"../ico/".$res[$i]['icon'].".png");
	if ($aE[$i] <> 0) {
		$myPicture->drawText($p,$z,$aE[$i],$TextSettings);
	}
 }
 $myPicture->drawFromPNG(0,$y,"../ico/znak_gis.png");
 
 $myPicture->render("../data/weather_pic.png");
?>