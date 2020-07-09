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
        this.Botao_Selecionado_GI = {Botao : null};
        this.Maquina = null;
        this.Comandos = null;
        this.ScriptBD = false;
    }
    
    set Maquinas(M){
        this.Maquina = M;
    }
        
    set Comando(C){
        this.Comandos = C;
    }
    
    set Script(y){
        this.DadosEnvio.Script = y;
    }
    /**
     * Busca as informações gerais da máquina como o nome do usuário logado, a placa mãe, o sistem operacional, processador e a quantidade de memória.
     * Assíncrono
     */
    async get_InformacoesMaquina(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
 
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_InfoGeral";
        this.DadosEnvio.ScriptBD = this.ScriptBD;
        
        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        this.Resultado = JSON.parse(TratarResposta.RST_AG);
        
        this.get_InforGeral();

        return true;
    }

    /**
     * Trata os resultados da busca das informações gerais da máquina selecionada.
     */
    async get_InforGeral(){
        let Self = this;

        let ArrayUser = (this.Resultado[0].Usuario).split("-");

        
        let Usuario = ArrayUser[ArrayUser.length - 1];
        let PlacaMae = this.Resultado[0].PlacaMae;
        let SOCaption = (this.Resultado[0].SOCaption).replace("Windows","");
        let Memoria = Number((this.Resultado[0].Memoria) / (1024 * 1024)).toFixed(2) + " GB";
        let Regx = /(i[0-5]|Celerom).*/ig
        
        let Processador = Regx.exec(this.Resultado[0].Processador)[0];  
        $("#Container1-MenuInforFlash").html(  
        "<div id='Container2-MenuInforFlash' class='row' data-original-title='' title=''>"+
            "<div id='MenuInforFlash' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''>"+
                "<nav class='menu-navigation-dark'>"+
                    "<a data-index=0 id='Bt_Usuario' href='#' class='Bt_INF_G'><i class='fas fa-user'></i><span>"+ Usuario +"</span></a>"+
                    "<a data-index=1 id='Bt_PlacaMae'  href='#' class='Bt_INF_G'><i class='mdi mdi-desktop-mac Bt_INF_G'></i><span>"+ PlacaMae +"</span></a>"+
                    "<a data-index=2 id='Bt_SOCaption'  href='#' class='Bt_INF_G'><i class='fas fa-cogs Bt_INF_G'></i><span>"+ SOCaption +"</span></a>"+
                    "<a data-index=3 id='Bt_Processador'  href='#' class='Bt_INF_G'><i class='mdi mdi-memory Bt_INF_G'></i><span>"+ Processador +"</span></a>"+
                    "<a data-index=4 id='Bt_Memoria'  href='#' class='Bt_INF_G'><i class='fas fa-microchip Bt_INF_G'></i><span>"+ Memoria +"</span></a>"+
                "</nav>"+
            "<i id='BIGmini' class='fas fa-arrow-circle-up'></i>"+
            "</div>"+
        "</div>").css("display","none");

        $("#Container1-MenuInforFlash").fadeIn("slow");
        
        $("#Barra_InfoContainer").remove();
        
        this.Show_BarraLateral();
        
        $("#BIGmini").click(function(event){
            Self.MinMax_MenuGeral(event);
        });
        
        $(".Bt_INF_G").click(function(e){
            
            if(Self.Botao_Selecionado.Botao != null){
                let BotaoAtual = Self.Botao_Selecionado.Botao;
                $("#"+BotaoAtual).removeClass("Active");                
            }

                
             if(Self.Botao_Selecionado_GI.Botao == null){
                Self.Botao_Selecionado_GI.Botao = e.currentTarget;
                $(Self.Botao_Selecionado_GI.Botao).addClass("Active");
            }
            else {
                let BotaoAtual = Self.Botao_Selecionado_GI.Botao;
                $(Self.Botao_Selecionado_GI.Botao).removeClass("Active");
                $(e.currentTarget).addClass("Active");
                Self.Botao_Selecionado_GI.Botao = e.currentTarget;
            }
            
            let idnx = parseInt(Self.Botao_Selecionado_GI.Botao.dataset.index);
            let IMG = Self.Icones_PNG("BMG", idnx);
            $("#C_inf_C_Geral_Img").html(IMG);
            
            if(Self.Barra_Lateral.Min == true){
                Self.MinMax_Barra_Lateral();
            }
            Self.Bt_ObterInfoGeral(idnx);
        });
    }

    Bt_ObterInfoGeral(i){
        switch (i) {
            case 0:
                this.Bt_InfoGeral_Usuario();
                break;

            case 1:
                this.Bt_InfoGeral_Hora();
                break;
                
            default:
                
                break;
        }   
    }
    
     /**
     * Busca informações relativas ao usuário que está logado no sistema no momento.
     * Tipo: SVG
     */
    async Bt_InfoGeral_Hora(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "placamaehtml";

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        this.Resultado = JSON.parse(TratarResposta.RST_AG);
        
    }
    
     /**
     * Busca informações relativas ao usuário que está logado no sistema no momento.
     * Tipo: SVG
     */
    async Bt_InfoGeral_Usuario(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_UsuarioLogado";

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        this.Resultado = JSON.parse(TratarResposta.RST_AG);
        
    }

     /**
     * Maximiza ou minimiza o menu principal da informaçãoes gerais.
     */
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

     /**
     * Maximiza ou minimiza a caixa lateral que apresenta detalhes de cadas item selecionado.
     */
    MinMax_Barra_Lateral(p){
        if(this.Barra_Lateral.Min){
            let ant = $("#Regulador_Info").parent();
            $(ant).animate({width:"100%"})
            let Depois = $("#Regulador_Info").children();
            $(Depois).removeClass("fa-angle-double-left");
            $(Depois).addClass("fa-angle-double-right");
            this.Barra_Lateral.Min = false;
            $("#Regulador_Info").css("width","20px").css("padding-left","5px");
            
            $("#Container1-MenuInforFlash").css("position","fixed");
            $("#Container1-MenuInforFlash").css("top","0px");
            $("#Container1-MenuInforFlash").css("left","0px");
            $("#Container1-MenuInforFlash").css("display","none");
            $("#Container1-MenuInforFlash").fadeIn("slow");
            $(".menu-navigation-dark a").css("padding","3px").css("font-size","27px");
        }else{
            let ant = $("#Regulador_Info").parent();
            $(ant).animate({width:"14px"})
            let Depois = $("#Regulador_Info").children();
            $(Depois).removeClass("fa-angle-double-right");
            $(Depois).addClass("fa-angle-double-left");
            this.Barra_Lateral.Min = true;
            $("#Regulador_Info").css("width","20px").css("border-right","").css("padding-left","");
            
            $("#Container1-MenuInforFlash").css("position","absolute");
            $("#Container1-MenuInforFlash").css("left","initial");
            $("#Container1-MenuInforFlash").css("top","initial");
            $("#Container1-MenuInforFlash").css("display","none");
            $("#Container1-MenuInforFlash").fadeIn("slow");
            $(".menu-navigation-dark a").css("padding","9px").css("font-size","29px");

        }
    }

    /**
     * Cria a caixa que apresenta detalhes de cadas item selecionado.
     */
    Show_BarraLateral(){
        let Self = this;
        $(".page-wrapper").append("\
                            <div id='Barra_InfoContainer'>\n\
                                <div id='Regulador_Info'>\n\
                                    <i class='fas fa-angle-double-left RegulaWidth'></i>\n\
                                </div>\n\
                                <div id='Conteudo_info'>\n\
                                    <div id='C_inf_Conteiner_Geral'>\n\
                                        <div id='C_inf_C_Geral_botoes_Container'>\n\
                                            <div id='BarraContainer' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''>\n\
                                                <nav id='Barra_Icones_GetInfo' class='menu-navigation-claro'></nav>\n\
                                            </div>\n\
                                        </div>\n\
                                        <div id='C_inf_C_Geral_Desc_Container'>\n\
                                            <div id='C_info_Cabecalho'>\n\
                                                <div id='C_inf_Desc'>\n\
                                                    <div id='C_Inf_Cab_NomeMaquina'>"+ this.DadosEnvio.AA_CORAC +"</div>\n\
                                                    <div id='C_Inf_Cab_IPMaquina'>"+ this.Resultado[0].IP +"</div>\n\
                                                </div>\n\
                                            </div>\n\
                                            <div id='C_inf_C_Geral_Img'></div>\n\
                                            <div id='C_inf_C_Geral_AA'></div>\n\
                                        </div>\n\
                                    </div>\n\
                                </div>\n\
                            </div>");

        $("#Regulador_Info").click(function(event){
            Self.MinMax_Barra_Lateral();
        })
        
        this.addBotoes_BarraLateral();
    }

    /**
     * Cria os botões da caixa lateral de detalhes.
     */
    addBotoes_BarraLateral(){
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
            let _Icone = _Nome.replace("{Icone}", this.Icones_SVG(Bt[i].Nome));
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
            
            if(Self.Botao_Selecionado_GI.Botao != null){
                let BotaoAtual = Self.Botao_Selecionado_GI.Botao;
                $(Self.Botao_Selecionado_GI.Botao).removeClass("Active");
            }
            
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
            let IMG = Self.Icones_PNG("BLE", idnx);
            $("#C_inf_C_Geral_Img").html(IMG);
        })
        
        }
        

    }
    
    /**
     * Trata os erros que são gerados no servidor WEB php CORAC.
     * @param {array} Erros
     * @returns {void}
     */
    TratarErros(Erros){

        switch(Erros.Codigo){
            
            case 50000:
                    bootbox.alert('<h3 style="color: red"> ' + this.Icones_SVG("Error50000") + " " + Erros.Mensagem +"</h3>");
            
            break;
            
            case 11005:
            case 12006:
                bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>");
                window.location = Erros.Dominio + "Logar";
                break;
                
          
            default:
                bootbox.alert("<h3 style='color: red'><i class='fas fa-times' style='color: red; font-size: 27px' data-original-title='' title=''></i> " + Erros.Mensagem +"</h3>");
               break;
        }
    }
    /**
     * Armazena os ícones utilizados pelo sistema em forma de índice.
     * Tipo: SVG
     */
    Icones_SVG(IDX){
        var I = [], Endereco = "http://192.168.15.10/CORAC"
        I["Error50000"] = '<svg style="width: 33px" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="terminal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-terminal fa-w-20 fa-7x"><g class="fa-group"><path fill="currentColor" d="M640 421.34v32a24 24 0 0 1-24 24H312a24 24 0 0 1-24-24v-32a24 24 0 0 1 24-24h304a24 24 0 0 1 24 24z" class="fa-secondary"></path><path fill="currentColor" d="M29.7 464.66L7 442a24 24 0 0 1 0-33.9l154-154.76L7 98.6a24 24 0 0 1 0-33.9L29.7 42a24 24 0 0 1 33.94 0L258 236.37a24 24 0 0 1 0 33.94L63.64 464.66a24 24 0 0 1-33.94 0z" class="fa-primary"></path></g></svg>';
        I["Rede"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="network-wired" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-network-wired fa-w-20 fa-7x"><path fill="currentColor" d="M632 240H336v-80h80c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H224c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h80v80H8c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h120v80H64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h320v80h-64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h120c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zM224 384v96H64v-96h160zm0-256V32h192v96H224zm352 256v96H416v-96h160z" class=""></path></svg>';
        I["DiscoRigido"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Processador"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Video"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Mouse"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Audio"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Teclado"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Memoria"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        
       return I[IDX];
    }

     /**
     * Armazena os ícones utilizados pelo sistema em forma de índice.
     * Tipo: PNG
     */
    Icones_PNG(Barra, IDX ){
        var I = [], Endereco = "http://192.168.15.10/CORAC";
        
        switch (Barra) {
            case "BMG":
                I[0] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/Usuario.png?q=1' />";
                I[1] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/PlacaMae.png?q=1' />";
                I[2] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/SOCaption.png?q=1' />";
                I[3] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/Processador.png?q=1' />";
                I[4] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/Memorias.png?q=1' />";
                
                break;
             case "BLE":
                I[0] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/Network.png?q=1' />";
                I[1] = "<img  class='IMGBotaoSelecionado' src='" + Endereco + "/Imagens/InfoGerais/DiscoRigido.png?q=3' />";
                
                break;               
            default:
                
                break;
        }
        
       return I[IDX];
    }
}

