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
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9].$match_arr[11-12].$match_arr[13].$match_arr[15-16].$match_arr[17];
		//print_r($match_arr);
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
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9].$match_arr[11-12].$match_arr[13];
		//print_r($match_arr);
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
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		foreach ($letters1 as $letter1) {
			foreach ($letters2 as $letter2) {
				echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].PHP_EOL;
			}
		}
	} else if (preg_match($pattern1,$req_url,$match_arr)){//1阶循环
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		foreach ($letters1 as $letter1) {
			echo $match_arr[1].$letter1.$match_arr[5].PHP_EOL;
		}
	}
}
exit;

function match_16_0($match_arr,$subscript){
	#16进制判断
	if (preg_match('/\d\-[a-z]/',$match_arr[$subscript])){
		$arr1 = range($match_arr[$subscript+1],9);
		$arr2 = range('a',$match_arr[$subscript+2]);
		$letters = array_merge($arr1,$arr2);
	} else if (preg_match('/\d\-[A-Z]/',$match_arr[$subscript])){
		$arr1 = range($match_arr[$subscript+1],9);
		$arr2 = range('A',$match_arr[$subscript+2]);
		$letters = array_merge($arr1,$arr2);
	} else {
		$letters = range($match_arr[$subscript+1],$match_arr[$subscript+2]);
	}
	#留0判断
	if (preg_match('/0[\d]+\-\d[\d]+/',$match_arr[$subscript])){
		$numDigits = strlen($match_arr[$subscript+2]);
		$resultArray = [];
		foreach ($letters as $letter) {
			$resultArray[] = sprintf("%0{$numDigits}d", $letter);
		}
		return $resultArray;
	} else {
		return $letters;
	}
}
?>
