<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") die(header('HTTP/1.1 403'));
$http_user_agent = $_SERVER['HTTP_USER_AGENT']??'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36';
$req_url = $_POST["user_path_1"]??'';
$list_data = $_POST["list_data"]??'';
$scheme = $_POST["scheme"]??'';
if ($req_url){
	$userAgent = $_POST["user_path_2"]??'$http_user_agent';
	$referer = $_POST["user_path_3"]??'';
	if ($referer){
		preg_match('/https?:\/\/[^\/\n]+/',$referer,$match_referer);
		$origin = $match_referer[0];
	} else {
		preg_match('/https?:\/\/[^\/\n]+/',$req_url,$match_req_url);
		$referer = $origin = $match_req_url[0];
	}
	$headers = [
		"User-Agent: $userAgent",
		"Referer: $referer",
		"Origin: $origin",
		"Accept-Language: en-US,en;q=0.9"
	];
	$ch = curl_init($req_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);
	if (curl_error($ch)) {
		echo 'CURL请求失败'.PHP_EOL.curl_error($ch);
		exit;
	}
	if ($response){
		$list_data .= PHP_EOL.$response;
	}
}
if ($list_data){
	$list_data = preg_replace('/\t+/',"",$list_data);//去除制表符
	$list_data = preg_replace('/\n+/',"\n",$list_data);//去除连续空白行
	$list_data = preg_replace('/#+/',"#",$list_data);//去除连续#
	#初步格式化m3u列表
	if (strpos($list_data,'#EXTM3U')!==false){//M3U格式
		$list_data = str_replace("#\n#","\n#",$list_data);//去除行尾#
		$list_data = preg_replace('/([^\n])#EXTINF/',"$1\n#EXTINF",$list_data);//#EXTINF自动换行
		if (strpos($list_data,'#EXTVLCOPT')!==false){
			$list_data = preg_replace("/#EXTVLCOPT.+\n/",'',$list_data);//去除#EXTVLCOPT行
		}#以下实现格式化m3u中的链接
		if (preg_match_all('/.+#.+/',$list_data,$match_urls)){//捕获所有需要格式化的项目
			foreach($match_urls[0] as $match_url){//对于匹配到的每一项，统计#的个数
				preg_match_all('/#/',$match_url,$match_count);
				$counts[] = count($match_count[0]);
			}
			$max_count = max($counts);//取含#个数的最大值
			for ($i=0;$i<$max_count;$i++){
				$list_data = preg_replace('/(#EXTINF.+)\n([^#\n]+)#(.+)/',"$1\n$2\n$1\n$3",$list_data);//格式化m3u
			}
		}
		#以下实现url去重及转换
		if ($scheme||strpos($list_data,'group-title')==false){//不保留分组或无分组
			preg_match_all('/#EXTINF.+,(.+)\n([^\n#]+)/',$list_data,$matches);
			$result = '';
			for ($i=0;$i<count($matches[1]);$i++){
				if (strpos($result,$matches[2][$i])){//url已存在则去重
					continue;
				} else {
					$result .= $matches[1][$i].','.$matches[2][$i].PHP_EOL;
				}
			}
		} else {//保留分组
			preg_match_all('/#EXTINF.+group-title="(.+?)".*,(.+)\n([^\n#]+)/',$list_data,$matches);
			$result = $matches[1][0].',#genre#'.PHP_EOL.$matches[2][0].','.$matches[3][0].PHP_EOL;
			for ($i=1;$i<count($matches[1]);$i++){
				if (strpos($result,$matches[3][$i])){//url已存在则去重
					continue;
				} else {
					$group = ($matches[1][$i] == $matches[1][$i-1])?'':$matches[1][$i].',#genre#'.PHP_EOL;//分组处理
					$result .= $group.$matches[2][$i].','.$matches[3][$i].PHP_EOL;
				}
			}
			$result = txt_classification_oneness($result);//分类去重
		}
		echo $result;
	} else if (strpos($list_data,',')!==false){
		$list_data = str_replace("\n#","\n",$list_data);//去除行首#
		$list_data = preg_replace('/([^e])#\n/',"$1\n",$list_data);//去除行尾#
		#格式化txt
		if (preg_match_all('/.+,.+#.+/',$list_data,$match_urls)){
			for ($i=0;$i<count($match_urls[0]);$i++){
				preg_match_all('/#/',$match_urls[0][$i],$match_count);
				$counts[] = count($match_count[0]);
			}
			$max_count = max($counts);
			for ($i=0;$i<$max_count;$i++){
				$list_data = preg_replace('/(.+,)(.+)#(.+)/',"$1$2\n$1$3",$list_data);
			}
		}
		if ($scheme||strpos($list_data,'#genre#')==false){//不保留分组或无分组
			preg_match_all('/(.+),(.+)/',$list_data,$matches);
			$result = '#EXTM3U'.PHP_EOL;
			for($i=0;$i<count($matches[0]);$i++){
				if ($matches[2][$i] == '#genre#'||strpos($result,$matches[2][$i])){
					continue;
				} else {
					$result .= '#EXTINF:-1 ,'.$matches[1][$i].PHP_EOL.$matches[2][$i].PHP_EOL;
				}
			}
		} else {//保留分组
			#分类去重
			$list_data = txt_classification_oneness($list_data);
			#以下实现url去重及转换
			preg_match_all('/(.+),(.+)/',$list_data,$matches);
			$result = '#EXTM3U'.PHP_EOL;
			for($i=0;$i<count($matches[0]);$i++){
				if ($matches[2][$i] == '#genre#'){
					$classification = $matches[1][$i];
				} else if (strpos($result,$matches[2][$i])){
					continue;
				} else {
					$result .= '#EXTINF:-1 group-title="'.$classification.'",'.$matches[1][$i].PHP_EOL.$matches[2][$i].PHP_EOL;
				}
			}
		}
		echo $result;
	} else {
		die("Your file isn't the M3U or txt format list.");
	}
} else {
	die('Please input your list link or data.');
}
exit;

#以下实现txt格式下的分类去重
function txt_classification_oneness($txt){
	preg_match_all('/.*,#genre#\n|(?:.*,[^#\n]+\n)+/',$txt,$matches_txt);//匹配每个分类或分类段
	$counts_txt = count($matches_txt[0]);
	for ($i=2;$i<$counts_txt-1;$i+=2){//遍历每个分类
		for ($j=0;$j<$i;$j+=2){//检查前面是否已经出现过
			if ($matches_txt[0][$j]==$matches_txt[0][$i]){
				$b = $matches_txt[0][$i+1];
				for ($k=$i;$k>$j+2;$k--){
					$matches_txt[0][$k + 1] = $matches_txt[0][$k - 1];
				}
				$matches_txt[0][$k] = '';
				$matches_txt[0][$k+1] = $b;
			}
		}
	}
	$result = '';
	for ($i=0;$i<$counts_txt;$i++){
		if($matches_txt[0][$i]){
			$result .= $matches_txt[0][$i];
		}
	}
	return $result;
}
?>
