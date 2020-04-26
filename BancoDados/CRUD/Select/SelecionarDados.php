<?php

/**
 * @author Alexandre José da Silva Marques
 * @Criado: 09/11/2018
 * @filesource
 * 
 */

$Pagina = $_REQUEST["sendPagina"];
/**
 * [0][0][0] = "Campo"
 * [0][0][1] = "Operador"
 * [0][0][2] = "Operando"
 *-----------Mesmo campos ----------
 * [1][0][0] = "Campo"
 * [1][0][1] = "Operador"
 * [1][0][2] = "Operando"
 * 
 * [1][1][0] = "Campo"
 * [1][1][1] = "Operador"
 * [1][1][2] = "Operando"
 *---------------------------------
 */
$FiltroCampos = $_REQUEST["sendFiltros"];
$Ordem = $_REQUEST["sendOrdemBY"];
try{

    if(empty($Tabela)) throw new Exception("Nenhuma tabela foi definida, favor entrar em contato com o administrador.", 3000);
    if(!class_exists($Tabela)) throw new Exception("A classe que representa essa tabela não foi encontrada.", 3001);
    
    $SelecionarDados = new $Tabela();
    $SelecionarDados->StartClock();

    $SelecionarDados->setUsuario("CORAC");
    $SelecionarDados->setFiltros($FiltroCampos);
    $SelecionarDados->setOrderBy($Ordem);
    $SelecionarDados->setPagina($Pagina);
    $SelecionarDados->Select();
    $SelecionarDados->EndClock();


    switch ($Formato) {

        case "XML":


            break;
        case "JSON":
            $ResultRequest["Modo"]             = "S";
            $ResultRequest["Error"]             = false;
            $ResultRequest["NomeTabela"]        = TabelaBancoDadosMD5::getTabelaForMD5($Tabela);
            $ResultRequest["ResultDados"]       = $SelecionarDados->getArrayDados();
            $ResultRequest["Campos"]            = $SelecionarDados->getInfoCampos();
            $ResultRequest["ChavesPrimarias"]   = $SelecionarDados->getChaves();
            $ResultRequest["Paginacao"]         = $SelecionarDados->getPaginacao();
            $ResultRequest["InfoPaginacao"]     = $SelecionarDados->getInfoPaginacao();
            $ResultRequest["Botoes"]            = $SelecionarDados->getBotoes();
            $ResultRequest["ContadorLinha"]     = $SelecionarDados->getMostrarContador();
            $ResultRequest["OrdemBy"]           = $SelecionarDados->getOrderBy();
            $ResultRequest["Filtros"]           = $SelecionarDados->getFiltros();
            $ResultRequest["ShowColumnsIcones"] = $SelecionarDados->showColumnsIcones();
            $ResultRequest["Formato"]          = "JSON";
            $ResultRequest["Indexador"]         = time();

           /**
            * Armazena o tempo gasto com o processamento até esse ponto. Select
            */
            ConfigSystema::getEndTimeTotal();
            $ResultRequest["TempoTotal"]["BancoDados"]  = $SelecionarDados->getTempoTotal();
            $ResultRequest["TempoTotal"]["SitemaTotal"] = ConfigSystema::getTimeTotal();

            echo json_encode($ResultRequest);

            break;
        
        case "PDF":


            break;


        default:
            throw new Exception("O retorno não foi informado");
            break;
    }

} catch (Exception $ex) {
    $ResultRequest["Modo"]      = "S";
    $ResultRequest["Error"]     = true;
    $ResultRequest["Codigo"]    = $ex->getCode();
    $ResultRequest["Mensagem"]  = $ex->getMessage();
    $ResultRequest["Tracer"]     = $ex->getTraceAsString();
    $ResultRequest["File"]      = $ex->getFile();

    echo json_encode($ResultRequest);
}