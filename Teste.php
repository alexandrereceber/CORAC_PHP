<?php

$Informacoes = ["teste"=> "vamos lá", "Metodo"=>"Taquera"];
$postdata = json_encode($Informacoes);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context = stream_context_create($opts);

$result = file_get_contents('http://192.168.15.250/Pacotes/', false, $context);

print_r($result);
?>