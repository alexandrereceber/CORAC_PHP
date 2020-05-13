<?php

/**
 * Criado: 09/05/2020
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes aos agentes autônomos.
 * @Autor 04953988612
 */

error_reporting(0);
set_time_limit(0);
if(@!include_once "../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi Cabeçaalho. Cabeçalho Geral";
    
    echo json_encode($ResultRequest);
    exit;
};

AmbienteCall::setCall(false);

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/SegurityPages/SecurityPgs.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
};

if(@!include_once ConfigSystema::get_Path_Systema() .  "/AgentesCORAC/CMD.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. CMD";
    
    echo json_encode($ResultRequest);
    exit;
};

ConfigSystema::getStartTimeTotal();
$URL            = $_REQUEST["URL"];
$Requisicao     = $_REQUEST["Req"];
$Metodo         = $_REQUEST["Metodo"];
$SSL            = $_REQUEST["SSL"];
$Formato        = $_REQUEST["sendRetorno"]  == "" ? "JSON" : $_REQUEST["sendRetorno"]; //Atribui um formato padrão
$CMD            = $_REQUEST["Command"];
$ServidorCorac  = "192.168.15.10";//$_REQUEST["ServidorCorac"];

ConfigPowershell::setServidor($ServidorCorac);

try{
        switch ($Formato) {

        case "XML":


            break;
        
        case "JSON":
            $ResultRequest["Modo"]      = "Switch";
            $ResultRequest["Error"]     = false;
            
          /**
           * Armazena o resultado da resposta do AA.
           */ 
            $Agente_Autonomos_PACOTES = new CMD(ConfigPowershell::getServidor(), ConfigPowershell::getPorta(), ConfigPowershell::getProtocolo(), ConfigPowershell::getPasta(), $sendChave);
            $ResultRequest[RST_AG] = $Agente_Autonomos_PACOTES->Executar_CMD($CMD);
            
           /**
            * Armazena o tempo gasto com o processamento até esse ponto. Select
            */
            ConfigSystema::getEndTimeTotal();
            $ResultRequest["SistemaTempoTotal"] = ConfigSystema::getTimeTotal();

            echo json_encode($ResultRequest);

            break;
        
        case "PDF":


            break;


        default:
            throw new Exception("O retorno não foi informado.");
            break;
    }
    
} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "Informação Servidor CORAC WEB";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);

}