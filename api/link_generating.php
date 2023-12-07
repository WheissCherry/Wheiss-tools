<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$req_url = $_POST["user_path_1"]??'';
	if ($req_url) {
		if (strlen($req_url)>500) {
			die("Formatted url data's length has exceeded!");
		}
	} else {
		die("Please input your formatted url data.");
	}
	$pattern4 = '/(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*)/';
	$pattern3 = '/(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*)/';
	$pattern2 = '/(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*?)\((([\w]{1,4})\-([\w]{1,4}))\)(.*)/';
	$pattern1 = '/(.*?)\((([\w]{1,6})\-([\w]{1,6}))\)(.*)/';
	if (preg_match($pattern4,$req_url,$match_arr)){//4阶循环
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		$letters3 = match_16_0($match_arr,10);
		$letters4 = match_16_0($match_arr,14);
		foreach ($letters1 as $letter1) {
			foreach ($letters2 as $letter2) {
				foreach ($letters3 as $letter3) {
					foreach ($letters4 as $letter4) {
						echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].$letter4.$match_arr[17].PHP_EOL;
					}
				}
			}
		}
	} else if (preg_match($pattern3,$req_url,$match_arr)){//3阶循环
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		$letters3 = match_16_0($match_arr,10);
		foreach ($letters1 as $letter1) {
			foreach ($letters2 as $letter2) {
				foreach ($letters3 as $letter3) {
					echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].PHP_EOL;
				}
			}
		}
	} else if (preg_match($pattern2,$req_url,$match_arr)){//2阶循环
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		foreach ($letters1 as $letter1) {
			foreach ($letters2 as $letter2) {
				echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].PHP_EOL;
			}
		}
	} else if (preg_match($pattern1,$req_url,$match_arr)){//1阶循环
		$letters1 = match_16_0($match_arr,2);
		foreach ($letters1 as $letter1) {
			echo $match_arr[1].$letter1.$match_arr[5].PHP_EOL;
		}
	}
}
exit;

function match_16_0($match_arr,$subscript){
	$pattern16 = '/(([\d])\-([^\d]))/';
	$hexArray = array_map('dechex', range(0, 15));
	$letters = preg_match($pattern16,$match_arr[$subscript])?$hexArray:range($match_arr[$subscript+1],$match_arr[$subscript+2]);
	$pattern0 = '/((0[\d]+)\-(\d[\d]+))/';
	if (preg_match($pattern0,$match_arr[2])){
		$numDigits = strlen($match_arr[$subscript+2]);
		$resultArray = [];
		foreach ($letters as $letter) {
			$letter0 = sprintf("%0{$numDigits}d", $letter);
			$resultArray[] = $letter0;
		}
		return $resultArray;
	} else {
		return $letters;
	}
}
?>