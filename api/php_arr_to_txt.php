<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_path = $_POST["user_path"];
	$arr_data = $_POST["arr_data"];
	if (empty($user_path)) {
		die("Please input your php file address such as".PHP_EOL."https://www.123.xyz/1.php?id=");
	} else if (empty($arr_data)) {
		die("Please input your php array such as".PHP_EOL."'cctv1' => 'CCTV1SD_1200', //CCTV1");
	}
	$pattern = "/.*['\"](\w+)['\"].*=.+\/\/(.+)/";
	if(preg_match_all($pattern,$arr_data,$matches)){
		for($i=0;$i<count($matches[1]);$i++){
			echo $matches[2][$i].','.$user_path.$matches[1][$i].PHP_EOL;
		}
	}
}
?>
