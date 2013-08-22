<?php
function getCookie() {
    $n = 0; 
    $str = '';
    $numArr = [0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F']; 
    while($n<28) { 
        $key = mt_rand(0,15);
        $str .= $numArr[$key];
        $n++;  
    } 
    return $str;
} 

function getIp() {
    $firstIp = mt_rand(100, 254);
    if (in_array($firstIp , array(127,172,10, 192))) {
        return getIp();
    }
    $ip = $firstIp.'.'.mt_rand(1, 255).'.'.mt_rand(0, 255).'.'.mt_rand(0, 255);
    return $ip; 
}

function fsockUrl($url, $ip=null, $referer='', $cookie=null, $fileLogs=array()) {
    $prefix = "\r\n";
    $urlArr = parse_url($url);

    $fp = fsockopen($urlArr['host'], 80, $errno, $errstr, 30);
    if (!$fp) {
        exit("$errstr($errstr)\n");
    }
    $httpGet = empty($urlArr['path'])?'/':$urlArr['path'];
    !empty($urlArr['query']) && ($httpGet .= '?'.$urlArr['query']);
    $out = "GET {$httpGet} HTTP/1.1{$prefix}";
    $out .= "Host: {$urlArr['host']}{$prefix}";
    $out .= "Connection:Close{$prefix}";
    $referer && $out .= "Referer:{$referer}{$prefix}";
    $ip && $out .= "Client-ip: {$ip}{$prefix}";
    $ip && $out .= "Http-client-ip: {$ip}{$prefix}";
    $ip && $out .= "X-forwarded-for:{$ip}{$prefix}";
    $ip && $out .= "Http-x-forwarded-for:{$ip}{$prefix}";

    $cookie && $out .= "Cookie:{$cookie}{$prefix}";
    $out .= $prefix;

//    echo $out."----\n";
    fwrite($fp,$out);
    $str = '';
    while(!feof($fp)) {
        $str .= fgets($fp);
    }
    fclose($fp);

    $responseArr = explode("\r\n", $str);
    if (!strpos($responseArr[0], "200 OK")) {
        $fileName = dirname(__FILE__).'/error_log';
        !empty($fileLogs['error']) && ($fileName = $fileLogs['error']);
        $logStr = date('Y-m-d H:i:s')."\t".$url."\t".$ip."\t".$cookie."\n";
        error_log($logStr,3,$fileName);
        return $str;
    }

    $fileName = dirname(__FILE__).'/log';
    !empty($fileLogs['ok']) && ($fileName = $fileLogs['ok']);

    $logStr = date('Y-m-d H:i:s')."\t".$url."\t".$ip."\t".$cookie."\n";
    error_log($logStr,3,$fileName);

    return $str;
}
