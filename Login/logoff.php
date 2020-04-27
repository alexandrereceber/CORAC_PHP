<?php

error_reporting(0);

if(@!include_once __DIR__ . "/../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]    = true;
    $ResultRequest["Codigo"]   = 11000;
    $ResultRequest["Mensagem"] = "O arquivo de Configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/SegurityPages/SecurityPgs.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
};

$SD->DestruirSessao();

$ResultRequest["Modo"]      = "VL"; //Validação
$ResultRequest["Error"]     = false;

/**
 * Esse array armazena o endereço da página de login caso o usuário esteja tentando acesso sem esta logado via componente.
 */
echo json_encode($ResultRequest); 
exit;