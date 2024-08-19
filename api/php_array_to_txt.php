<?php
//非法请求
if ($_SERVER["REQUEST_METHOD"] !== "POST") die(header('HTTP/1.1 403'));
$user_path_1 = $_POST["user_path_1"]??'';
$user_path_2 = $_POST["user_path_2"]??'';
$arr_data = $_POST["arr_data"]??'';
$scheme = $_POST["scheme"]??'';
$scheme2 = $_POST["scheme2"]??'';
//异常处理
if (strlen($user_path_1)>100||strlen($user_path_2)>40) {
	die("Path or suffix's length has exceeded!");
} else if (empty($arr_data)) {
	die("Please input your php array data.");
}
//预处理
if ($scheme2 == ''){
	$arr_data = preg_replace("/^\s*\/\/.+/m",'',$arr_data);//因为使用了^只会匹配一次(字符串的开始)，所以要开启多行模式
	$arr_data = preg_replace("/^\s*#.+/m",'',$arr_data);
	$arr_data = preg_replace("/.*\/\*.+[^\*]+\*\//",'',$arr_data);
} else {
	$arr_data = str_replace('*/','',$arr_data);
}
//非指向型数组模式
if (strpos($arr_data,'>') === false){//非指向型数组
	if (preg_match('/[^\s]+\s*\/\/.+/',$arr_data,$matches)){//有频道名注释
		if ($scheme == ''){
			preg_match_all('/[^\s]+\s*\/\/(.+)/',$arr_data,$matches);
			for($i = 0; $i < count($matches[1]); $i++){
				echo $matches[1][$i].','.$user_path_1.$i.$user_path_2.PHP_EOL;
			}
		} else {
			preg_match_all('/.*[\'"](.+)[\'"].*\/\/(.+)/',$arr_data,$matches);
			for($i = 0; $i < count($matches[1]); $i++){
				echo $matches[2][$i].','.$user_path_1.$matches[1][$i].$user_path_2.PHP_EOL;
			}
		}
	} else {//无'//频道名'注释
		echo 'Unsupported format!'.PHP_EOL;
	}
} else {//指向型数组
	if ($scheme == ''){
		$pattern = "/.*['\"](\S+)['\"].+>.+\/\/(.*)/";
	} else {
		$pattern = "/.+>.*['\"](\S+)['\"].*\/\/(.*)/";
	}
	if (preg_match_all($pattern,$arr_data,$matches)){
		for($i = 0; $i < count($matches[1]); $i++){
			echo $matches[2][$i].','.$user_path_1.$matches[1][$i].$user_path_2.PHP_EOL;
		}
	} else {//无'//频道名'注释
		echo 'Unsupported format!'.PHP_EOL;
	}
}
?>
