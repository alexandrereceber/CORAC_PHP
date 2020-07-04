/* 
 * Date: 09/05/2020
 * Autor: Alexandre josé da silva marques
 */

class Commands extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Barra_Lateral = {Min:true};
        this.Menu_Geral = {Min:false};
        this.Botao_Selecionado = {Botao : null};
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
        $(".page-wrapper").append("\
                                    <div id='Barra_InfoContainer'>\n\
                                        <div id='Regulador_Info'>\n\
                                            <i class='fas fa-angle-double-left RegulaWidth'></i>\n\
                                        </div>\n\
                                        <div id='Conteudo_info'>\n\
                                            <div id='C_info_Cabecalho'>\n\
                                                <div id='C_inf_Img'></div>\n\
                                                <div id='C_inf_Desc'></div>\n\
                                            </div>\n\
                                            <div id='C_inf_Conteiner_Geral'>\n\
                                                <div id='C_inf_C_Geral_botoes_Container'><div id='BarraContainer' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''><nav id='Barra_Icones_GetInfo' class='menu-navigation-claro'></nav></div></div>\n\
                                                <div id='C_inf_C_Geral_Desc_Container'></div>\n\
                                            </div>\n\
                                        </div>\n\
                                    </div>");
        $("#Regulador_Info").click(function(event){
            Self.MinMax_Barra_Lateral();
        })
        this.addBotoes();
    }
    
    addBotoes(){
        let Self = this;
        let Bt = [
                    {
                        "IDX":0, 
                        "Nome":"Rede", 
                        "Funcao":function(){
                            //alert(9)
                        }, 
                        "Etiqueta":"Rede",
                        "Descricao":"Busca informações sobre as configurações de hardware e software da placa de rede da máquina.", 
                        "Active":false},
                    
                    {"IDX":1, "Nome":"DiscoRigido", "Funcao":null, "Etiqueta":"Disco Rígido","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":2, "Nome":"Memoria", "Funcao":null, "Etiqueta":"Memória","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":3, "Nome":"Processador", "Funcao":null, "Etiqueta":"Processador","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":4, "Nome":"Video", "Funcao":null, "Etiqueta":"Vídeo","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":5, "Nome":"Teclado", "Funcao":null, "Etiqueta":"Teclado","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":6, "Nome":"Mouse", "Funcao":null, "Etiqueta":"Mouse","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
                    {"IDX":7, "Nome":"Audio", "Funcao":null, "Etiqueta":"Áudio","Descricao":"Busca informações sobre os discos da máquina.", "Active":false},
               ]

        let Modelo_Botao = "<a href='#' class='{Class}' id='{Nome}' data-index={IDX} alt='{Descricao}'>{Icone}<span>{Etiqueta}</span></a>"
        
        for(var i in Bt){
            let _IDX = Modelo_Botao.replace("{IDX}",Bt[i].IDX);
            let _Nome = _IDX.replace("{Nome}",Bt[i].Nome);
            let _Icone = _Nome.replace("{Icone}", this.Icones(Bt[i].Nome));
            let _Etiqueta = _Icone.replace("{Etiqueta}",Bt[i].Etiqueta);
            let _Descricao = _Etiqueta.replace("{Descricao}",Bt[i].Descricao);
            let _BotaoCompleto = _Descricao.replace("{Active}",Bt[i].Active);
        
        /**
         * Adiciona uma função em cada botão relativa à sua representação.
         */
        $("#Barra_Icones_GetInfo").append(_BotaoCompleto);
        if(Bt[i].Funcao != null)
            $("#" + Bt[i].Nome).click(Bt[i].Funcao);
        
        /**
         * Aciona uma funcionalidade que será realizada por todos os botões.
         */
        $("#" + Bt[i].Nome).click(function(e){
            if(Self.Botao_Selecionado.Botao == null){
                Self.Botao_Selecionado.Botao = e.currentTarget.id;
                $("#"+Self.Botao_Selecionado.Botao).addClass("Active");
            }
            else {
                let BotaoAtual = Self.Botao_Selecionado.Botao;
                $("#"+BotaoAtual).removeClass("Active");
                $(e.currentTarget).addClass("Active");
                Self.Botao_Selecionado.Botao = e.currentTarget.id;
            }

            let idnx = parseInt(e.currentTarget.dataset.index);
            let IMG = Self.Icones(idnx);
            $("#C_inf_Img").html(IMG);
        })
        
        }
        

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
    
    Icones(IDX){
        var I = [], Endereco = "http://192.168.15.10/CORAC"
        I["Rede"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="network-wired" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-network-wired fa-w-20 fa-7x"><path fill="currentColor" d="M632 240H336v-80h80c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H224c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h80v80H8c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h120v80H64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h320v80h-64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h120c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zM224 384v96H64v-96h160zm0-256V32h192v96H224zm352 256v96H416v-96h160z" class=""></path></svg>';
        I["DiscoRigido"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Processador"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Video"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Mouse"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Audio"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Teclado"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I["Memoria"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>'
        I[0] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/Network.png?q=1' />";
        I[1] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/DiscoRigido.png?q=2' />";
        
       return I[IDX]
    }
}

