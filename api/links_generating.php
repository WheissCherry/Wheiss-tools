<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") die(header('HTTP/1.1 403'));
$req_url = $_POST["user_path_1"]??'';
if ($req_url) {
	if (strlen($req_url)>500) die("Formatted url data's length has exceeded!");
} else {
	die("Please input your formatted url data.");
}
preg_match_all('/\([\w]{1,6}\-[\w]{1,6}\)/',$req_url,$variables);
$variables_count = count($variables[0]);
switch ($variables_count) {
	case '1':
		$pattern1 = '/(.*?)\((([\w]+)\-([\w]+))\)(.*)/';
		preg_match($pattern1,$req_url,$match_arr);//1阶循环
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		if(strpos($req_url,'(1)')!==false){
			foreach ($letters1 as $letter1) {
				echo str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5]).PHP_EOL;
			}
		} else {
			foreach ($letters1 as $letter1) {
				echo $match_arr[1].$letter1.$match_arr[5].PHP_EOL;
			}
		}
		break;
	case '2':
		$pattern2 = '/(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*)/';
		 preg_match($pattern2,$req_url,$match_arr);//2阶循环
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		if(strpos($req_url,'(1)')!==false && strpos($req_url,'(2)')!==false){
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					$result = str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9]);
					echo str_replace('(2)',$letter2,$result).PHP_EOL;
				}
			}
		} else if(strpos($req_url,'(1)')!==false){
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					echo str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9]).PHP_EOL;
				}
			}
		} else if(strpos($req_url,'(2)')!==false){
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					echo str_replace('(2)',$letter2,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9]).PHP_EOL;
				}
			}
		} else {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].PHP_EOL;
				}
			}
		}
		break;
	case '3':
		$pattern3 = '/(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*)/';
		preg_match($pattern3,$req_url,$match_arr);//3阶循环
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9].$match_arr[11-12].$match_arr[13];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		$letters3 = match_16_0($match_arr,10);
		preg_match('/\([1-3]\)/',$req_url,$reuse);
		$reused = count($reuse);
		if ($reused) {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						$result = str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13]);
						$result = str_replace('(2)',$letter2,$result);
						echo str_replace('(3)',$letter3,$result).PHP_EOL;
					}
				}
			}
		} else {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].PHP_EOL;
					}
				}
			}
		}
		break;
	case '4':
		$pattern4 = '/(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*)/';
		preg_match($pattern4,$req_url,$match_arr);//4阶循环
		//$url = $match_arr[1].$match_arr[3-4].$match_arr[5].$match_arr[7-8].$match_arr[9].$match_arr[11-12].$match_arr[13].$match_arr[15-16].$match_arr[17];
		//print_r($match_arr);
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		$letters3 = match_16_0($match_arr,10);
		$letters4 = match_16_0($match_arr,14);
		preg_match('/\([1-4]\)/',$req_url,$reuse);
		$reused = count($reuse);
		if ($reused) {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						foreach ($letters4 as $letter4) {
							$result = str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].$letter4.$match_arr[17]);
							$result = str_replace('(2)',$letter2,$result);
							$result = str_replace('(3)',$letter3,$result);
							echo str_replace('(4)',$letter4,$result).PHP_EOL;
						}
					}
				}
			}
		} else {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						foreach ($letters4 as $letter4) {
							echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].$letter4.$match_arr[17].PHP_EOL;
						}
					}
				}
			}
		}
		break;
	case '5':
		$pattern5 = '/(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*?)\((([\w]+)\-([\w]+))\)(.*)/';
		preg_match($pattern5,$req_url,$match_arr);//5阶循环
		$letters1 = match_16_0($match_arr,2);
		$letters2 = match_16_0($match_arr,6);
		$letters3 = match_16_0($match_arr,10);
		$letters4 = match_16_0($match_arr,14);
		$letters5 = match_16_0($match_arr,18);
		preg_match('/\([1-5]\)/',$req_url,$reuse);
		$reused = count($reuse);
		if ($reused) {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						foreach ($letters4 as $letter4) {
							foreach ($letters5 as $letter5) {
								$result = str_replace('(1)',$letter1,$match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].$letter4.$match_arr[17].$letter5.$match_arr[21]);
								$result = str_replace('(2)',$letter2,$result);
								$result = str_replace('(3)',$letter3,$result);
								$result = str_replace('(4)',$letter4,$result);
								echo str_replace('(5)',$letter5,$result).PHP_EOL;
							}
						}
					}
				}
			}
		} else {
			foreach ($letters1 as $letter1) {
				foreach ($letters2 as $letter2) {
					foreach ($letters3 as $letter3) {
						foreach ($letters4 as $letter4) {
							foreach ($letters5 as $letter5) {
								echo $match_arr[1].$letter1.$match_arr[5].$letter2.$match_arr[9].$letter3.$match_arr[13].$letter4.$match_arr[17].$letter5.$match_arr[21].PHP_EOL;
							}
						}
					}
				}
			}
		}
		break;
	default:
		die("Unsupported format.");
		break;
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
