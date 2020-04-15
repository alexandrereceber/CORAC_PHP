<?php

/* 
 * Verifica o usuário e senha
 * Esquema da tabela que deverá ser criada em todos os banco de dados para o login e cadastro de usuário
 * * 
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
 * Criado: 30/10/2018
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes ao login.
 * @Autor 04953988612
 */

error_reporting(0);
if(@!include_once "../../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]       = true;
    $ResultRequest["Codigo"]      = 15000;
    $ResultRequest["Mensagem"]    = "O arquivo de configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 


/**
 * Armazena o tempo inicial do processamento.
 */
ConfigSystema::getStartTimeTotal();

$URL            = $_REQUEST["URL"];
$Requisicao     = $_REQUEST["Req"];
$Metodo         = $_REQUEST["Metodo"];
$SSL            = $_REQUEST["SSL"];
$Dispositivo    = $_REQUEST["sendDispositivo"];


try {
    if(ConfigSystema::getValidarDispositivo()){
        if(!$Dispositivo){
            throw new Exception("O dispositivo utilidado não foi informado.", 15002);
            exit;
                }
        if(!ConfigSystema::getDispositivos($Dispositivo)){
            throw new Exception("O dispositivo utilidado não é válido para esse sistema.", 15003);
            exit;

        }
    }


    /**
     * Inclui o arquivo de classe que trata das sessões.
     */
    if(!@include_once ConfigSystema::get_Path_Systema() . '/Account/SDados.php'){
        $ResultRequest["Modo"]        = "Include";
        $ResultRequest["Error"]    = true;
        $ResultRequest["Codigo"]   = 4590;
        $ResultRequest["Mensagem"] = "Error sessão. Controller";

        echo json_encode($ResultRequest); 
        exit;
    }
    //obtém a chave que foi enviado pelo cliente.
    $sendChave = empty($_POST["enviarChaves"]) == true ? substr($_REQUEST["sendChaves"], 2) : $_POST["enviarChaves"];

    /**
     * $Dados_Sessao["SDados"]["Chave"]
     * 
     */
    $Dados_Sessao["Chave"] = $sendChave;


    try {

        $SD = new SessaoDados();
        $SD->setChaves($Dados_Sessao["Chave"]);

        if($SD->startSessao()){
            $vd = $SD->Validar_UserName();
            if(!$vd){
              $SD->DestruirSessao();
              throw new Exception("Usuário inválido para essa sessão, favor entrar em contato com o administrador!.", 15003);  
            }

            $vt = $SD->ValidarTime();
            if(!$vt){
              $SD->DestruirSessao();
              throw new Exception("Tempos não estão sincronizados, favor entrar em contato com o administrador!.", 15004);  
            }

            $vts = $SD->ValidarTempoSessao();
            if(!$vts){
                $SD->DestruirSessao();
                throw new Exception("Tempo de sessão expirado, favor efetuar login novamente!.", 15005);
            }
        }else{
            $SD->DestruirSessao();
            throw new Exception("Login necessário.", 15006);
        }

    } catch (Exception $exc) {
        /**
         * O erro é tratado diferente para ambientes diferente como paginas e plugins.
         */
        if(!AmbienteCall::getCall()){

            $ResultRequest["Modo"]      = "VL"; //Validação
            $ResultRequest["Error"]     = true;
            $ResultRequest["Codigo"]    = $exc->getCode();
            $ResultRequest["Mensagem"]  = $exc->getMessage();
            $ResultRequest["File"]      = "Oculto";
            $ResultRequest["Tracer"]    = "";
            /**
             * Esse array armazena o endereço da página de login caso o usuário esteja tentando acesso sem esta logado via componente.
             */
            $ResultRequest["Error"][3]             = ConfigSystema::getHttp_Systema();
            echo json_encode($ResultRequest); 
            exit;

        }
    }


} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "ValidarLogin";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
} 

