<?php 
include dirname(dirname(__FILE__)).'/lib.php';

date_default_timezone_set('Asia/shanghai');

$html = fsockUrl('http://www.duba.com/');
preg_match_all('#<a\s+([^>]+)>#U', $html, $matchHtml);
$htmlExt4 = array();
foreach ($matchHtml[1] as $v) {
    $l = $cid = '';
    $l = mt_rand(0, 100);
    if(preg_match('#l="([^"]+)"#U', $v, $match)) {
        $l = $match[1];
    }
    if(preg_match('#cid="([^"]+)"#U', $v, $match)) {
        $cid = $match[1];
    }

    if (empty($l) || empty($cid)) {
        continue;
    }
    $cknum = mt_rand(1,3);
    $bknum = mt_rand(2,5);
    $ext4 = "t:newt|md5:|cid:{$cid}|w:|index:|uuid:|kbcode:0|pcode:0|scroll:1|bknum:{$bknum}|cknum:{$cknum}|x:1|svrid:|pos:mz|l:{$l}|pgi:1|rptt:1";
    
    $htmlExt4[] = urlencode($ext4);
}
unset($v, $matchHtml);
$logPrefix = dirname(__FILE__).'/'.date('Y-m-d');

$fileLogs = array('ok'=> $logPrefix.'_ok_log', 'error'=>$logPrefix.'_error_log'); 

$referers = array(
    'http://www.duba.com/?un_5_380374' //960875184@qq.com 
);

$n = 0;
while($n++ < 30) {
    foreach ($referers as $referer) {
        $ip = mt_rand(100, 176).'.'.mt_rand(1, 255).'.'.mt_rand(0, 255).'.'.mt_rand(0, 255);

        $cookie = getCookieBySelf(); 

        $ipCookieStr = date('Y-m-d')."\t{$ip}\t{$cookie}".PHP_EOL;
        error_log($ipCookieStr, 3, dirname(__FILE__).'/IPCookie.log');


        $maxNum = mt_rand(2, 8);
        for($num=0;$num<$maxNum;$num++) {
            $los = getRandLos($htmlExt4);

            unionOk($ip, $cookie, $los, $fileLogs, $referer);
        }
    }
}

function getCookieBySelf() {
    $str = '';
    for($n=0; $n<28; $n++) {
        $randArr = array(
            mt_rand(0,9),
            chr(mt_rand(97, 122))
        ); 
        $str .= $randArr[mt_rand(0,1)];
    } 
    return $str;
}

function getRandLos($htmlUrls) {
    $los = array();
    $urlsKeys = array_rand($htmlUrls, rand(3, 10));
    foreach ($urlsKeys as $key) {
        $los[] = $htmlUrls[$key];
    }
    return $los;
}

//zptiuxzl8pivnt2aerkwdcbf7sl9
//y9qj9662jpyx2k34pv9uqlq6td72
function unionOk($ip, $cookie, $los, $fileLogs, $referer) {
    $cookieStr = '';
    $minTime = strtotime(date('Y-m-d'));
    $maxTime = strtotime(date('Y-m-d', strtotime('+1 day')));
    $clickTime = mt_rand($minTime, $maxTime);

    fsockurl($referer, $ip, null, $cookieStr, $fileLogs); 

    $url = "http://www.duba.com/";
    fsockurl($url, $ip, $referer, $cookieStr, $fileLogs); 

    $cookie && $cookieStr = "__kp={$cookie}; __kt={$clickTime}";
    $url = 'http://js.stat.ijinshan.com/s?st=__dh&site=dh123';

    fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 
    echo $url."\n";

    $url ="http://cnzz.mmstat.com/9.gif?abc=1&rnd=856175491";
    $restr = fsockUrl($url, $ip, $referer, null, $fileLogs); 
    preg_match("#Location:(.+)\r\n#U",$restr, $match);
    $url = trim($match[1]);
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $__d =intval(2147483648/mt_rand(1, 10000)); 

    $brvArr = ['6.0', '8.0', '9.0'];
    $brv = $brvArr[mt_rand(0,2)];

    $url ="http://dh.tj.ijinshan.com/__dh.gif?node=171000&snode=1&__siteid=dh123&account={$cookie}&ct={$clickTime}&dis_pc=1350|609&dis_body=1329|111&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=iframe%3A0&__d={$__d}";

    fsockUrl($url, $ip, $referer, null, $fileLogs); 
    
    $url = "http://hqs2.cnzz.com/stat.htm?id=30069637&r=&lg=zh-cn&ntime={$clickTime}&repeatip=0&rtime=1&cnzz_eid=1235360556-1377244595-http%3A%2F%2Fwww.duba.com&showp=1350x609&st=67407&sin=&rnd=2146609614";   
    fsockUrl($url, $ip, $referer, 'cna=swOeClluCDcCAXL8ZuodEEdn', $fileLogs); 

    $__d =intval(2147483648/mt_rand(1, 10000)); 
    $url = "http://dh.tj.ijinshan.com/__dh.gif?node=171003&snode=1&__siteid=&account={$cookie}&ct={$clickTime}&dis_pc=1350|609&dis_body=1329|107&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=t%3Atianqi%7Cmd5%3A%E5%BB%8A%E5%9D%8A%7Ccid%3A101090601%7Cw%3A0%7Cindex%3A%7Cuuid%3A&__d={$__d}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $__d =intval(2147483648/mt_rand(1, 10000)); 
    $url ="http://dh.tj.ijinshan.com/__dh.gif?node=171000&snode=100&__siteid=&account={$cookie}&ct={$clickTime}&dis_pc=1350|609&dis_body=1329|107&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=t%3Anewt%7Ccid%3A69631&__d={$__d}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $v = date('YmdHis'); 
    $url = 'http://www.duba.com/static/js/pop.js?v='.$v;
    fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 
    $url = "http://www.duba.com/static/js/userBehavior.js?v={$v}";
    fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 
    $url = "http://www.duba.com/static/js/tagsDetect.js?v={$v}";
    fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 

    $url = "http://dh1.kpns.ijinshan.com/dh/?product=dh&passport=&uuid=&did=&wid={$cookie}&cb=jQuery16408505814579578623_1377312000583&v=1&f=json&recent_id=&sw=1350&ww=1329&wh=89&br=ie{$brv}&os=winxp&channel_id=index&from=&_=1377312002996";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    sleep(1);

    $r = urlencode($referer);
    
    foreach($los as $lo) {
        $clickTimeLo = $clickTime + rand(1, 60*10);

        $__d =intval(2147483648/mt_rand(1, 10000)); 
        $url ="http://dh.tj.ijinshan.com/__dh.gif?node=171000&snode=100&__siteid=&account={$cookie}&ct={$clickTimeLo}&dis_pc=1350|609&dis_body=1329|107&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4={$lo}&__d={$__d}";

        sleep(1);
        fsockUrl($url, $ip, $referer, $cookieStr, $fileLogs); 
    }
}
