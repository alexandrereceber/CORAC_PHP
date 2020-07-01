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
$SSL            = $_REQUEST["SSL"];
$Usuario        = $_POST["sendUsuario"];
$Senha          = md5($_POST["sendSenha"]);
$Dispositivo    = $_REQUEST["sendDispositivo"];


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
    
    if($Saida == null){
        throw new Exception("Usuário ou senha inválidos.", 14006);
        exit;
    }
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
            
        
    }else{
        if($Saida[4] > 0){
           /**
             * Garante que o contador será zerado, caso o usuário não bloquei por tentativas, ao efetivar o login.
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

                $Tentativa = 0;
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
    }
    
    $SDados["Active"]   = true;
    $SDados["Username"] = $Usuario;
    $SDados["Password"] = $Senha;
    $SDados["Tusuario"] = $Saida[2];
    $SDados["Tempo"]    = time();
    $SDados["Tentativas"] = $Saida[4];
    $SDados["ID"]       = md5($Saida[0]);

    session_save_path( __DIR__ . "/../Account/Sessoes");

    session_id($SDados["ID"]);
    $AbrirSessao = session_start();
    /**
     * Verifica se já existe uma mesma sessão aberta. Caso exista o sistema apaga os dados anteriores;
     */
    $Ativo = $_SESSION[$SDados["ID"]]["Active"];
    if($Ativo){
        $_SESSION[$SDados["ID"]] = [];
    }
    
    $_SESSION[$SDados["ID"]] = json_encode($SDados);
    $Chave = base64_encode(json_encode($SDados));
    
 switch ($Saida[2]) {
     case "Gerente":
         $ResultRequest["Error"] = false;
         $ResultRequest["Modo"] = "Login";
         $ResultRequest["Chave"] = $Chave;
         $ResultRequest["TipoUsuario"] = "Gerente";
         $ResultRequest["Tentativas"] = $SDados["Tentativas"];
         $ResultRequest["Header"] = ConfigSystema::getHttp_Systema(). $Saida[2] ."?s=" . $Chave;
         echo json_encode($ResultRequest);
         break;

     default:
         session_destroy();
        throw new Exception("Esse usuário foi autenticado, mas não possui nenhum perfil de acesso. Favor entrar em contato com o administrador.", 14007);
         break;
 }


} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "Login";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
} 

