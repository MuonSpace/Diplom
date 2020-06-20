
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>1</title>

<script type="text/javascript" src="/js/JQ/external/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/JQ/jquery-ui.js"></script>
<link  href="/js/JQ/jquery-ui.css" rel="stylesheet" type="text/css"   /> 
<link  href="/js/JQ/jquery-ui.structure.css" rel="stylesheet" type="text/css"   /> 
<link  href="/js/JQ/jquery-ui.theme.css" rel="stylesheet" type="text/css"   /> 
<!--<script src="jquery-1.9.1.min.js"> -->

<style>
#clock{
    position: fixed;
    left: 1; top: 1;
	padding: 4px; 
	background: #FFE4B5; 
	opacity: 0.6;
	color: #4169E1;
	font-weight: bold;
	font-size: 20px;
}
/* Цвет и расположение таймера */
#timer_inp{
    position: fixed;
    left: 1; bottom: 0; 
    padding: 9px; 
    background: #EEE8AA; 
	opacity: 0.6;
    color: #fffff; 
    width: 20px;
	height: 20px;
	border-radius: 30px;
}
</style>

<script type="text/javascript">

$(document).ready(function() {
	//// Часики
	window.onload = function(){
	window.setInterval(function(){
		
		var timeStr, dateStr;	
		var now= new Date();

		var hours= now.getHours();
		var minutes= now.getMinutes();
		var seconds= now.getSeconds();
		timeStr= ((hours < 10) ? "0" : "") + hours;   
		timeStr+= ((minutes < 10) ? ":0" : ":") + minutes;  
		timeStr+= ((seconds < 10) ? ":0" : ":") + seconds;  
		var date= now.getDate();
		var month= now.getMonth()+1;
		var year= now.getFullYear();
		dateStr= ((date < 10) ? "0" : "") + date;  
		dateStr+= "." + ((month < 10) ? "0" : "") + month;  
		dateStr+= "." + year;  
		var clock = document.getElementById("clock");
		clock.innerHTML =dateStr+' '+timeStr;
	}, 1000);
	}
	
	/// Загрузка нового контента
	var Delay = 2000;
	var id = -1
	var urlD = '';
	function updateContent() {
		var jqxhr = $.ajax({
			async: true,
			cache: false,
			url: urlD+'update.php?id='+id,
			dataType:"json",
		})  
		.done(function(data ) {
			//console.log("success");
			//console.log(data);
			//// разбираем данные 
			//var inf = JSON.parse(data)
			//console.log(inf);
			for (key in data) {
				//    console.log( key +':'+data[key]);
					var sdata = data[key]
					for (key2 in sdata) {
							//console.log(sdata['Delay']);
							console.log('id:'+sdata['id']+'|Delay:'+sdata['Delay']+'|Type:'+sdata['Type']);
							Delay = sdata['Delay']*1000;
							id = sdata['id'];
							var type_content = sdata['Type'];
							if (type_content == 'pic') {
								$('#content').empty();
								$('#content').html('<img src="data/'+sdata['Content']+'" alt=""></img>');
							}
							if (type_content == 'html') {
								$('#content').empty();
								$('#content').html(sdata['Content']);
							}
							if (type_content == 'weather') {
								$('#content').empty();
								jQuery.ajax({
									url: "data/weather.html",
									dataType: "html",
									success: function(response) {
									document.getElementById('container1').innerHTML = response;
									}
								});
								$('#content').html('<div id="container1"> </div>');
								
							
							}
					
					}
			}
			
		})
		.fail(function(jqXHR, textStatus) {
			console.log("Request failed: " + textStatus);
			////запускаем в рекурсию заного	
			//setTimeout(updateContent(),10000);// тут нужно поставить делей из ответа Delay
		 })
		 
		return  Delay;
	
	};
	
	var timerS = Delay/1000;
	//Таймер задержки
	function timer(){
	     timerS--;
		 console.log(timerS);
		 $('#timer_inp1').html(timerS);
		if(timerS==0){
			timerS = Delay/1000;
			setTimeout(timer,1000);
		
		}
		else{setTimeout(timer,1000);}
		}
		setTimeout(timer,1000);

		
		
	var timerId = setTimeout(function tick() {
		clearTimeout(timerId);
		Delay = updateContent();
	//	console.log(Delay);
		timerId = setTimeout(tick, Delay);
		
	}, Delay);
	
	
	
	
	
	
	
	
})


</script>

</head>
<body>
<div id="header">
<div id="clock"></div>

<div id="timer_inp"><span id="timer_inp1" style="display: block; text-align: center;font-size: 18px; "></span></div>

</div>
<div id="content">
</div>
</body>
</html>