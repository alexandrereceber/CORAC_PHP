/* 
 * Executa ações ligadas a cada menu lateral
 */

'use strict';



var Tabela_Computadores = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
var Comandos_CORAC = new Commands("http://"+ Padrao.getHostServer() +"/CORAC/ExecRMTCMD/");
var AR_CORAC = new ControleRemoto("http://"+ Padrao.getHostServer() +"/CORAC/AA_AcessoRemoto_SYN/");

let Origem = false;
class MenuLateral{
    constructor(){
        //-----------------------------------------------------------------------------------------------

        /**
         * Deixa a barra lateral de menus minima
         * @type {type}
         */
        $("#main-wrapper").toggleClass("mini-sidebar");
        if ($("#main-wrapper").hasClass("mini-sidebar")) {
            $(".sidebartoggler").prop("checked", !0);
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $(".sidebartoggler").prop("checked", !1);
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
        //-----------------------------------------------------------------------------------------------
    }
    
    MenuLateral_Computadores(){
        $(".page-title").html("INFORMAÇÕES GERAIS E ACESSO REMOTO")
        Tabela_Computadores.Destroy();
        Tabela_Computadores.setTabela = "bb22afd6fd3058670dbdf0bcc064ddde";
        Tabela_Computadores.setRecipiente = "Conteudo_1";
        Tabela_Computadores.CSSTableGeral.GeralTableClass = "Tabela_Geral table-striped table-bordered";
        Tabela_Computadores.Name = "Tabela_Computadores";
        //Tabela_Computadores.Configuracao.Tabela.Linha.Select_Color="#c3e6cb";
        Tabela_Computadores.Configuracao.Tabela.Linha.Unselect_Color="rgb(232, 241, 234)";
        Tabela_Computadores.setDefaultOrderBy(3,"ASC")
        Tabela_Computadores.FuncoesChvExt[0] = function(){
            
        }
        Tabela_Computadores.Funcoes.Conteudo = function(i, v, p){
            v = parseInt(v);
            switch (v) {
                case 4:
                    if(p == "Ligada"){
                        return '<i class="fa fas fa-check" style="color: #10aa06"></i>';
                    }else{
                        return '<i class="fas fa-times" style="color: red"></i>';
                    }
                    break;
                    
                case 5:
                    if(p == 1){
                        return '<i class="fa fas fa-check" style="color: #10aa06"></i>';
                    }else{
                        return '<i class="fas fa-times" style="color: red"></i>';
                    }
                    break;

                                    
                case 6:
                    if(p == 1){
                        return '<i class="fa fas fa-check" style="color: #10aa06"></i>';
                    }else{
                        return '<i class="fas fa-times" style="color: red"></i>';
                    }
                    break;

                    
                case 7:
                    if(p == 1){
                        return '<i class="fa fas fa-check" style="color: #10aa06"></i>';
                    }else{
                        return '<i class="fas fa-times" style="color: red"></i>';
                    }
                    break;

                default:
                    return p;
                    break;
            };
        }
        Tabela_Computadores.FuncoesIcones[0] = function(){
            var Args = arguments;
            bootbox.confirm({
                title: "Informações Gerais",
                message: "<h3>Tem certeza que deseja executar essa operação?</h3>",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Não'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> OK'
                    }
                },
                callback: async function(result){
                if(!result) return false;
                try{
                    $("#Container2-MenuInforFlash").remove();
                    $("#Barra_InfoContainer").remove();
                    
                    var Tbl_CPU = Args[0],
                    Idx = 0,
                    Maquina = null;

                    Idx = Args[1].attributes["data-chaveprimaria"].nodeValue;
                    Tbl_CPU.setChavesPrimaria(Idx);
                    Maquina = Tbl_CPU.getObterValorCampos(3);
                    Comandos_CORAC.Maquina = Maquina;
                    await Comandos_CORAC.get_InformacoesMaquina();

//
//                    if(Rst_AA == false) return false;
//
//                    ShwInfo.addCaixa(Rst_AA[0].Usuario, Rst_AA[0].PlacaMae, Rst_AA[0].SOCaption, Rst_AA[0].Processador, Rst_AA[0].Memoria);
//                    ShwInfo.ShowCaixa();
                }catch(ex){
                    bootbox.alert("<h3><i class='fas fa-times' style='color: red; font-size: 27px' data-original-title='' title=''></i> " + ex +"</h3>");
                }
            }
            });
            
            
        };
        Tabela_Computadores.FuncoesIcones[1] = function(){

            var Args = arguments;
            bootbox.confirm({
                title: "Acesso Remoto",
                message: "<h3>Tem certeza que deseja executar essa operação?</h3>",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Não'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> OK'
                    }
                },
                callback: async function(result){
                if(!result) return false;
                try{

                    var Tbl_CPU = Args[0],
                    Idx = 0,
                    Maquina = null;

                    Idx = Args[1].attributes["data-chaveprimaria"].nodeValue;
                    Tbl_CPU.setChavesPrimaria(Idx);
                    Maquina = Tbl_CPU.getObterValorCampos(3);
                    //AR_CORAC.setPortaCORAC_Cliente(1199);
                    let Rst_AA =  await AR_CORAC.get_ControlAcessoRemoto(Maquina, 0);


                    if(Rst_AA == false) return false;


                }catch(ex){
                    bootbox.alert("<h3><i class='fas fa-times' style='color: red; font-size: 27px' data-original-title='' title=''></i> " + ex +"</h3>");

                }
            }
            });
            
            
        }
        Tabela_Computadores.FuncoesIcones[2] = function(){
            AR_CORAC.setCriarMonitores();
            AR_CORAC.setCriarChat();
        }
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

        Tabela_Computadores.Destroy();
        $(".page-title").html("Agentes Autônomos")
        Tabela_Computadores.setTabela = "e78169c2553f6f5abe6e35fe042b792a";
        Tabela_Computadores.setRecipiente = "Conteudo_1";
        Tabela_Computadores.CSSTableGeral.GeralTableClass = "Tabela_Geral table-striped table-bordered";
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
MenusLaterais.MenuLateral_Computadores();