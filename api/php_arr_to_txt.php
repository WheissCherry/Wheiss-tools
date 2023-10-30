<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_path = $_POST["user_path"]??'';
	$arr_data = $_POST["arr_data"]??'';
	$scheme = $_POST["scheme"]??'';
	if (strlen($user_path)>80) {
		die("Address length is exceeded!");
	} else if (empty($arr_data)) {
		die("Please input your array data.");
	}
	if ($scheme == ''){
		$pattern = "/.*['\"](\w+)['\"].+>.+\/\/(.*)/";
	} else {
		$pattern = "/.+>.*['\"](\S+)['\"].*\/\/(.*)/";
	}
	if (preg_match_all($pattern,$arr_data,$matches)){
		for($i = 0; $i < count($matches[1]); $i++){
			echo $matches[2][$i].','.$user_path.$matches[1][$i].PHP_EOL;
		}
	}
}
?>
