<?php
include dirname(dirname(__FILE__)).'/lib.php';

$logPrefix = dirname(__FILE__).'/'.date('Y-m-d');
$fileLogs = array('ok'=> $logPrefix.'_ok_log', 'error'=>$logPrefix.'_error_log'); 

$referer = 'http://www.duba.com/?un_5_380374';
//$randNum = mt_rand(20,100);
$randNum = 10;
$gnum = 0;
while($gnum++ < $randNum) {

    $ip = getIp();

    fsockUrl($referer, $ip);

    $url = 'http://js.stat.ijinshan.com/s?st=__dh&site=dh123';
    $str = fsockUrl($url, $ip, $referer);
    preg_match_all('#Set-Cookie:([^\n]+)\n#U', $str, $match);

    $cookieArr= array(); 
    foreach($match[1] as $value) {
        $_arr = explode(';', $value);
        $_arr = explode('=', $_arr[0]);
        $cookieArr[trim($_arr[0])] =  $_arr[1];
    }
    $__kp = $cookieArr['__kp'];
    $__kt = $cookieArr['__kt'];
    echo $__kp."\t".$__kt.PHP_EOL;

    $__d =intval(2147483648/mt_rand(1, 10000)); 
    $brvArr = ['6.0', '8.0', '9.0'];
    $brv = $brvArr[mt_rand(0,2)];

    $url ="http://dh.tj.ijinshan.com/__dh.gif?node=171000&snode=1&__siteid=dh123&account={$__kp}&ct={$__kt}&dis_pc=1350|609&dis_body=1329|111&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=iframe%3A0&__d={$__d}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $__d =intval(2147483648/mt_rand(1, 10000)); 
    $url = "http://dh.tj.ijinshan.com/__dh.gif?node=171003&snode=1&__siteid=&account={$__kp}&ct={$__kt}&dis_pc=1350|609&dis_body=1329|107&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=t%3Atianqi%7Cmd5%3A%E5%BB%8A%E5%9D%8A%7Ccid%3A101090601%7Cw%3A0%7Cindex%3A%7Cuuid%3A&__d={$__d}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $url = "http://hqs2.cnzz.com/stat.htm?id=30069637&r=&lg=zh-cn&ntime=1377764029&repeatip=1&rtime=1&cnzz_eid=593687724-1377671049-http%3A%2F%2Fwww.duba.com&showp=1364x616&st=84&sin=&rnd=201478410";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $__d =intval(2147483648/mt_rand(1, 10000)); 
    $url ="http://dh.tj.ijinshan.com/__dh.gif?node=171000&snode=100&__siteid=&account={$__kp}&ct={$__kt}&dis_pc=1350|609&dis_body=1329|107&br=ie&brv={$brv}&lbid=&pp=&uuid=&refer=&_ex2=&_ex3=&_ex4=t%3Anewt%7Ccid%3A69631&__d={$__d}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    $_time = time().$__d;
    $url ="http://j.wan.liebao.cn/game/recent_invoked_by_frontend?v=2&limit=5&callback=recent_play&_={$_time}";
    fsockUrl($url, $ip, $referer, null, $fileLogs); 

    sleep(3);
}
