
<!--	include("config.php");// подключение паролей для бд.

	$ip = $_SERVER['REMOTE_ADDR'];

	$mask = substr($ip, 0, 7);

	$db = mysqli_connect($dbhost, $dbuser, $dbpassword, $database) or die("Connection Error: " . mysqli_error($db));
	//проверяем если человек в черном списке или нет
	$res=mysqli_query($db,"SELECT user_ip FROM black_list_id WHERE user_ip='$ip'");
	if (mysqli_fetch_assoc($res)==NULL){  //echo поменять на die.

		//проверка ip 
		//if ($mask=="172.19."){
		
		$result = mysqli_query($db, "INSERT INTO `access_error` (ip,date) VALUES
			('$ip',NOW())") or die("Couldn't execute query. >>>" . "INSERT INTO `access_error` (ip,date) VALUES
			('$ip',NOW())" . "<<<< " . mysqli_error($db));
		$result = mysqli_query($db, "SELECT COUNT(id) from (access_error ) where (date) >= (now()- 300)") or die("Couldn't execute query. >>>" . "SELECT COUNT(id) from (access_error ) where (date) >= (now()- 5 min)" . "<<<< " . mysqli_error($db));
		
		$visit=mysqli_fetch_array($result);
		//var_dump ($visit);
		
		if ($visit[0]>5) {
			$result = mysqli_query($db, "INSERT INTO `black_list_id` (user_ip,date) VALUES
			('$ip',NOW())") or die("Couldn't execute query. >>>" . "INSERT INTO `black_list_id` (user_ip,date) VALUES
			('$ip',NOW())" . "<<<< " . mysqli_error($db));
		}
		
		
		if (isset($_POST['submit'])) { // если происходит сабмит формы
		function generateCode ($length = 6)
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
			$code = "";
			$clen = strlen($chars) - 1;
			while (strlen($code) < $length) {
				$code .= $chars[mt_rand(0, $clen)];
			}
			return $code;
		}


		for ($i = 0; $i < 7; $i++) {
			$x .= $ip[$i];
		}

		$SQL = "SELECT * FROM users WHERE user_login='" . mysqli_real_escape_string($db, $_POST['login']) . "' LIMIT 1";
		$query = mysqli_query($db, $SQL) or die($SQL . "|Couldn't execute query." . mysqli_error($db));;
		$data = mysqli_fetch_assoc($query);
		# Сравниваем пароли
		if ($data['user_password'] === md5(md5($_POST['password'])))//Авторизация пройдена
		{
			# Генерируем случайное число и шифруем его
			$hash = md5(generateCode(10));
			$id = $data['user_id'];
			# Записываем в БД новый хеш авторизации и IP
			$result = mysqli_query($db, "UPDATE users 
			SET 
			user_ip='$ip' ,
			user_hash='$hash',
			date=NOW()
			WHERE user_id =$id") or die("Couldn't execute query. >>>" . "UPDATE users 
			SET 
			user_ip='$ip' ,
			user_hash='$hash'
			WHERE user_id =$id" . "<<<< " . mysqli_error($db));
			# Ставим куки
			setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30);
			setcookie("group_id", $data['group_id'], time() + 60 * 60 * 24 * 30);
			setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);
			//setcookie("date", $Date,time() + 60 * 60 * 24 * 30);
			

			$db->close();
			//if ($x != "197.19."){
			# Обновляем страницу с данными авторизации
			header("Location: /admin.php");
			exit();
			//} //or die ("Не та сеть");
			//else{echo '<h1 align="center" style="color:red;">Ты левый чорт!!!</h1>';}
		} else//Авторизация отклонена обнуляем куки
		{
			setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
			setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
			setcookie("group_id", "", time() - 3600 * 24 * 30 * 12, "/");
			echo '<h1 align="center" style="color:red;">Вы ввели неверный логин/пароль</h1>';
		}
	}

	//print_r($_COOKIE);
	// ПРОВЕРКА хеша куков у уюера если не совпадет то обнуляем куки
	if ((isset($_COOKIE['hash'])) and (isset($_COOKIE['id']))) {
		$user_id = $_COOKIE['id'];
		$hash = $_COOKIE['hash'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$SQL = "SELECT user_hash,user_ip from `users` WHERE user_id = $user_id ";
		$result = mysqli_query($db, $SQL) or die($SQL . "|Couldn't execute query." . mysqli_error($db));
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		if (($row['user_hash'] != $hash) and ($row['user_ip'] != $ip)) {
			$_COOKIE['id'] = 0;
		}
		$read="update users 
		set date = now()
		where user_id = $user_id";
		$reqe = mysqli_query($db, $read) or die($read . "|Couldn't execute query." . mysqli_error($db));
	}
	// если уже есть человек в black_list_ip то посылать нахер и когда было определенное количество заходов более 5 послать нахер.if отдельным условием //and ($x == '172.19.') или вытаскиваем user_ip из бд и сравниваем

	// если куки обнулены или их нет то выводим форму ввода логопароля
	if ((!(isset($_COOKIE['id']))) or ((int)$_COOKIE['id'] == 0)) {
		$STR = '<h1 style="color: red;" align="center">Не авторизовано</h1>
			<h2 align="center">Авторизуйтесь в системе</h2>
			<div style="position: fixed;top: 180px;left: 50%;width: 250px; height:80px; background: #f0f0f0;transform: translate(-50%, 0%);padding: 15px;">
			<form method="POST" class=""  >
			<div style="padding-bottom:10px;">
				<label for="login">Логин</label>
				<input name="login" style="float:right;width:140px;" type="text">
			</div>
			<div style="padding-bottom:10px;">
				<label for="password">Пароль</label>
				<input name="password" style="float:right;width:140px;" type="password">
			</div>
			<div style="margin:auto;padding:10px;width:50px;">
				<input name="submit" value="Войти" type="submit">
			</div>
			</form></div>';
		die($STR);
	}

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	//} die ("Нельзя");
	//} die ("Вы в черном списке");-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<title>Админка</title>
	<script src="/js/JQ/external/jquery/jquery.js" type="text/javascript"></script>
	<script src="/js/JQ/jquery-ui.js" type="text/javascript"></script>
	<link href="/js/JQ/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<link href="/js/JQ/jquery-ui.structure.css" rel="stylesheet" type="text/css"/>
	<link href="/js/JQ/jquery-ui.theme.css" rel="stylesheet" type="text/css"/>
	<!--jqGrid-->
	<script src="/js/jqGrid/src/jquery.jqGrid.js" type="text/javascript"></script>
	<link href="/js/jqGrid/css/ui.jqgrid.css" rel="stylesheet" type="text/css"/>
	<script src="/js/jqGrid/js/i18n/grid.locale-ru.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/grid.addons.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/grid.postext.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/grid.setcolumns.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/jquery.contextmenu.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/jquery.searchFilter.js" type="text/javascript"></script>
	<script src="/js/jqGrid/plugins/jquery.tablednd.js" type="text/javascript"></script>
	<link href="/js/jqGrid/plugins/searchFilter.css" rel="stylesheet" type="text/css"/>
	<link href="/js/jqGrid/plugins/ui.multiselect.css" rel="stylesheet" type="text/css"/>
	<script src="/js/jqGrid/plugins/ui.multiselect.js" type="text/javascript"></script>
	<!-- style-->
	<style>
		#divfilds1 {
			display: inline-block;
			margin: 3px 10px 10px 0px;
			border: 2px;
			width: 800px;
			height: 70px;
			border: 1px solid black;
			padding: 10px;
		}

		#fildsmin {
			display: inline-block;
			float: left;
			border: 2px;
			width: 150px;
			height: 50px;
		}

		#divfilds2 {
			margin: 3px 10px 10px 0px;
			clear: both;
			border: 2px;
			width: 800px;
			height: 70px;
			border: 1px solid black;
			padding: 10px;
		}
		#fugura{
			display: inline-block;
			margin: 3px 10px 10px 0px;
			border: 2px;
			width: 1200px;
			height: 95%;
			border: 1px solid black;
			padding: 10px;
			background: #ebcacb;
		}
		#Open_People {
			text-decoration: none;
			outline: none;
			display: inline-block;
			padding: 10px 15px;
			margin: 5px 10px;
			position: relative;
			color: white;
			border: 1px solid rgba(100,100,100,.8);
			background: none;
			font-weight: 300;
			font-family: "Montserrat", sans-serif;
			text-transform: uppercase;
			letter-spacing: 2px;
		}
		#Open_People:hover {background: rgba(255,255,255,.2);}
		
		#Open_Black {
			text-decoration: none;
			outline: none;
			display: inline-block;
			padding: 10px 15px;
			margin: 5px 10px;
			position: relative;
			color: Black;
			border: 1px solid rgba(100,100,100,.8);
			background: none;
			font-weight: 300;
			font-family: "Montserrat", sans-serif;
			text-transform: uppercase;
			letter-spacing: 2px;
		}
		#Open_Black:hover {background: rgba(255,255,255,.2);}
	</style>
	<!--tinymce-->
	<script src="/js/tinymce/tinymce.min.js" type="text/javascript"></script>
	<script src="/js/tinymce/langs/ru.js" type="text/javascript"></script>
	<!--MY<script src="/js/list.js" type="text/javascript"></script>-->
	<script src="/js/core.js" type="text/javascript"></script>
	<script src="/js/potkl.js" type="text/javascript"></script>
	

