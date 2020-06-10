<?php

/**
 * Criado: 09/05/2020
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes aos agentes autônomos.
 * @Autor 04953988612


error_reporting(0);

if(@!include_once "../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi Cabeçaalho. Cabeçalho Geral";
    
    echo json_encode($ResultRequest);
    exit;
};

AmbienteCall::setCall(false);

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/SegurityPages/SecurityPgs.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
};

if(@!include_once ConfigSystema::get_Path_Systema() .  "/AgentesCORAC/Connect_AA.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Connect_AA";
    
    echo json_encode($ResultRequest);
    exit;
};

ConfigSystema::getStartTimeTotal();
$URL            = $_REQUEST["URL"];
$Requisicao     = $_REQUEST["Req"];
$Metodo         = $_REQUEST["Metodo"];
$SSL            = $_REQUEST["SSL"];
$Formato        = $_REQUEST["sendRetorno"]  == "" ? "JSON" : $_REQUEST["sendRetorno"]; //Atribui um formato padrão

ConfigPowershell::setServidor($AA_CORAC);
 */
?>
<!DOCTYPE html>
<!--
Template do chat online do CORAC
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Alexandre José da Silva Marques">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="./TiposUsuarios/Gerente/tmp2/assets/images/CORAC/ico/32px_Corac.ico">
        
        <title>Chat - CORAC</title>
        
        <link href="../TiposUsuarios/Gerente/tmp2/dist/css/style.min.css?t=<?php echo time(); ?>" rel="stylesheet">
        <link href="../TiposUsuarios/Gerente/tmp2/dist/css/CORAC/Corac_Custom.css?t=<?php echo time(); ?>" rel="stylesheet">


        <!-- Custom Theme JavaScript -->
        <script src="/CORAC/TiposUsuarios/Gerente/tmp2/assets/libs/jquery/dist/jquery.min.js" defer=""></script>
        <script src="/CORAC/Scripts/bootbox/bootbox.js?t=<?php echo time(); ?>" defer=""></script>
        <script src="/CORAC/Componentes/CHAT_CORAC.js?t=<?php echo time(); ?>" defer=""></script>

    </head>
    <body>

        <!--chat Row -->
        <ul id="Chat-List" class="chat-list">
        </ul>

    </body>
</html>