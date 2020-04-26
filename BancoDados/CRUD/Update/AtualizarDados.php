<?php

/**
 * @author Alexandre José da Silva Marques
 * @Criado: 09/11/2018
 * @filesource
 * 
 */

try{
    $ChavesPrimarias    = $_REQUEST["sendChavesPrimarias"];
    $Dados              = $_REQUEST["sendCamposAndValores"];

    if(!is_array($ChavesPrimarias) || !is_array($Dados)){
        throw new Exception("Falta Campos");
    }

    if(empty($Tabela)) throw new Exception("Nenhuma tabela foi definida, favor entrar em contato com o administrador.", 4000);
    if(!class_exists($Tabela)) throw new Exception("A classe que representa essa tabela não foi encontrada.", 4001);

    $AtualizarDados = new $Tabela();
    $AtualizarDados->StartClock();
    $AtualizarDados->setUsuario("CORAC");
    $AtualizarDados->AtualizarDadosTabela($ChavesPrimarias, $Dados);
    
    $AtualizarDados->EndClock();
    $ResultRequest["Modo"]             = "U";
    $ResultRequest["Error"] = false;
   /**
    * Armazena o tempo gasto com o processamento até esse ponto. Atualizar Dados
    */
    ConfigSystema::getEndTimeTotal();
    $ResultRequest["TempoTotal"]["BancoDados"]   =  $AtualizarDados->getTempoTotal();
    $ResultRequest["TempoTotal"]["SitemaTotal"]  = ConfigSystema::getTimeTotal();

    echo json_encode($ResultRequest);

} catch (Exception $ex) {

    $ResultRequest["Modo"] = "U";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]     = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
}