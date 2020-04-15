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
/**
 * Classe que busca, via banco de dados, as página que serão carregadas no navegador.
 */
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
        if($Pagina->getTotalByte() > 0)
            echo $Pagina->getCodigoHTML();
        else {
            /**
             * Página em construção
             */
            echo 
            '<!DOCTYPE html>
            <html>
                <head>
                <title></title>
                    <meta charset="UTF-8">
                    <meta http-equiv="CACHE-CONTROL" content="Private">
                    <meta http-equiv="CACHE-CONTROL" content="cache">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                </body>
            </html>';          
        }
?>
    
<?php
   }else{
       /*Página não encontrada*/
?> 
    <body>
        <center>
            <image src="../Imagens/LoadPages/alert.png" style="width: 18%;top: 64px;position: relative;"/> 
            <image src="../Imagens/LoadPages/error-404.png" style="width: 30%;top: 64px;position: relative;" />
        </center>
    </body>
<?php 
    }
   ?>            

</html>
