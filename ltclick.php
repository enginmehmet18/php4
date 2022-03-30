<?php

//DATA PARSING
function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIE,TRUE);
//JIKA WEBSITE ATAU APK PROSES LOGIN TANPA CAPTCHA
//MAKA KITA BISA MENG AKTIFKAN COOKIE BAWAAN DARI DATA PARSING

//BILA SEBALIKNYA. MAKA MATIKAN COOKIE DENGAN TANDA // DAN GUNAKAN DATA INPUT UNTUK MENYISIPKAN COOKIE
        curl_setopt($ch, CURLOPT_COOKIEFILE,"cookie.txt");
        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }

//FUNCTION GET
function get($url){
  return curl($url,'',head())[1];
}

//PENGERTIAN GET:
//GET YAITU MEMANGGIL DATA RESPON TANPA MEMERLUKAN DATA


//FUNCTION POST
function post($url,$data){
  return curl($url,$data,head())[1];
}

//PENGERTIAN POST
//POST YAITU PROSES MEMANGGIL DATA RESPON YANG DI AWALI DENGAN
//MENGIRIM DATA YANG VALID

//FUNCTION HEADER
function head(){
  $h[]="Host: ltclick.com";
  $h[]="content-type: application/x-www-form-urlencoded; charset=UTF-8";
  $h[]="user-agent: Mozilla/5.0 (Linux; Android 7.0; Redmi Note 4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Mobile Safari/537.36";
  $h[]="accept: application/json, text/javascript, */*; q=0.01";
  $h[]="x-requested-with: XMLHttpRequest";
  return $h;
}

//DATA INPUT YG SECARA AUTO MENYIMPAN DENGAN NAMA data.json
if(!file_exists("data.json")){
while("true"){
system("clear");
//ban();
  $r=readline("\033[1;97mInput Your Cookie : \033[1;92m");
if(!$r==""){
break;
}
}
$data=["Cookie"=>$r];
  save("data.json",$data);
//$a=next($ran);
}

//PERINTAH MEMANGGIL DATA YANG TERSIMPAN DI data.json
$cookie1=json_decode(file_get_contents("data.json"),true)["Cookie"];

//FUNCTION SAVE. INI 1 PAKET DENGAN DATA INPUT
function save($data,$data_post){
    if(!file_get_contents($data)){
      file_put_contents($data,"[]");}
    $json=json_decode(file_get_contents($data),1);
    $arr=array_merge($json,$data_post);
    file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));
}

//FUNCTION WAKTU
function timer($t){
     $timr=time()+$t;
      while(true):
      echo "\r                                                    \r";
      $res=$timr-time();
      if($res < 1){break;}
if($res==$res){
//  $str= str_repeat("\033[1;92m◼",$res)."              \r";
}
      echo " \033[1;97mPlease Wait \033[1;91m".date('i:s',$res)." ";
      sleep(1);
      endwhile;
}

//URL LOGIN
$url="https://ltclick.com/inc/loginto.php";
//DATA LOGIN
$data="mail=enginmehmet180@gmail.com&thepassword=Ozeltim012345";
post($url,$data); //SETIAP LOGIN PASTI MENGGUNAKAN METHOD POST

//URL DASHBOARD
$url="https://ltclick.com/dashboard.php";
$res= get($url); //SETIAP DASHBOARD PASTI MENGGUNAKAN METHOD GET
//JIKA RESPONNYA HTML, MAKA GUNAKAN EXPLODE ATAU PREG MATCH
//KEBETULAN DI BAWAH INI ADALAH CONTOH DATA EXPLODE
$balance=explode('</h2>',explode('<h2 class="text-white">',$res)[2])[0];
$reff=explode('</h2>',explode('<h2 class="text-white">',$res)[3])[0];
//PERINTAH ECHO UNTUK MENAMPILKAN HASIL ATAU MENAMPILKAN DI LAYAR MONITOR/HANDPHONE 
echo " Balance : $balance \n";
echo " Referral: $reff \n\n";

//WHILE PERINTAH PERULANGAN
while(1){
$url="https://ltclick.com/inc/faucet.php";
$data="";
$res= post($url,$data);
$has=explode('"',explode('"',$res)[1])[0];
//RESPON DARI HAS ADALAH wait,error,done

//FUNGSI IF PER ANDAIAN ATAU LOGIKA
if($has=="wait"){
timer(300); //FUNCTION TIMER
}

//FUNGSI IF PER ANDAIAN ATAU LOGIKA
if($has=="done"){
$url="https://ltclick.com/dashboard.php";
$res= get($url);
$balance=explode('</h2>',explode('<h2 class="text-white">',$res)[2])[0];
echo " SUCCESS Claim 100 Litoshi Balance $balance \n";
}
}
