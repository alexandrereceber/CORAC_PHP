<?php  
/**
 * Arquivo index que carrega páginas HTML de um banco de dados.
 * @date 18/08/2019
 */
error_reporting(0);

if(@!include_once __DIR__ . "/../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]    = true;
    $ResultRequest["Codigo"]   = 10000;
    $ResultRequest["Mensagem"] = "O arquivo de Configuração não foi encontrado. ";

    echo "<script defer='defer'>alert('". $ResultRequest["Codigo"]. ": " . $ResultRequest["Mensagem"] ."')</script></body>";
    exit;
}; 
/**
 * Inclui o arquivo que contém as classes com o nome das tabelas do banco de dados AcessoBancoDados::get_BaseDados()
 */
if(!@include_once ConfigSystema::get_Path_Systema() . '/BancoDados/TabelasBD/'. AcessoBancoDados::get_BaseDados() .'.php'){
    $ResultRequest["Modo"]        = "Include";
    $ResultRequest["Error"]    = true;
    $ResultRequest["Codigo"]   = 10001;
    $ResultRequest["Mensagem"] = "A configuração do banco de dados não foi encontrado. ";

    echo "<script defer='defer'>alert('". $ResultRequest["Codigo"]. ": " . $ResultRequest["Mensagem"] ."')</script>";
    exit;
}

AmbienteCall::setCall(true);
AmbienteCall::setPageCall("Gerente.php");
AmbienteCall::setTypeUser("Gerente");

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/SegurityPages/SecurityPgs.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
};

try{

    ConfigSystema::getStartTimeTotal();
    $Requisicao     = $_REQUEST["pgweb"];

    $Saida = explode('/', $Requisicao);
    $Total = count($Saida) - 1;
    /**
     * Verifica se a busca é por texto ou númerica.
     * Campo = 0 - ID da página
     * Campo = 1 - É o título da página.
     */
    $Campo = is_numeric($Saida[$Total]) == true  ? 0 : 1;
    $Saida = $Saida[$Total];
    
    if(!@include_once '../Controller/LP/LoadPages.php'){
        $ResultRequest["Modo"]     = "LoadPaginasWEB";
        $ResultRequest["Error"]    = true;
        $ResultRequest["Codigo"]   = 10002;
        $ResultRequest["Mensagem"] = "O arquivo de configuração do código HTML não foi localizado.";

        echo "<script defer='defer'>alert('". $ResultRequest["Codigo"]. ": " . $ResultRequest["Mensagem"] ."')</script>";
        exit;
    }
    
$Pagina = new LoadPages($Campo, $Saida);


} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "LoadPage";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Trace"]     = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo "<script defer='defer'>bootbox.alert('". $ResultRequest["Codigo"]. ": " . $ResultRequest["Mensagem"] ."')</script>";

}

?>

<!DOCTYPE html>

<html>
    
<?php
   if($Pagina->getPaginaExist() && $Pagina->getPaginaAtiva()){
        /*Página Encontrada*/
        if($Pagina->getTotalByte() > 0){
            echo '<head>
                    ' . $Pagina->getCodigoHead() . '
                 </head>
                 <body>
                     <div id="CodigoHTMLPWEB" data-editarpropriedades=false style="display:flex; width:99vw; height:100vh">
                         ' . $Pagina->getCodigoHTML() . '
                     </div>
                 </body>';            
            
        }
        else {
            echo 
            '   <head>
                    <title></title>
                    <meta charset="UTF-8">
                    <meta http-equiv="CACHE-CONTROL" content="Private">
                    <meta http-equiv="CACHE-CONTROL" content="cache">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                    <div id="CodigoHTMLPWEB" data-editarpropriedades=false style="display:flex; width:99vw; height:100vh">
                    </div>
                </body>';          
        }


echo 
    '<div id="FerramentasOnJustTime">
        <script>var Chave="'.$sendChave.'", IDPWEB="'. $Pagina->getIDPWEB() . '"</script>
        <link rel="stylesheet" href="./CSS/CxFerramentaWEB/CxFerramentaWD.css?s='. time() .'">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <script  src="./Scripts/bootbox/bootbox.js?5a" defer="defer"></script>
        <script  src="./Scripts/jsControlador/jsConstroller.js?s='. time() .'" defer="defer"></script>     
        <script  src="./Componentes/jsControladorPWebEdit.js?s='. time() .'" defer="defer"></script>          
        <script  src="./Componentes/OCJustInTime.js?s='. time() .'" defer="defer"></script></div>';        

?>
    
<?php
   }else{
       /*Página não encontrada*/
?> 
    <body>
        <center>
            <div><image src= "<?php echo ConfigSystema::getHttp_Systema() ?>/Imagens/LoadPages/alert.png" style="width: 18%;top: 64px;position: relative;"/></div> 
            <div><image src="<?php echo ConfigSystema::getHttp_Systema() ?>/Imagens/LoadPages/error-404.png" style="width: 30%;top: 64px;position: relative;" /></div>
        </center>
    </body>
<?php 
    }
   ?>            

</html>
