<?php

/* 
 * Verifica o usuário e senha
 * Esquema da tabela que deverá ser criada em todos os banco de dados para o login e cadastro de usuário.
 * 
 * CREATE TABLE `login` (
 `idLogin` int(11) NOT NULL AUTO_INCREMENT,
 `usuario` varchar(50) NOT NULL,
 `senha` varchar(100) NOT NULL,
 `tipousuario` enum('Comum','Gerente','Administrador') NOT NULL,
 `habilitado` bit(1) NOT NULL,
 `tentativa` tinyint(4) NOT NULL,
 `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`idLogin`),
 UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
 */


/**
 * Criado: 31/03/2019
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes ao cadastro de usuário.
 * @Autor 04953988612
 */

error_reporting(0);
if(@!include_once "../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]       = true;
    $ResultRequest["Codigo"]      = 8000;
    $ResultRequest["Mensagem"]    = "O arquivo de configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 

/**
 * Inclui o arquivo que contém as classes com o nome das tabelas do banco de dados AcessoBancoDados::get_BaseDados()
 */
if(!@include_once ConfigSystema::get_Path_Systema() . '/BancoDados/TabelasBD/'. AcessoBancoDados::get_BaseDados() .'.php'){
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]       = true;
    $ResultRequest["Codigo"]      = 8001;
    $ResultRequest["Mensagem"]    = "O arquivo responsável pela base de dados e tabelas não foi encontrado.";
    
    echo json_encode($ResultRequest); 
    exit;
}

/**
 * Armazena o tempo inicial do processamento.
 */
ConfigSystema::getStartTimeTotal();

$URL            = $_REQUEST["URL"];
$Requisicao     = $_REQUEST["Req"];
$Metodo         = $_REQUEST["Metodo"];
$SSL            = $_REQUEST["SSL"];
$Usuario        = $_POST["sendUsuario"];
$Senha          = md5($_POST["sendSenha"]);
$ContraSenha    = md5($_POST["sendContraSenha"]);
$Dispositivo    = $_REQUEST["sendDispositivo"];


try {
    if(!($Senha === $ContraSenha)) {
        throw new Exception("As senhas não são iguais, favor entrar em contato com o administrador!", 8002);
        exit;
        
    }
    
    if(ConfigSystema::getValidarDispositivo()){
        if(!$Dispositivo){
            throw new Exception("O dispositivo utilidado não foi informado.", 8003);
            exit;
                }
        if(!ConfigSystema::getDispositivos($Dispositivo)){
            throw new Exception("O dispositivo utilidado não é válido para esse sistema.", 8004);
            exit;

        }
    }

    $InserirDados = new login();

    $InserirDados->setUsuario("CORAC");
    
    $Dados = [
                [name=>"username",value=> $Usuario],
                [name=>"password",value=> $Senha]
            ];
    
    $Result = $InserirDados->InserirDadosTabela($Dados);
    
    if($Result == false) 
        throw new PDOException("Ocorreram erros ao cadastrar usuário. Favor entrar em contato com o administrador!", 8005);
    
    $InserirDados->EndClock();
    $ResultRequest["Modo"]             = "Cadastro";
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
    $ResultRequest["Modo"]      = "Cadastro";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
} 

