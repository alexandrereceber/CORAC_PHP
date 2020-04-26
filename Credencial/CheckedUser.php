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
if(@!include_once "../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]       = true;
    $ResultRequest["Codigo"]      = 14000;
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
    $ResultRequest["Codigo"]      = 14001;
    $ResultRequest["Mensagem"]    = "A configuração do banco de dados não foi encontrado.";
    
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
$MetodoAuth     = $_REQUEST["Autenticacao"];
$SSL            = $_REQUEST["SSL"];
$Usuario        = $_POST["Usuario"];
$Senha          = md5($_POST["Senha"]);
$Dispositivo    = $_REQUEST["Dispositivo"];


try {
    if(ConfigSystema::getValidarDispositivo()){
        if(!$Dispositivo){
            throw new Exception("O dispositivo utilidado não foi informado.", 14002);
            exit;
                }
        if(!ConfigSystema::getDispositivos($Dispositivo)){
            throw new Exception("O dispositivo utilidado não é válido para esse sistema.", 14003);
            exit;

        }
    }
if($MetodoAuth == "BD"){
    $SelecionarDados = new login();

    $SelecionarDados->setUsuario("CORAC");
    /**
     * Instrução que verifica se o sistema irá autenticar o usuário pelo conjunto usuário e senha ou somente usuário.
     */
    if (ConfigSystema::getValidarSenha())
        $FiltroCampos = [
                            [
                                [
                                    0=>0,
                                    1=>"=",
                                    2=>$Usuario
                                ],
                                [
                                    0=>1,
                                    1=>"=",
                                    2=>$Senha,
                                    3=> 1
                                ]
                            ]
                        ];
    else
        $FiltroCampos = [
                            [
                                [
                                    0=>0,
                                    1=>"=",
                                    2=>$Usuario
                                ]
                            ]
                        ];
    
    
    $SelecionarDados->setFiltros($FiltroCampos);
    $SelecionarDados->Select();
    $Saida = $SelecionarDados->getArrayDados()[0];
    
    /**
     * O sistema validará se o usuário esta habilitado ou não somente se a configuração, abaixo, estiver como true;
     */
    if(ConfigSystema::getValidarHabilitacao())
        if($Saida[3] != 1){
            throw new Exception("O usuário não existe ou não está habilitado no sistema. Favor entrar em contato com o administrador.", 14004);
            exit;
        }
    
    if(ConfigSystema::getValidarTentativas()){
        if($Saida[4] >= ConfigSystema::getTentativasTotal()){
            throw new Exception("Usuário bloqueado, favor entrar em contato com o administrador.", 14005);
            exit;
        }
    }
        
    /**
     * O Usuário ou a senha que foram informados estão incorretos.
     */
    if(count($Saida) == 0){
        if(ConfigSystema::getValidarTentativas()){
            /**
             * Garante que as tentativas, sem sucesso, serão registradas para uso futuro.
             */
            $FiltroCampos = [
                                [
                                    [
                                        0=>0,
                                        1=>"=",
                                        2=>$Usuario
                                    ]
                                ]
                            ];

                $SelecionarDados->setFiltros($FiltroCampos);
                $SelecionarDados->Select();            
                $UserPSError = $SelecionarDados->getArrayDados()[0];
                /**
                 * Verifica, antes de incrementar mais uma tentativa, se o usuário esta bloqueado.
                 */
                if($UserPSError[4] > ConfigSystema::getTentativasTotal()){
                            throw new Exception("Usuário bloqueado, favor entrar em contato com o administrador.", 14005);
                            exit;
                }

                $Tentativa = ++$UserPSError[4];
                $ChavesAtualizacao = [
                                        [
                                            0=>5, 
                                            1=>$UserPSError[5]]
                                    ];
                
                $Atualizar = [
                                [
                                    "name"=>"Tentativa",
                                    "value"=>$Tentativa]
                            ];
                $SelecionarDados->AtualizarDadosTabela($ChavesAtualizacao,$Atualizar);
            }
            
        throw new Exception("Usuário ou senha inválidos.", 14006);
    }
    
    $Pacote_Auth["Pacote"]=6;
    $Pacote_Auth["Usuario"]="LDAP";
    $Pacote_Auth["Dominio"]=6;
    $Pacote_Auth["Senha"]=6;
    $Pacote_Auth["Autenticado"]=true;
    $Pacote_Auth["Token"]=0;
    $Pacote_Auth["TempoSessao"]=0;
    $Pacote_Auth["RenovarSessao"]=0;
    $Pacote_Auth["Error"]=false;
    $Pacote_Auth["EMensagem"]=0;
    $Pacote_Auth["TEndPointClient"]=0;
    $Pacote_Auth["TEndPointServer"]=0;
    $Pacote_Auth["DominioCliente"]=0;
    $Pacote_Auth["Autenticacao"]=0;
    $Pacote_Auth["Dispositivo"]=0;
    $Pacote_Auth["DominioServidor"]=0;

    $SaidaJson = json_encode($Pacote_Auth);
        
    $PacoteBase["Pacote"] = 6;
    $PacoteBase["Conteudo"] = "$SaidaJson";
    
    echo json_encode($PacoteBase);
}else{
    
    $Pacote_Auth["Pacote"]=6;
    $Pacote_Auth["Usuario"]="LDAP";
    $Pacote_Auth["Dominio"]=6;
    $Pacote_Auth["Senha"]=6;
    $Pacote_Auth["Autenticado"]=true;
    $Pacote_Auth["Token"]=0;
    $Pacote_Auth["TempoSessao"]=0;
    $Pacote_Auth["RenovarSessao"]=0;
    $Pacote_Auth["Error"]=false;
    $Pacote_Auth["EMensagem"]=0;
    $Pacote_Auth["TEndPointClient"]=0;
    $Pacote_Auth["TEndPointServer"]=0;
    $Pacote_Auth["DominioCliente"]=0;
    $Pacote_Auth["Autenticacao"]=0;
    $Pacote_Auth["Dispositivo"]=0;
    $Pacote_Auth["DominioServidor"]=0;

    $SaidaJson = json_encode($Pacote_Auth);
        
    $PacoteBase["Pacote"] = 6;
    $PacoteBase["Conteudo"] = "$SaidaJson";
    
    echo json_encode($PacoteBase);
}
    

} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "Login";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    $SaidaJson = json_encode($ResultRequest);
    $PacoteBase["Pacote"] = 8;
    $PacoteBase["Conteudo"] = "$SaidaJson";

    echo json_encode($PacoteBase);
} 