</head>
<body>
<form id="glawa">
<div id="fugura">
<input type="button" value="Пользователи" id="Open_People" OnClick="OpenAdding_People()">
	
	
	<div id="Adding_People" title="Добавление записи">
	<table width="60%" id="tableusers"></table>
	<div id="result"></div>
</div>

<input type="button" value="Черный список" id="Open_Black" OnClick="Open_black_list()">
<div id="Black" title="Черный список">
	<table width="60%" id="tableblack"></table>
	<div id="gogo"></div>
	</div>

	
	
<table width="80%" id="editgrid"></table>
<div id="pagered"></div>
</div>
</form>

<div id="dialog-form" title="Добавление записи">

	<form id="form1">
		<div id="divfilds1">
			<label for="Name">Имя</label> <br><input type="text" name="Name" id="Name" value=" " style="width:255px;">
		</div>
		<div id="divfilds1">
			<div id="fildsmin">
				<label for="Position">Номер позиции</label>
				<input type="text" style="width:50px" name="Position" id="Position" value="" disabled>
			</div>

			<div id="fildsmin">
				<label>Состояние</label> <select id="Disable" name="Disable">
					<option value="1">Вкл</option>
					<option value="0">Выкл</option>
				</select>
			</div>

			<div id="fildsmin">
				<label>Повтор</label> <select id="Replay" name="Replay">
					<option value="0">Выкл</option>
					<option value="1">Раз в день</option>
					<option value="2">Раз в месяц</option>
					<option value="3">Раз в год</option>
				</select>
			</div>

			<div id="fildsmin" style="width:350px">
				<label for="Delay" style="width:350px">Время отображения в секундах</label>
				<input type="number" min="0" name="Delay" id="Delay" value=" " style="width:100px">
			</div>
		</div>

		<div id="divfilds2">
			<div id="fildsmin">
				<label for="Begin">Дата начала</label>
				<input type="text" name="Begin" id="Begin" value=" " style="width:100px">
			</div>
			<div id="fildsmin">
				<label for="End">Дата конца</label>
				<input type="text" name="End" id="End" value=" " style="width:100px">
			</div>
		</div>

		<div>
			<br>
			<div>
				<label>Тип </label> <br><label for="Type-1">Изображение</label>
				<input type="radio" name="Type" id="Type-1"> <br><label for="Type-2">Текст</label>
				<input type="radio" name="Type" id="Type-2"> <br><label for="Type-3">Погода</label>
				<input type="radio" name="Type" id="Type-3">
			</div>
			<br>
			<div id="tabs-1">

			</div>
		</div>

		<div style="width:1px; height:1px;">
			<input type="hidden" name="Id" id="Id" value=" ">

		</div>


		<input id="Add" type="submit" tabindex="-1" style="position:absolute; top:-1000px">

	</form>
</div>


</body>

</html>;
//die($SCR);
	//} die ("Не та сеть"); для проверки по id
//	} die ("Вы в черном списке");
//?>
<script>
  //  function deleteCookie() { // скрипт на кнопку ВЫХОД
    //    document.cookie = "id=''";
      //  document.cookie = "hash=''";
        //document.cookie = "group_id=''";
        //location.href = 'index.php';
    }
</script>