
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
   //echo php_ini_loaded_file();  
 $ret=array();
function resize($path_file, $filename) { 
	
	$size = getimagesize($path_file);
	if ($size["mime"]=='image/jpeg')
	$file=imagecreatefromjpeg($path_file);
	elseif($size["mime"]=='image/png')
	$file=imagecreatefrompng($path_file);
	elseif($size["mime"]=='image/gif')
	$file=imagecreatefromgif($path_file);
	elseif($size["mime"]=='image/vnd.wap.wbmp')
	$file=imagecreatefromwbmp($path_file);
	else die('Выбран не правильный формат изображения');
	// Ограничение по ширине
	$max_size = 600;
	
	// Качество изображения по умолчанию
	//if ($quality == null)
	$quality = 75;
	
	// Определение ширины и высоты изображения
	//load $src
	$w_src = $size[0];
    $h_src = $size[1];
	
	// Вычисление пропорций
	 if ($w_src <> $max_size)
 {
    $ratio = $w_src/$max_size;
    $w_dest = round($w_src/$ratio);
    $h_dest = round($h_src/$ratio); 
 }
	
	$scale = imagescale ($file, $w_dest, -1, IMG_BILINEAR_FIXED);
	$random=rand(10000,99999);
	imagejpeg($scale, '../data/'.$random.$filename);
	
	return $random.$filename;
 // Вывод картинки и очистка памяти
 //imagejpeg($src, $tmp_path . $file['name'], $quality);
 //imagedestroy($src);
 //return $file['name'];
 //unlink($tmp_path . $name);

}

function download($file) {	
	// Путь к файлу $path_file, второй параметр $filename, 
$sev_type=$file["type"];
if (strpos($sev_type,'image')=== false) {
	$ret['status']= "Error";
	$ret['message']= "Загружаемый файл не является изображением";
	return (($ret));
}
$filename = '../temp/'.$file['name'];
$Temp=$file['tmp_name'];
	
//Проверка переместился ли файл в temp
if(is_uploaded_file($file['tmp_name'])) {
	move_uploaded_file($Temp, $filename);
}
	else {
		$ret['status']= "Error";
		$ret['message']= "Файл не загружен";
		return (($ret));
	}
	
	//проверка существования файла на сервере
	if (file_exists($filename)) {
		$put_kartinka=resize($filename, $file['name']);
		$ret['status']= "Ok";
		$ret['message']= $put_kartinka;
		return (($ret));
	} 
	else {
		$ret['status']= "Error";
		$ret['message']= "Файла нет на сервере";
		return (($ret));
	}
	}
	
	//download();
	
	//$ret['status']= 'ok', 'error'
	//$ret['message']= если Ок то возвращает путь к готовой картинке, Если не Ок возвращаем ошибку
	
	// при одинаковых названиях чтобы создавало новый файл а не перезаписывало
	// md5_file ( string $filename [, bool $raw_output = FALSE ] ) : string
?>