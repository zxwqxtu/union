<?php 
include dirname(dirname(__FILE__)).'/lib.php';

date_default_timezone_set('Asia/shanghai');

$html = fsockUrl('http://www.2345.com');
preg_match_all('#<a\s+href="([^"]+)"#U', $html, $matchHtml);
$htmlUrls = array();
foreach ($matchHtml[1] as $v) {
    if (strpos($v, 'http') === false) {
        $v = 'http://www.2345.com/'.ltrim($v, '/');
    }
    $htmlUrls[] = urlencode($v);
}
unset($v, $matchHtml);

$logPrefix = dirname(__FILE__).'/'.date('Y-m-d');

$fileLogs = array('ok'=> $logPrefix.'_ok_log', 'error'=>$logPrefix.'_error_log'); 

$referers = array(
    'http://www.2345.com/?k97158341', //960875184@qq.com
    //'http://www.2345.com/?k35033273', //960875184@qq.com
//    'http://www.2345.com/?k68847190' //wq@baisonmail.com 
);

$n = 0;
$maxNumber = mt_rand(20, 50);
while($n++ < $maxNumber) {
    foreach ($referers as $referer) {
        $ip = getIp();
        $cookie = getCookie(); 

        $ipCookieStr = date('Y-m-d')."\t{$ip}\t{$cookie}".PHP_EOL;
        error_log($ipCookieStr, 3, dirname(__FILE__).'/IPCookie.log');

        $maxNum = mt_rand(2, 8);
        for($num=0;$num<$maxNum;$num++) {
            $los = getRandLos($htmlUrls);

            unionOk($ip, $cookie, $los, $fileLogs, $referer);
        }
    }
}

function getRandLos($htmlUrls) {
    $los = array();
    $urlsKeys = array_rand($htmlUrls, rand(3, 10));
    foreach ($urlsKeys as $key) {
        $los[] = $htmlUrls[$key];
    }
    return $los;
}


function unionOk($ip, $cookie, $los, $fileLogs, $referer) {
    $cookieStr = '';
    $minTime = strtotime(date('Y-m-d'));
    $maxTime = strtotime(date('Y-m-d', strtotime('+1 day')));
    $clickTime = mt_rand($minTime, $maxTime);
    $cookie && $cookieStr = "uHTL=1; uHTT={$clickTime}; uUid={$cookie}";
        
    $url = 'http://union2.50bang.org/js/2345'; 
    $content = fsockUrl($url, $ip, $referer, null, $fileLogs); 
    preg_match('#uId2\=([^\&]+)#',$content, $match);
    $uId2 = $match[1];
    $url = "http://union2.50bang.org/web/2345?uId2={$uId2}&r=&fBL=1366*768"; 
    fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 

    echo $url."\n";
    sleep(3);

    $r = urlencode($referer);
    
    foreach($los as $lo) {
        $clickTimeLo = $clickTime + mt_rand(1, 60*10);
        $cookieStr = "uHTL=1; uHTT={$clickTimeLo}; uUid={$cookie}";

        $url = "http://union2.50bang.org/web/ajax2?uId2={$uId2}&r={$r}&fBL=1366*768&lO={$lo}";
        sleep(1);
        fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 
    }
}
