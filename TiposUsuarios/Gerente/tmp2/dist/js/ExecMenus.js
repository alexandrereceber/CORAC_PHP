/* 
 * Executa ações ligadas a cada menu lateral
 */
var Tabela_Computadores = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
var Comandos_CORAC = new Commands("http://"+ Padrao.getHostServer() +"/CORAC/getInformacoesMaquinas/");

let Origem = false;

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
        Tabela_Computadores.FuncoesIcones[0] = async function(){
            
            let Rst = await Comandos_CORAC.getCommand("get-date");
            if(Rst == false) return false;
            
            $("#Container1-MenuInforFlash").html(  
                            "<div id='Container2-MenuInforFlash' class='row' data-original-title='' title=''>"+
                                "<div id='MenuInforFlash' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''>"+
                                    "<nav class='menu-navigation-dark'>"+
                                        "<a href='#'><i class='fas fa-user'></i><span>Usuário</span></a>"+
                                        "<a href='#'><i class='mdi mdi-desktop-mac'></i><span>Placa Mãe</span></a>"+
                                        "<a href='#' class=''><i class='fas fa-cogs'></i><span>Sistema Op</span></a>"+
                                        "<a href='#' class=''><i class='mdi mdi-memory'></i><span>Processador</span></a>"+
                                        "<a href='#'><i class='fas fa-microchip'></i><span>Memória</span></a>"+
                                    "</nav>"+
                                "</div>"+
                            "</div>").css("display","none");
            $("#Container1-MenuInforFlash").fadeIn("slow");
        };

        Tabela_Computadores.show();
        window.onscroll = function(){
            if(window.scrollY>70){
                if(!Origem){
                    $("#Container1-MenuInforFlash").css("position","fixed");
                    $("#Container1-MenuInforFlash").css("top","0px");
                    $("#Container1-MenuInforFlash").css("left","0px");
                    $("#Container1-MenuInforFlash").css("display","none");
                    $("#Container1-MenuInforFlash").fadeIn("slow");  
                    Origem = true;
                }
               
            }else{
                if(window.scrollY<70){
                    if(Origem){
                        $("#Container1-MenuInforFlash").css("position","absolute");
                        $("#Container1-MenuInforFlash").css("left","initial");
                        $("#Container1-MenuInforFlash").css("top","initial");
                        $("#Container1-MenuInforFlash").css("display","none");
                        $("#Container1-MenuInforFlash").fadeIn("slow"); 
                        Origem = false
                    }
                    
                }
            }
        };
    }
    MenuLateral_Submenu_Controler_Auto(){
        $(".page-title").html("Agentes Autônomos")
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