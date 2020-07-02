/* 
 * Date: 09/05/2020
 * Autor: Alexandre josé da silva marques
 */

class Commands extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Barra_Lateral = {Min:true}
        this.Menu_Geral = {Min:false}
    }
    
    async get_InformacoesMaquina(Maquina, Comando){
        this.DadosEnvio.AA_CORAC = Maquina;
        this.DadosEnvio.Command = Comando;

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        TratarResposta = JSON.parse(TratarResposta.RST_AG);
        
        switch (Comando) {
            case "get_InfoGeral":
                this.get_InforGeral(TratarResposta);

                break;
                
            default:
                
                break;
        }
        return true;
    }
    
    async get_InforGeral(TratarResposta){
        let Self = this;

        let ArrayUser = (TratarResposta[0].Usuario).split("-");

        
        let Usuario = ArrayUser[ArrayUser.length - 1];
        let PlacaMae = TratarResposta[0].PlacaMae;
        let SOCaption = (TratarResposta[0].SOCaption).replace("Windows","");
        let Memoria = Number((TratarResposta[0].Memoria) / (1024 * 1024)).toFixed(2) + " GB";
        let Regx = /(i[0-5]|Celerom).*/ig
        
        let Processador = Regx.exec(TratarResposta[0].Processador)[0];  
        $("#Container1-MenuInforFlash").html(  
        "<div id='Container2-MenuInforFlash' class='row' data-original-title='' title=''>"+
            "<div id='MenuInforFlash' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''>"+
                "<nav class='menu-navigation-dark'>"+
                    "<a href='#'><i class='fas fa-user'></i><span>"+ Usuario +"</span></a>"+
                    "<a href='#'><i class='mdi mdi-desktop-mac'></i><span>"+ PlacaMae +"</span></a>"+
                    "<a href='#' class=''><i class='fas fa-cogs'></i><span>"+ SOCaption +"</span></a>"+
                    "<a href='#' class=''><i class='mdi mdi-memory'></i><span>"+ Processador +"</span></a>"+
                    "<a href='#'><i class='fas fa-microchip'></i><span>"+ Memoria +"</span></a>"+
                "</nav>"+
            "<i id='BIGmini' class='fas fa-arrow-circle-up'></i>"+
            "</div>"+
        "</div>").css("display","none");
        $("#Container1-MenuInforFlash").fadeIn("slow");
        $("#Barra_InfoContainer").remove();
        this.Show_BarraLateral();
        $("#BIGmini").click(function(event){
            Self.MinMax_MenuGeral(event);
        })
    }
    
    MinMax_MenuGeral(p){
        p = p.currentTarget;
        if(this.Menu_Geral.Min){
            $(".menu-navigation-dark").fadeIn();

            $(p).removeClass("fa-arrow-alt-circle-down");
            $(p).addClass("fa-arrow-circle-up");
            $(p).css("font-size","15px")

            this.Menu_Geral.Min = false;
        }else{
            $(p).removeClass("fa-arrow-circle-up");
            $(p).addClass("fa-arrow-alt-circle-down");
            $(p).css("font-size","25px")
            
            $(".menu-navigation-dark").fadeOut();
            this.Menu_Geral.Min = true;
        }
    }
    MinMax_Barra_Lateral(p){
           if(this.Barra_Lateral.Min){
                let ant = $("#Regulador_Info").parent();
                $(ant).animate({width:"100%"})
                let Depois = $("#Regulador_Info").children();
                $(Depois).removeClass("fa-angle-double-left");
                $(Depois).addClass("fa-angle-double-right");
                this.Barra_Lateral.Min = false;
                $("#Regulador_Info").css("width","20px").css("padding-left","5px")
            }else{
                let ant = $("#Regulador_Info").parent();
                $(ant).animate({width:"14px"})
                let Depois = $("#Regulador_Info").children();
                $(Depois).removeClass("fa-angle-double-right");
                $(Depois).addClass("fa-angle-double-left");
                this.Barra_Lateral.Min = true;
                $("#Regulador_Info").css("width","20px").css("border-right","").css("padding-left","")
            }
    }
    Show_BarraLateral(){
        let Self = this;
        $(".page-wrapper").append("<div id='Barra_InfoContainer'><div id='Regulador_Info'><i class='fas fa-angle-double-left RegulaWidth'></i></div><div id='Conteudo_info'></div></div>");
        $("#Regulador_Info").click(function(event){
            Self.MinMax_Barra_Lateral();
        })
    }
    
    /**
     * 
     * @param {array} Erros
     * @returns {void}
     */
    TratarErros(Erros){

        switch(Erros.Codigo){
            case 11005:
            case 12006:
                bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>");
                window.location = Erros.Dominio + "Logar";
                break;
                
          
            default:
                bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>");
                break;
        }
    }
}

