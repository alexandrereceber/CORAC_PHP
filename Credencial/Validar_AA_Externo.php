<?php

/* 
 * Verifica o usuário e senha
 * Esquema da tabela que deverá ser criada em todos os banco de dados para o login e cadastro de usuário
 * * 
 *
 CREATE TABLE `assinatura_aa_externos` (
 `idChave` varchar(150) NOT NULL,
 `Nome` varchar(100) NOT NULL,
 `Empresa` varchar(100) NOT NULL,
 `Habilitada` tinyint(1) NOT NULL DEFAULT '1',
 `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`idChave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
 */


/**
 * Criado: 30/10/2018
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes ao assinatura_aa_externos.
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
$Dispositivo    = $_REQUEST["Dispositivo"];
$URI            = $_SERVER["REQUEST_URI"];



try {
$Separar_URI = explode("/",$URI);
if($Separar_URI[3] == "")    throw  new Exception ("Chaves invalidas!", 560000);
    $SelecionarDados = new assinatura_aa_externos();

    $SelecionarDados->setUsuario("CORAC");
    $FiltroCampos = [
                        [
                            [
                                0=>0,
                                1=>"=",
                                2=>$Separar_URI[3]
                            ],
                            [
                                0=>1,
                                1=>"=",
                                2=>$Separar_URI[4],
                                3=> 1
                            ],
                            [
                                0=>2,
                                1=>"=",
                                2=>$Separar_URI[5],
                                3=> 1
                            ],
                            [
                                0=>3,
                                1=>"=",
                                2=>$Separar_URI[6],
                                3=> 1
                            ]
                        ]
                    ];
    
    
    $SelecionarDados->setFiltros($FiltroCampos);
    $SelecionarDados->Select();
    $Assinatura = $SelecionarDados->getArrayDados()[0];

    $Pacote_signature["Error"] = false;
    $Pacote_signature["idChave"]=$Assinatura[0];
    $Pacote_signature["Maquina"]=$Assinatura[1];
    $Pacote_signature["Empresa"]=$Assinatura[2];
    $Pacote_signature["Signacture"]=$Assinatura[3];

    $Pacote_signature["Habilitada"]=$Assinatura[4];
    $Pacote_signature["Tempo"]=$Assinatura[5];
    $Pacote_signature["dtCriado"]=$Assinatura[6];
    $Pacote_signature["Modo"]      = "Assinatura_Externa";

    $Pacote_signature["Codigo"]    = "";
    $Pacote_signature["Mensagem"]  = "";
    $Pacote_signature["Tracer"]    = "";
    $Pacote_signature["File"]      = "";

    echo json_encode($Pacote_signature);
   

} catch (Exception $ex) {
    $ResultRequest["Error"] = true;
    $ResultRequest["idChave"]="";
    $ResultRequest["Maquina"]="";
    $ResultRequest["Empresa"]="";
    $ResultRequest["Habilitada"]="";
    $ResultRequest["Tempo"]="";
    $ResultRequest["dtCriado"]="";
    
    $ResultRequest["Modo"]      = "Assinatura_Externa";
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]    = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
} 

