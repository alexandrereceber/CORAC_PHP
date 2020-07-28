<?php
if(@!include_once __DIR__ . "/../../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]    = true;
    $ResultRequest["Codigo"]   = 12000;
    $ResultRequest["Mensagem"] = "O arquivo de Configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 

/**
 * Inclui o arquivo que contém as classes com o nome das tabelas do banco de dados AcessoBancoDados::get_BaseDados()
 */
if(!@include_once ConfigSystema::get_Path_Systema() . '/BancoDados/TabelasBD/'. AcessoBancoDados::get_BaseDados() .'.php'){
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]    = true;
    $ResultRequest["Codigo"]   = 12001;
    $ResultRequest["Mensagem"] = "A configuração do banco de dados não foi encontrado.";
    
    echo json_encode($ResultRequest); 
    exit;
}
/**
 * Armazena o tempo inicial do processamento.
 */
ConfigSystema::getStartTimeTotal();
$URL            = $_REQUEST["URL"];
$Requisicao     = $_REQUEST["Req"];
$SSL            = $_REQUEST["SSL"];
$ProcedureMD5   = $_REQUEST["sendProcedure"];
$Formato        = $_REQUEST["sendRetorno"]  == "" ? "JSON" : $_REQUEST["sendRetorno"]; //Atribui um formato padrão
$Dispositivo    = $_REQUEST["sendDispositivo"];

$Procedure      = ProcedureBancoDadosMD5::getMD5ForProcedures($ProcedureMD5);    //Nome da tabela no banco de dados

/**
 * Verifica se foi enviado, via post, a operação quer será realizada dentro do controllers. 
 * Ex: select, insert, delete, update
 */
try{
    if(empty($ProcedureMD5)) throw new Exception("Nenhuma procedure foi definida, favor entrar em contato com o administrador.", 3000);

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
    
    
} catch (Exception $ex) {
        $ResultRequest["Modo"]      = "D";
        $ResultRequest["Error"]     = true;
        $ResultRequest["Codigo"]    = $ex->getCode();
        $ResultRequest["Mensagem"]  = $ex->getMessage();
        $ResultRequest["Tracer"]    = $ex->getTraceAsString();
        $ResultRequest["File"]      = $ex->getFile();

        echo json_encode($ResultRequest);
        exit;
}

    
/**
 * Verifise se o sistema está em sessão ou não, isso caso o sistema tenha acesso gerencial, caso não tenha poderá
 * setar a variável de sessão como false. 
 * Sessão => O sistema buscará o usuário e a senha tendo como requisito o login do usuário. 
 * Sem sessão => O sistema busca as informações sem necessidade de usuário ou senha.
 */
$Sessao = ConfigSystema::get_Sessao();
$SessaoProcedure = ProcedureBancoDadosMD5::getProcedureSessao($ProcedureMD5);

/**
 * Para visualização dos dados por usuário e senha tanto a sessão quanto a tabela deverão esta configurados como true;
 */
if($Sessao && $SessaoProcedure){

    /**
     * Inclui o arquivo de classe que trata das sessões.
     */
    if(!@include_once ConfigSystema::get_Path_Systema() . '/Account/SDados.php'){
        $ResultRequest["Modo"]        = "Include";
        $ResultRequest["Error"]    = true;
        $ResultRequest["Codigo"]   = 3590;
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
              throw new Exception("Usuário inválido para essa sessão, favor entrar em contato com o administrador!.", 12003);  
            }

            $vt = $SD->ValidarTime();
            if(!$vt){
              $SD->DestruirSessao();
              throw new Exception("Tempos não estão sincronizados, favor entrar em contato com o administrador!.", 12004);  
            }

            $vts = $SD->ValidarTempoSessao();
            if(!$vts){
                $SD->DestruirSessao();
                throw new Exception("Tempo de sessão expirado, favor efetuar login novamente!.", 12005);
            }
        }else{
            $SD->DestruirSessao();
            throw new Exception("Login necessário, favor entrar em contato com o administrador!.", 12006);
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
            $ResultRequest["File"]      = "Cabecalho_Tabelas.php";
            $ResultRequest["Tracer"]    = "Linha 132";
            $ResultRequest["Dominio"]   =   ConfigSystema::getHttp_Systema();
            /**
             * Esse array armazena o endereço da página de login caso o usuário esteja tentando acesso sem esta logado via componente.
             */
            $ResultRequest["Error"][3]             = ConfigSystema::getHttp_Systema();
            echo json_encode($ResultRequest); 
            exit;

        }else{
            echo "<script>alert('". $exc->getMessage() ."'); window.location='". ConfigSystema::getHttp_Systema() ."'</script>";
            exit;
        }
    }


}

