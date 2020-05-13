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
    $ResultRequest["Codigo"]      = 15000;
    $ResultRequest["Mensagem"]    = "O arquivo de configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 

    /**
     * Inclui o arquivo de classe que trata das sessões.
     */
    if(!@include_once ConfigSystema::get_Path_Systema() . '/Account/SDados.php'){
        $ResultRequest["Modo"]        = "Include";
        $ResultRequest["Error"]    = true;
        $ResultRequest["Codigo"]   = 11001;
        $ResultRequest["Mensagem"] = "Error sessão.";

        echo json_encode($ResultRequest); 
        exit;
    }
    
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
    
    

    //obtém a chave que foi enviado pelo cliente.
    $sendChave = empty($_POST["enviarChaves"]) == true ? substr($_REQUEST["sendChaves"], 2) : $_POST["enviarChaves"];
    /**
     * $Dados_Sessao["SDados"]["Chave"]
     * 
     */
    $Dados_Sessao["Chave"] = $sendChave;


    $SD = new SessaoDados();
    $SD->setChaves($Dados_Sessao["Chave"]);

    $SelecionarDados = new login();

    $SelecionarDados->setUsuario("CORAC");
    
    $Usuario = $SD->getUsernameChave();
    $Senha = $SD->getPasswordChave();
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
    $Pacote_Auth["Usuario"]=$Usuario;
    $Pacote_Auth["Dominio"]=6;
    $Pacote_Auth["Senha"]=$Senha;
    $Pacote_Auth["Habilitado"]= $Saida[3] == 1 ? true : false;
    $Pacote_Auth["Autenticado"]=true;
    $Pacote_Auth["Token"] = $SD->getID();
    $Pacote_Auth["TempoSessao"] = $SD->getTimeChave();
    $Pacote_Auth["RenovarSessao"]=0;
    $Pacote_Auth["Error"]=false;
    $Pacote_Auth["EMensagem"]=0;
    $Pacote_Auth["TEndPointClient"]=0;
    $Pacote_Auth["TEndPointServer"]=0;
    $Pacote_Auth["DominioCliente"]=0;
    $Pacote_Auth["Autenticacao"] = "BD";
    $Pacote_Auth["Dispositivo"] = $Dispositivo;
    $Pacote_Auth["DominioServidor"]=0;

    $SaidaJson = json_encode($Pacote_Auth);
        
    $PacoteBase["Pacote"] = 6;
    $PacoteBase["Conteudo"] = "$SaidaJson";
    $Pacote_Base["Remetente"] = 2;

    echo json_encode($PacoteBase);


} catch (Exception $ex) {
    
    $Pacote_Error["Pacote"]    = 8;
    $Pacote_Error["Error"]     = true;
    $Pacote_Error["Mensagem"]  = $ex->getMessage();

    $SaidaJson = json_encode($Pacote_Error);
        
    $Pacote_Base["Pacote"] = 8;
    $Pacote_Base["Conteudo"] = "$SaidaJson";
    $Pacote_Base["Remetente"] = 2;

    
    echo json_encode($Pacote_Base);
    
} 

