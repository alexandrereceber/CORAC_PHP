/* 
 * Date: 09/05/2020
 * Autor: Alexandre josé da silva marques
 */

class Commands extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Barra_Lateral = {Min:true};
        this.Menu_Geral = {Min:false};
        this.Botao_BLE = {Botao : null};
        this.Botao_BLD = {Botao : null};
        
        this.Botao_InfoGerais = {Botao : null};
        this.Maquina = null;
        this.Comandos = null;
        this.Tipo = "command";
        this.Modo = "sync";
        this.TempoResposta = null;
        this.AA = null;
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
        this.DadosEnvio.Tipo = this.Tipo;
        this.DadosEnvio.Modo = this.Modo;
        
        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        
        this.get_InforGeral(TratarResposta.RST_AG);

        return true;
    }

    /**
     * Trata os resultados da busca das informações gerais da máquina selecionada.
     */
    async get_InforGeral(InforGeral){
        let Self = this;

        
        $("#Container1-MenuInforFlash").html(InforGeral).css("display","none");

        $("#Container1-MenuInforFlash").fadeIn("slow");
        
        $("#Barra_InfoContainer").remove();
        
        this.Show_BarraLateral();
        
        $("#BIGmini").click(function(event){
            Self.MinMax_MenuGeral(event);
        });
        
        $(".Bt_INF_G").click(function(e){
            
            if(Self.Botao_BLE.Botao != null){
                let BotaoAtual = Self.Botao_BLE.Botao;
                $("#"+BotaoAtual).removeClass("Active");                
            }

                
             if(Self.Botao_InfoGerais.Botao == null){
                Self.Botao_InfoGerais.Botao = e.currentTarget;
                $(Self.Botao_InfoGerais.Botao).addClass("Active");
            }
            else {
                let BotaoAtual = Self.Botao_InfoGerais.Botao;
                $(Self.Botao_InfoGerais.Botao).removeClass("Active");
                $(e.currentTarget).addClass("Active");
                Self.Botao_InfoGerais.Botao = e.currentTarget;
            }
            
            let idnx = parseInt(Self.Botao_InfoGerais.Botao.dataset.index);
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
                this.Bt_InfoGeral_PlacaMae();
                break;
                
            case 2:
                this.Bt_InfoGeral_SO();
                break;
 
            case 3:
                this.Bt_InfoGeral_Processador();
                break;
                
            case 4:
                this.Bt_InfoGeral_Memoria();
                break;
                
            case 5:
                this.Bt_InfoGeral_Antivirus();
                break;
            
            default:
                
                break;
        }   
    }
     /**
     * Busca informações relativas ao usuário que está logado no sistema no momento.
     * Tipo: 
     */    
   async Bt_InfoGeral_Usuario(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_UsuarioLogado";

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html((TratarResposta.RST_AG).replace(/#/g,"\\"));
        //$("#C_inf_C_Geral_AA").html("Tempo: " + this.TempoResposta[5])
    }
     /**
     * Busca informações relativas à placa mãe do computador onde está o AA.
     * Tipo: 
     */
    async Bt_InfoGeral_PlacaMae(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_PlacaMae";

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html(TratarResposta.RST_AG)

    }
     /**
     * Busca informações relativas Sistem Operacional do computador do AA.
     * Tipo: 
     */    
    async Bt_InfoGeral_SO(){
         if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_SistemaOperacional";

        
        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html(TratarResposta.RST_AG)      
    }
     /**
     * Busca informações relativas ao processador da máquina do AA.
     * Tipo: SVG
     */
    async Bt_InfoGeral_Processador(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_Processador";

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html(TratarResposta.RST_AG);
    }
     /**
     * Busca informações relativas às memórias do computador onde está o AA.
     * Tipo: SVG
     */
    async Bt_InfoGeral_Memoria(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_MemoriasRAM";

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html(TratarResposta.RST_AG);
    }
     /**
     * Busca informações relativas ao Antivírus instalado na máquina do AA.
     * Tipo: SVG
     */
    async Bt_InfoGeral_Antivirus(){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = "get_UsuarioLogado";

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        $("#C_inf_C_Geral_AA").html(TratarResposta.RST_AG);
        //$("#C_inf_C_Geral_AA").html("Tempo: " + this.TempoResposta[5])
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
     * Busca informações relativas ao processador da máquina do AA.
     * Tipo: SVG
     */
    async Bt_PowershellRemoto(Command){
        
        if(this.Maquina == null){
            throw "O nome da máquina não foi definido!";
        }
        
        this.DadosEnvio.AA_CORAC = this.Maquina;
        this.DadosEnvio.Command = Command;

        let TratarResposta = await this.Atualizar();
        this.TempoResposta = TratarResposta.SistemaTempoTotal;
        this.AA = TratarResposta.AA;
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        bootbox.alert(TratarResposta.RST_AG);
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
                                                    <div id='C_Inf_Cab_IPMaquina'>"+ this.AA.IP +"</div>\n\
                                                </div>\n\
                                            </div>\n\
                                            <div id='C_inf_C_Geral_Img'></div>\n\
                                            <div id='C_inf_C_Geral_AA'></div>\n\
                                        </div>\n\
                                        <div id='C_inf_C_Geral_botoesInterv_Container'>\n\
                                            <div id='BarraContainer' class='col-12 d-flex no-block align-items-center' data-original-title='' title=''>\n\
                                                <nav id='Barra_Icones_Interv' class='menu-navigation-claro'></nav>\n\
                                            </div>\n\
                                        </div>\n\                                  </div>\n\
                                </div>\n\
                            </div>");

        $("#Regulador_Info").click(function(event){
            Self.MinMax_Barra_Lateral();
        })
        
        this.addBotoes_BarraLateral();
        this.addBotoes_BarraLateral_Intervencao();
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
            
            if(Self.Botao_InfoGerais.Botao != null){
                let BotaoAtual = Self.Botao_InfoGerais.Botao;
                $(Self.Botao_InfoGerais.Botao).removeClass("Active");
            }
            
            if(Self.Botao_BLE.Botao == null){
                Self.Botao_BLE.Botao = e.currentTarget.id;
                $("#"+Self.Botao_BLE.Botao).addClass("Active");
            }
            else {
                let BotaoAtual = Self.Botao_BLE.Botao;
                $("#"+BotaoAtual).removeClass("Active");
                $(e.currentTarget).addClass("Active");
                Self.Botao_BLE.Botao = e.currentTarget.id;
            }

            let idnx = parseInt(e.currentTarget.dataset.index);
            let IMG = Self.Icones_PNG("BLE", idnx);
            $("#C_inf_C_Geral_Img").html(IMG);
        })
        
        }
        

    }
    /**
     * Cria os botões da caixa lateral de detalhes.
     */
    addBotoes_BarraLateral_Intervencao(){
        let Self = this;
        let Bt = [
                    {
                        "IDX":0, 
                        "Nome":"Logoff", 
                        "Funcao":function(){
                            bootbox.confirm({
                                title: "Logoff",
                                message: "<h4>Tem certeza que deseja executar essa ação?</h4>",
                                className: 'rubberBand animated',
                                buttons: {
                                   cancel: {
                                       label: '<i class="fa fa-times"></i> Não'
                                   },
                                   confirm: {
                                       label: '<i class="fa fa-check"></i> OK'
                                   }
                                    },
                                    callback: function (result) {
                                        if(result){
                                            
                                        }
                                    }
                            });                             
                        }, 
                        "Etiqueta":"Logoff",
                        "Descricao":"Pede para executar logoff na máquina.", 
                        "Active":false},
                    
                    {
                        "IDX":1, "Nome":"Reiniciar", 
                        "Funcao":function(){
                            bootbox.confirm({
                                title: "Reiniciar máquina",
                                message: "<h4>Tem certeza que deseja executar essa ação?</h4>",
                                className: 'rubberBand animated',
                                buttons: {
                                   cancel: {
                                       label: '<i class="fa fa-times"></i> Não'
                                   },
                                   confirm: {
                                       label: '<i class="fa fa-check"></i> OK'
                                   }
                                    },
                                    callback: function (result) {
                                        if(result){
                                            
                                        }
                                    }
                            });                             
                        }, 
                        "Etiqueta":"Reiniciar","Descricao":"Busca informações sobre os discos da máquina.", "Active":false
                    },
                    {
                        "IDX":2, "Nome":"Desligar", 
                        "Funcao":function(){
                            bootbox.confirm({
                                title: "Desligar máquina",
                                message: "<h4>Tem certeza que deseja executar essa ação?</h4>",
                                className: 'rubberBand animated',
                                buttons: {
                                   cancel: {
                                       label: '<i class="fa fa-times"></i> Não'
                                   },
                                   confirm: {
                                       label: '<i class="fa fa-check"></i> OK'
                                   }
                                    },
                                    callback: function (result) {
                                        if(result){
                                            
                                        }
                                    }
                            });                             
                        }, 
                        "Etiqueta":"Desligar","Descricao":"Busca informações sobre os discos da máquina.", "Active":false
                    },
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
        $("#Barra_Icones_Interv").append(_BotaoCompleto);
        if(Bt[i].Funcao != null)
            $("#" + Bt[i].Nome).click(Bt[i].Funcao);
        
        /**
         * Aciona uma funcionalidade que será realizada por todos os botões.
         */
        $("#" + Bt[i].Nome).click(function(e){
            
            if(Self.Botao_InfoGerais.Botao != null){
                let BotaoAtual = Self.Botao_InfoGerais.Botao;
                $(Self.Botao_InfoGerais.Botao).removeClass("Active");
            }
            
            if(Self.Botao_BLD.Botao == null){
                Self.Botao_BLD.Botao = e.currentTarget.id;
                $("#"+Self.Botao_BLD.Botao).addClass("Active");
            }
            else {
                let BotaoAtual = Self.Botao_BLD.Botao;
                $("#"+BotaoAtual).removeClass("Active");
                $(e.currentTarget).addClass("Active");
                Self.Botao_BLD.Botao = e.currentTarget.id;
            }

            let idnx = parseInt(e.currentTarget.dataset.index);
            let IMG = Self.Icones_PNG("BLD", idnx);

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
        var I = []
        I["Error50000"] = '<svg style="width: 33px" aria-hidden="true" focusable="false" data-prefix="fad" data-icon="terminal" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-terminal fa-w-20 fa-7x"><g class="fa-group"><path fill="currentColor" d="M640 421.34v32a24 24 0 0 1-24 24H312a24 24 0 0 1-24-24v-32a24 24 0 0 1 24-24h304a24 24 0 0 1 24 24z" class="fa-secondary"></path><path fill="currentColor" d="M29.7 464.66L7 442a24 24 0 0 1 0-33.9l154-154.76L7 98.6a24 24 0 0 1 0-33.9L29.7 42a24 24 0 0 1 33.94 0L258 236.37a24 24 0 0 1 0 33.94L63.64 464.66a24 24 0 0 1-33.94 0z" class="fa-primary"></path></g></svg>';
        I["Rede"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="network-wired" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-network-wired fa-w-20 fa-7x"><path fill="currentColor" d="M632 240H336v-80h80c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H224c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h80v80H8c-4.42 0-8 3.58-8 8v16c0 4.42 3.58 8 8 8h120v80H64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h320v80h-64c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h160c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32h-64v-80h120c4.42 0 8-3.58 8-8v-16c0-4.42-3.58-8-8-8zM224 384v96H64v-96h160zm0-256V32h192v96H224zm352 256v96H416v-96h160z" class=""></path></svg>';
        I["DiscoRigido"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Processador"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Video"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Mouse"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Audio"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Teclado"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Memoria"] = '<svg  class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="disc-drive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-disc-drive fa-w-16 fa-7x"><path fill="currentColor" d="M256 224a32 32 0 1 0 32 32 32 32 0 0 0-32-32zm248 224h-24V96a64 64 0 0 0-64-64H96a64 64 0 0 0-64 64v352H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h496a8 8 0 0 0 8-8v-16a8 8 0 0 0-8-8zm-56 0H64V96a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32zM256 96a160 160 0 1 0 160 160A160 160 0 0 0 256 96zm0 288a128 128 0 1 1 128-128 128.14 128.14 0 0 1-128 128z" class=""></path></svg>';
        I["Logoff"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-out" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-sign-out fa-w-16 fa-9x"><path fill="currentColor" d="M180 448H96c-53 0-96-43-96-96V160c0-53 43-96 96-96h84c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H96c-17.7 0-32 14.3-32 32v192c0 17.7 14.3 32 32 32h84c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm117.9-303.1l77.6 71.1H184c-13.3 0-24 10.7-24 24v32c0 13.3 10.7 24 24 24h191.5l-77.6 71.1c-10.1 9.2-10.4 25-.8 34.7l21.9 21.9c9.3 9.3 24.5 9.4 33.9.1l152-150.8c9.5-9.4 9.5-24.7 0-34.1L353 88.3c-9.4-9.3-24.5-9.3-33.9.1l-21.9 21.9c-9.7 9.6-9.3 25.4.7 34.6z" class=""></path></svg>';
        I["Reiniciar"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fal" data-icon="repeat-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-repeat-alt fa-w-16 fa-9x"><path fill="currentColor" d="M54.027 327.713C40.129 307.242 32 282.553 32 256c0-70.579 57.421-128 128-128h160v63.969c0 29.239 36.192 43.177 55.785 21.407l72-79.968c10.952-12.169 10.953-30.644 0-42.814l-72-79.974C356.226-11.114 320 2.738 320 32.026V96H160C71.775 96 0 167.775 0 256c0 33.913 10.612 65.391 28.683 91.299 4.427 6.348 13.606 6.936 18.785 1.185l5.488-6.096c3.667-4.073 4.149-10.14 1.071-14.675zM352 32l72 80-72 80V32zm131.317 132.701c-4.427-6.348-13.606-6.936-18.785-1.185l-5.488 6.096c-3.667 4.073-4.149 10.14-1.071 14.675C471.871 204.758 480 229.447 480 256c0 70.579-57.421 128-128 128H192v-63.969c0-29.239-36.192-43.177-55.785-21.407l-72 79.969c-10.952 12.169-10.953 30.644 0 42.814l72 79.974C155.774 523.113 192 509.264 192 479.974V416h160c88.225 0 160-71.775 160-160 0-33.913-10.612-65.391-28.683-91.299zM160 480l-72-80 72-80v160z" class=""></path></svg>';
        I["Desligar"] = '<svg class="icon_inf" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="power-off" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-power-off fa-w-16 fa-9x"><path fill="currentColor" d="M400 54.1c63 45 104 118.6 104 201.9 0 136.8-110.8 247.7-247.5 248C120 504.3 8.2 393 8 256.4 7.9 173.1 48.9 99.3 111.8 54.2c11.7-8.3 28-4.8 35 7.7L162.6 90c5.9 10.5 3.1 23.8-6.6 31-41.5 30.8-68 79.6-68 134.9-.1 92.3 74.5 168.1 168 168.1 91.6 0 168.6-74.2 168-169.1-.3-51.8-24.7-101.8-68.1-134-9.7-7.2-12.4-20.5-6.5-30.9l15.8-28.1c7-12.4 23.2-16.1 34.8-7.8zM296 264V24c0-13.3-10.7-24-24-24h-32c-13.3 0-24 10.7-24 24v240c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24z" class=""></path></svg>';
        
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

