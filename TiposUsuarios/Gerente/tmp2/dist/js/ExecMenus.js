/* 
 * Executa ações ligadas a cada menu lateral
 */
var Tabela_Computadores = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");

class MenuLateral{
    constructo(){

    }
    MenuLateral_Computadores(){
        $(".page-title").html("Computadores Gerenciados")
        Tabela_Computadores.setTabela = "bb22afd6fd3058670dbdf0bcc064ddde";
        Tabela_Computadores.setRecipiente = "Conteudo_1";
        Tabela_Computadores.GeralDivClass = "Tabela_Geral table-striped table-bordered";
        Tabela_Computadores.Name = "Tabela_Computadores";
        Tabela_Computadores.Configuracao.Tabela.Linha.Select_Color="#c3e6cb";
        Tabela_Computadores.Configuracao.Tabela.Linha.Unselect_Color="initial";
        Tabela_Computadores.setDefaultOrderBy(3,"ASC")
        Tabela_Computadores.FuncoesChvExt[0] = function(){
            
        }
        Tabela_Computadores.show();
    }
    MenuLateral_Submenu_Controler_Auto(){
        $(".page-title").html("Controlar - Agentes Autônomos")
        Tabela_Computadores.setTabela = "e78169c2553f6f5abe6e35fe042b792a";
        Tabela_Computadores.setRecipiente = "Conteudo_1";
        Tabela_Computadores.GeralDivClass = "Tabela_Geral table-striped table-bordered";
        Tabela_Computadores.Name = "Tabela_Computadores";
        Tabela_Computadores.Configuracao.Tabela.Linha.Select_Color="#c3e6cb";
        Tabela_Computadores.Configuracao.Tabela.Linha.Unselect_Color="initial";
        //Tabela_Computadores.setDefaultOrderBy(3,"ASC")
        Tabela_Computadores.FuncoesChvExt[0] = function(){
            
        }
        Tabela_Computadores.show();
    }
}

var MenusLaterais = new MenuLateral();