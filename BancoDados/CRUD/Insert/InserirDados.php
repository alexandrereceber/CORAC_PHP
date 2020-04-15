<?php


/**
 * 
 * @author Alexandre José da Silva Marques
 * @Criado: 09/11/2018
 * @filesource
 * 
 */

try{
    $Dados = $_REQUEST["sendCamposAndValores"];  
    
    if(!is_array($Dados)){
        throw new Exception("Falta Campos");
    }

    if(empty($Tabela)) throw new Exception("Nenhuma tabela foi definida, favor entrar em contato com o administrador.");
    if(!class_exists($Tabela)) throw new Exception("A classe que representa essa tabela não foi encontrada.", 2000);
    
    $InserirDados = new $Tabela();

    $InserirDados->StartClock();
    /**
     * Se a sessão for anônima deverá ser devinido um usuario e privilégios de acesso na tabela através
     * da variável privilegios em cada classe que representa a tabela.
     */
    $InserirDados->setUsuario("Alexandre");
    $Result = $InserirDados->InserirDadosTabela($Dados);
    
    if($Result == false) throw new PDOException("A instrução SQL para inserir dados retornou erros.", 2001);
    
    $InserirDados->EndClock();
    $ResultRequest["Modo"]             = "I";
    $ResultRequest["Error"] = false;
    $ResultRequest["lastId"] = $InserirDados->lastInsertId();

    /**
    * Armazena o tempo gasto com o processamento até esse ponto. Inserir dados
    */
    ConfigSystema::getEndTimeTotal();
    $ResultRequest["TempoTotal"]["BancoDados"]   =  $InserirDados->getTempoTotal();
    $ResultRequest["TempoTotal"]["SitemaTotal"] = ConfigSystema::getTimeTotal();

    echo json_encode($ResultRequest);

} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "I";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]     = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
}
