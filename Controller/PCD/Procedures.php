<?php
/**
 * Criado: 29/09/2018
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes à banco de dados.
 * @Autor 04953988612
 */

//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
error_reporting(0);

if(@!include_once "./Cabecalho_Procedures.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]       = true;
    $ResultRequest["Codigo"]      = 13000;
    $ResultRequest["Mensagem"]    = "O arquivo de configuração não foi encontrado. ";
    
    echo json_encode($ResultRequest);
    exit;
}; 
$Entradas = ($_REQUEST["sendEntradas"] == "") ? false : $_REQUEST["sendEntradas"];

try{
    $StoreProcedure = new $Procedure($Entradas);
    $StoreProcedure->setEntrada($Entradas);
    $StoreProcedure->setUsuario("CORAC");
    $StoreProcedure->Execute();
    
    $ResultRequest["Modo"]             = "S";
    $ResultRequest["Error"]             = false;
    $ResultRequest["NomeProcedure"]     = ProcedureBancoDadosMD5::getProcedureForMD5($Procedure);
    $ResultRequest["ResultDados"]       = $StoreProcedure->getArrayDados();
    $ResultRequest["Campos"]            = $StoreProcedure->getInfoCampos();
    $ResultRequest["ChavesPrimarias"]   = $StoreProcedure->getChaves();
    $ResultRequest["Formato"]          = "JSON";
    $ResultRequest["Indexador"]         = time();

   /**
    * Armazena o tempo gasto com o processamento até esse ponto. Select
    */
    ConfigSystema::getEndTimeTotal();
    $ResultRequest["TempoTotal"]["BancoDados"]  = $StoreProcedure->getTempoTotal();
    $ResultRequest["TempoTotal"]["SitemaTotal"] = ConfigSystema::getTimeTotal();
    echo json_encode($ResultRequest);
    
} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "PCD";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
}