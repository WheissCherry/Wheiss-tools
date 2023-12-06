<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_path_1 = $_POST["user_path_1"]??'';
	$user_path_2 = $_POST["user_path_2"]??'';
	$arr_data = $_POST["arr_data"]??'';
	$scheme = $_POST["scheme"]??'';
	if (strlen($user_path_1)>100||strlen($user_path_2)>40) {
		die("Path or suffix's length has exceeded!");
	} else if (empty($arr_data)) {
		die("Please input your php array data.");
	}
	if ($scheme == ''){
		$pattern = "/.*['\"](\w+)['\"].+>.+\/\/(.*)/";
	} else {
		$pattern = "/.+>.*['\"](\S+)['\"].*\/\/(.*)/";
	}
	if (preg_match_all($pattern,$arr_data,$matches)){
		for($i = 0; $i < count($matches[1]); $i++){
			echo $matches[2][$i].','.$user_path_1.$matches[1][$i].$user_path_2.PHP_EOL;
		}
	}
}
?>
