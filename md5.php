<?php
$arrContextOptions=array(
    "http" => array(
        "method" => "POST",
        "header" => 
            "Content-Type: application/xml; charset=utf-8;\r\n".
            "Connection: close\r\n",
            "ignore_errors" => true,
            "timeout" => (float)30.0,
            "Host"=> "www.sccdtk.serpro",
            "Connection"=> "keep-alive",
            "User-Agent"=>" Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36",
            "X-Requested-With"=> "XMLHttpRequest",
            "Content-Type"=> "application/x-www-form-urlencoded",
            "Accept"=>" */*",
            "Sec-Fetch-Site"=> "same-origin",
            "Sec-Fetch-Mode"=>" cors",
            "Sec-Fetch-Dest"=> "empty",
            "Referer"=> "https://www.sccdtk.serpro/maximo/ui/?event=loadapp&value=startcntr&uniqueid=23865&uisessionid=575&csrftoken=ca67br9s2sqcck8tknnhnrv5n2",
            "Accept-Encoding"=>" gzip, deflate, br",
            "Accept-Language"=>" pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
            "Cookie"=>" TJE=; TE3=; JSESSIONID=0000FC7miwp87KQJYTjYHvfyLdw:1cm2up393",
    ),
    "ssl"=>array(
        "allow_self_signed"=>true,
        "verify_peer"=>false,
    ),
    
);
function file_get_contents_curl( $url ) {

  $ch = curl_init();

  curl_setopt( $ch, CURLOPT_URL, $url );


  $data = curl_exec( $ch );
  curl_close( $ch );

  return $data;

}

$Result = file_get_contents_curl("https://www.sccdtk.serpro/maximo/ui/?event=loadapp&value=startcntr&uniqueid=23865&uisessionid=675&csrftoken=oe0lclcii6gk1d0flgk3oe7713", false, stream_context_create($arrContextOptions));
echo $Result;
?>