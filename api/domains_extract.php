<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") die(header('HTTP/1.1 403'));
$user_path_1 = trim($_POST["user_path_1"])??'';
$user_path_2 = trim($_POST["user_path_2"])??'';
$pattern = trim($_POST["user_path_3"])??'';
$data = trim($_POST["arr_data"])??'';
$scheme = $_POST["scheme"]??'';
if (!$data) die("Please input your domains data.");
if (strpos($data,"当前解析：")!==false) $data = preg_replace('/^[^：]+：.*/u','',$data);//ip138域名解析去前段
if (strpos($data,"最新域名查询")!==false) $data = preg_replace('/最新域名查询.*$/s','',$data);//ip138域名解析去后段
if (strpos($data,"子域名：")!==false) $data = preg_replace('/^[^：]+：.*/u','',$data);//ip138子域名去前段
if (strpos($data,"更多子域名")!==false) $data = preg_replace('/更多子域名.*$/s','',$data);//ip138子域名去后段
if (strpos($data,"域名如下：")!==false) $data = preg_replace('/^[^：]+：.*/u','',$data);//ip138IP反查域名去前段
if (strpos($data,"查找网站")!==false) $data = preg_replace('/.*查找网站.*/u','',$data);//ip138IP反查域名去中段
if (strpos($data,"www.itdog.cn\nDNS记录查询")!==false) $scheme = 1;//itdog启用IP模式
//print_r($data);exit;
if (preg_match('/\d{4}-\d{2}-\d{2}-----\d{4}-\d{2}-\d{2}/',$data)) $data = preg_replace('/\d{4}-\d{2}-\d{2}-----\d{4}-\d{2}-\d{2}/','',$data);//ip138去日期
if (preg_match('/[\x{4e00}-\x{9fa5}：]/u', $data)) $data = preg_replace('/[\p{Han}\h：]+/u', '', $data);//[\x{4e00}-\x{9fa5} ]+//去漏网之中文符
if (strpos($data,"\n\n")!==false) $data = preg_replace('/\n{2,}/',"\n",$data);//去连续空白行
if ($pattern){//正则精确匹配
	preg_match_all($pattern,$data,$matches);
	if (empty($matches[0])) die('No matched chars here.');
	$matche = array_unique($matches[0]);//去重
	if ($matche[0]=='223.5.5.5') unset($matche[0]);//适配itdog
	foreach ($matche as $match) echo $user_path_1.$match.$user_path_2.PHP_EOL;
} else if ($scheme){//正则IP精确匹配
	preg_match_all('/((?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.){3}(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)/',$data,$matches);
	if (empty($matches[0])) die('No matched ips here.');
	$matche = array_unique($matches[0]);//去重
	if ($matche[0]=='223.5.5.5') unset($matche[0]);//适配itdog
	foreach ($matche as $ip) echo $user_path_1.$ip.$user_path_2.PHP_EOL;
} else {
	if (strpos($data,' ')) $data = str_replace(' ', '', $data);//去空格
	$domains_arr = explode("\n",trim($data));//切分行
	//print_r($domains_arr);
	foreach ($domains_arr as $domain) echo $user_path_1.$domain.$user_path_2.PHP_EOL;
}
?>
