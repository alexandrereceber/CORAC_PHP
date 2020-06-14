class ViewWindows{
    constructor(Servidor){
        
    }
    
    showWindows(){
        //var Self = this;
        let FormsCampos = "<div class='container-explorer'>\n\
                                <div class='container-Directory'></div><div class='container-Files'></div>\n\
                            </div>"
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-lg", Largura: "80%", Altura: "700px"},
                                    Header: {Title: "Executar Arquivo", CorTexto: "white", backgroundcolor: "#007bff"}, 
                                    Body: {Conteudo: FormsCampos, Scroll: true}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "block", Funcao: function(Self){
                                                        
                                                }}, 
                                                Aceitar: {Nome: "Executar", classe: "" , Visible: "block", Funcao: function(Self){
                                                        
                                                }},
                                                Status: {Display: false, Conteudo: "Ola"}
                                            },
                                    Modal: {backdrop: "static", keyboard: true}
                                };
            this.CustomJanelaModal(Janela); 

    }
    
    CustomJanelaModal(o){
        var Componentes = o; /*{
                                    Janela: {Nome: "myJanelas", Tipo: false, Tamanho: "300px"},
                                    Header: {Title: "Excluir", CorTexto: "", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: Mensagem, Scroll: true}, 
                                    Footer: {
                                                Cancelar: {Nome: "nao", Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", Visible: "block", Funcao: function(){}},
                                                Status: {Display: false, Conteudo: ""}
                                            },
                                    Modal: {backdrop: false,keyboard: true}
                                };

                        };*/

        //$(".modal").css("display", "flex")
        if(Componentes.Janela.Tipo != false){
            $(".modal-dialog").removeClass("modal-sm").removeClass("modal-lg");
            $(".modal-dialog").addClass(Componentes.Janela.Tipo);
            $(".modal-dialog").css("width","inherit");
        }

        if(Componentes.Janela.Largura  != false){
            $(".modal-dialog").css("width",Componentes.Janela.Largura);
            $(".modal-dialog").css("max-width","100%");
        }

        if(Componentes.Janela.Altura  != false){
            $(".modal-content").css("height",Componentes.Janela.Altura);
            $(".modal-content").css("max-height","100%");
        }
        
        $(".modal-header").css("background-color", Componentes.Header.backgroundcolor);
        $(".modal-title").html(Componentes.Header.Title);
        $(".modal-title").css("color", Componentes.Header.CorTexto);
        
        if(Componentes.Body.Scroll){
            $(".modal-dialog").addClass("modal-dialog-scrollable")
        }else{
            $(".modal-dialog").removeClass("modal-dialog-scrollable")
        }
        
        $(".modal-body").html(Componentes.Body.Conteudo);

        if(Componentes.Footer.Status.Display == false){
            $(".status-footer").css("display","none")
        }else{
            $(".status-footer").css("display","initial")
            $(".status-footer").html(Componentes.Footer.Status.Conteudo)
        }
        
        $(".cancelar").css("display", Componentes.Footer.Cancelar.Visible);
        $(".cancelar").html(Componentes.Footer.Cancelar.Nome);
        $(".cancelar").unbind();
        $(".cancelar").click(Componentes.Footer.Cancelar.Funcao);
        $(".cancelar").addClass(Componentes.Footer.Cancelar.classe);
        
        $(".ok").css("display", Componentes.Footer.Aceitar.Visible);
        $(".ok").html(Componentes.Footer.Aceitar.Nome);
        $(".ok").unbind();
        $(".ok").click(Componentes.Footer.Aceitar.Funcao);
        $(".ok").addClass(Componentes.Footer.Aceitar.classe);
        
        $("#" + Componentes.Janela.Nome).modal(Componentes.Modal);

    }


}

var Janela = new ViewWindows();
Janela.showWindows();