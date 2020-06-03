/* 
 * Criado: 16/05/2020
 * Autor: Alexandre José da Siva Marques
 */

/**
 * Classe que possibilita acesso ao clientes via broweser para controle remoto. 
 */
class ControleRemoto extends JSController{
    
constructor(Caminho_Config){
        super(Caminho_Config);
        //this.CaminhoAcesso = Caminho_Acesso.replace("{PORTA}",":1199");
        this.Configuracoes = null;
        this.Servidor_AR = null;

        this.onClose_Dados = null;
        this.onError_Dados = null;
        this.onMessage_Dados = null;
        //this.Confirmacao = true;
        /*Mantém as informações sobre a abertura do socketweb e a tramissão dos dados*/
        this.onOpen_Dados = {};
        
        this.Pacote_Base = {"Pacote": 0, "Conteudo": null, "Remetente": 2};

        this.Pacote_Mouse = {
                    Pacote: 18,
                    altKey:false,
                    bubbles:false,
                    button:0,
                    buttons :0,
                    cancelBubble :false,
                    cancelable :false,
                    clientX :0,
                    clientY :0,
                    composed :false,
                    ctrlKey :false,
                    defaultPrevented: false, 
                    detail :0,
                    eventPhase:0, 
                    isTrusted :false,
                    layerX :0,
                    layerY :0,
                    metaKey : false,
                    movementX :0,
                    movementY :0,
                    offsetX :0,
                    offsetY :0,
                    pageX :0,
                    pageY :0,
                    screenX :0,
                    screenY :0,
                    shiftKey :false,
                    type:"",
                    x :0,
                    y:0
        }
        
        this.Pacote_Teclado = {
                                Pacote: 16,
                                altKey: false, 
                                bubbles: false, 
                                cancelBubble: false, 
                                cancelable: false, 
                                charCode:0, 
                                code: "", 
                                composed: false, 
                                ctrlKey: false, 
                                defaultPrevented: false, 
                                detail: 0, 
                                eventPhase: 0, 
                                isComposing: false, 
                                isTrusted: false, 
                                key: "", 
                                keyCode: 0, 
                                metaKey: false, 
                                repeat: false, 
                                returnValue: false, 
                                shiftKey: false 
                            };
                            
        this.Componente_Tela_Primary = null; //Obtém a instancia do objeto DOM do img que receberá as imagem do monitor primário.
        /*Armazena as configurações dos monitores virtuais no cliente*/
        this.ConfigViewDisplays = {"Primario": 
                                            [   {"Dimensao":{"width": "100px", "heigth": "100px"}}, 
                                                {"Posicao":{"Top": "50px", "Left": "50px"}}
                                            ],
                                  "Other": 
                                            [   {"Dimensao":{"width": "50px", "heigth": "50px"}}, 
                                                {"Posicao":{"Top": "100px", "Left": "100px"}}
                                            ]
                                };
    }

    async get_ControlAcessoRemoto(Maquina, Requisicao){
        //let SCORAC = "ws://"+ Maquina +"{PORTA}/CORAC/AcessoRemoto/".replace("{PORTA}", this.PORTA_CORAC);
        this.DadosEnvio.AA_CORAC = Maquina;  //Variável utilizada no php CORAC
        this.DadosEnvio.Requisicao = Requisicao;
        this.DadosEnvio.sendRetorno = "JSON";

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        
        TratarResposta = JSON.parse(TratarResposta.RST_AG);
        let Configuracoes = JSON.parse(TratarResposta.Conteudo);
        
        if(Configuracoes.Resposta == "OK_2001"){
            this.CaminhoAcesso = TratarResposta.AA_ServerCORAC;
            this.Configuracoes = Configuracoes;
            await this.setCriarMonitores();
            await this.getIniciar_AC();
        }else{
            bootbox.alert("<h1 style='color: red; display: inline-flex'><i class='fas fa-user-times'></i></h1> <span style='font-size: 25px; margin-left: 8px'> O usuário negou o acesso remoto!</span>")
        }
        return true;
    }

        async getIniciar_AC(){
            this.ServidorCorac = new WebSocket (this.CaminhoAcesso);
            this.setON_Close();
            this.setON_Error();
            this.setON_Message();
            this.setON_Open();

        }
        
        calcularDeslogamento(ev){
            let naturalHeight, naturalWidth, clientHeight, clientWidth, DfHeight, DfWidth;
            naturalHeight = ev.target.naturalHeight;
            naturalWidth = ev.target.naturalWidth;
            clientHeight = ev.target.clientHeight;
            clientWidth = ev.target.clientWidth;
            
            if(naturalHeight > clientHeight) {
                let Df = (naturalHeight / clientHeight);
                console.log("naturalHeight >= : "+Df);    
                DfHeight = parseInt(ev.offsetY * (Df));
                
            }else if(naturalHeight < clientHeight){
                let Df = (clientHeight / naturalHeight);
                console.log("naturalHeight < : "+Df); 
                DfHeight = parseInt(ev.offsetY / Df);
                
            }else{
                DfHeight = ev.offsetY;
            }
            
            if(naturalWidth > clientWidth) {
                let Df = (naturalWidth / clientWidth);
                console.log("naturalHeight >= : "+Df);    
                DfWidth = parseInt(ev.offsetX * Df);

            } else if(naturalWidth < clientWidth){
                let Df = (clientWidth / naturalWidth);
                console.log("naturalHeight < : "+Df);    
                DfWidth = parseInt(ev.offsetX / Df);
                
            }else{
                DfWidth = ev.offsetX;
            }
            
            return {D_y: DfHeight, D_x: DfWidth};
            
        }
        _onDesabilitarEnvioTeclas(){
            window.onkeydown = null;
            window.onmousemove = null;
        }
        _onHabilitarEnvioMouse(ev){
            //if(!this.Confirmacao) return false;
            //this.Confirmacao = false;
            let Normalizar_Escala = this.calcularDeslogamento(ev);

            this.Pacote_Mouse.Pacote = 18,
            this.Pacote_Mouse.altKey = ev.altKey;
            this.Pacote_Mouse.bubbles = ev.bubbles;
            this.Pacote_Mouse.button = ev.button;
            this.Pacote_Mouse.buttons = ev.buttons;
            this.Pacote_Mouse.cancelBubble = ev.cancelBubble;
            this.Pacote_Mouse.cancelable = ev.cancelable;
            this.Pacote_Mouse.clientX = ev.clientX;
            this.Pacote_Mouse.clientY = ev.clientY;
            this.Pacote_Mouse.composed = ev.composed;
            this.Pacote_Mouse.ctrlKey = ev.ctrlKey;
            this.Pacote_Mouse.defaultPrevented = ev.defaultPrevented; 
            this.Pacote_Mouse.detail = ev.detail;
            this.Pacote_Mouse.eventPhase = ev.eventPhase; 
            this.Pacote_Mouse.isTrusted = ev.isTrusted;
            this.Pacote_Mouse.layerX = ev.layerX;
            this.Pacote_Mouse.layerY = ev.layerY;
            this.Pacote_Mouse.metaKey = ev.metaKey;
            this.Pacote_Mouse.movementX = ev.movementX;
            this.Pacote_Mouse.movementY = ev.movementY;
            this.Pacote_Mouse.offsetX = Normalizar_Escala.D_x;
            this.Pacote_Mouse.offsetY = Normalizar_Escala.D_y;
            this.Pacote_Mouse.pageX = ev.pageX;
            this.Pacote_Mouse.pageY = ev.pageY;
            this.Pacote_Mouse.screenX = ev.screenX;
            this.Pacote_Mouse.screenY = ev.screenY;
            this.Pacote_Mouse.shiftKey = ev.shiftKey;
            this.Pacote_Mouse.type= ev.type;
            this.Pacote_Mouse.x = ev.x;
            this.Pacote_Mouse.y = ev.y;

            console.log(this.Pacote_Mouse)
            console.log(ev)
            console.log(Normalizar_Escala)

            this.Pacote_Base.Pacote = 18;
            this.Pacote_Base.Conteudo = JSON.stringify(this.Pacote_Mouse);
            this.enviarPacotes(this.Pacote_Base);
                
        }
        _onHabilitarEnvioTeclas(){
           var Componente = this;
           /*Eventos relativos ao teclado.*/
            window.onkeydown = function(eventos){
                eventos.preventDefault();
                Componente.Pacote_Teclado.altKey = eventos.altKey;
                Componente.Pacote_Teclado.bubbles = eventos.bubbles;
                Componente.Pacote_Teclado.cancelBubble = eventos.cancelBubble;
                Componente.Pacote_Teclado.cancelable = eventos.cancelable;
                Componente.Pacote_Teclado.charCode = eventos.charCode;
                Componente.Pacote_Teclado.code = eventos.code;
                Componente.Pacote_Teclado.composed = eventos.composed;
                Componente.Pacote_Teclado.ctrlKey = eventos.ctrlKey;
                Componente.Pacote_Teclado.defaultPrevented = eventos.defaultPrevented;
                Componente.Pacote_Teclado.detail = eventos.detail;
                Componente.Pacote_Teclado.eventPhase = eventos.eventPhase;
                Componente.Pacote_Teclado.isComposing = eventos.isComposing;
                Componente.Pacote_Teclado.isTrusted = eventos.isTrusted;
                Componente.Pacote_Teclado.key = eventos.key;
                Componente.Pacote_Teclado.keyCode = eventos.keyCode;
                Componente.Pacote_Teclado.metaKey = eventos.metaKey;
                Componente.Pacote_Teclado.repeat = eventos.repeat;
                Componente.Pacote_Teclado.returnValue = eventos.returnValue;
                Componente.Pacote_Teclado.shiftKey = eventos.shiftKey;
                
               
                Componente.Pacote_Base.Pacote = 16;
                Componente.Pacote_Base.Conteudo = JSON.stringify(Componente.Pacote_Teclado);
                Componente.enviarPacotes(Componente.Pacote_Base);
                
            }
        }
        
        get_Displays(){
            return this.Configuracoes.Displays;
        }
        
        setON_Close(){
            var Configuracoes = this;
            this.ServidorCorac.onclose = function(dados){
                console.log(dados)
                //this.onClose_Dados = dados;
                if(dados.reason == "") {
                    $("#ViewControlRemote").remove();
                    $("html").css("overflow","visible");
                    bootbox.alert('<h3><i class="m-r-10 mdi mdi-lan-disconnect" style="font-size: 56px; color: red"></i> A conexão foi encerrada de foram inesperada!</h3>');
                }

                let Resultado = JSON.parse(dados.reason);   
                //this.onError_Dados = dados;
                
                switch (Resultado.Pacote) {
                case 15:
                    
                    break;
                    
                default:
                    $("#ViewControlRemote").remove();
                    $("html").css("overflow","visible");
                    bootbox.alert('<h3><i class="m-r-10 mdi mdi-lan-disconnect" style="font-size: 56px; color: red"></i> A conexão foi encerrada de foram inesperada!</h3>')

                    break;
                }
            } 
        }
        setON_Error(){
            this.ServidorCorac.onerror = function(dados){
                //console.log(dados);
                let Resultado = JSON.parse(dados.data);   
                //this.onError_Dados = dados;
                
                switch (Resultado.Pacote) {
                case 15:
                    
                    break;
                    
                default:
                    
                    break;
                }
            }  
        }
        enviarPacotes(Pacote){
            this.ServidorCorac.send(JSON.stringify(Pacote))
        }
        
        setON_Message(){
            
            var Configuracoes = this;
            
            this.ServidorCorac.onmessage = function(dados){
                
                try{
                    //console.log(dados)
                    //this.onMessage_Dados = dados;
                    let Resultado = JSON.parse(dados.data);   

                    Resultado = JSON.parse(Resultado.Conteudo);



                    switch (Resultado.Pacote) {
                        case 13:
                            let Pacote_Config_Inicial = {"Pacote": 13,"Conteudo":"", "DeviceName": "dd", "Width":99, "Height":90,"Chave_AR": Configuracoes.Configuracoes.ChaveAR}
                            Configuracoes.Pacote_Base.Pacote = 13;
                            Configuracoes.Pacote_Base.Conteudo = JSON.stringify(Pacote_Config_Inicial);

                            Configuracoes.enviarPacotes(Configuracoes.Pacote_Base);                    
                            break;

                        case 14:
                            Configuracoes.RefreshFrame((Resultado.Telas));
                        break;
                        
                        //case 19:
                        //    Configuracoes.Confirmacao = true;
                       // break;
                        
                        case 8: //Pacote de erro
                            if(Resultado.Error){
                                Configuracoes.TratarErros(Resultado);
                                $("#ViewControlRemote").remove();
                                $("html").css("overflow","visible");

                                return false;
                            }

                        break;
                    default:

                        break;
                    }
                    
                    if(Resultado.Error != false){
                        Configuracoes.TratarErros(Resultado);
                        return false;
                    }
                    
                }catch(err){
                    bootbox.alert("<h3><i class='fas fa-exclamation-triangle'>" + err.message + "</h3>");
                    Configuracoes.WEBSOCKET_Close(true);
                }
                

            }
        }

        setON_Open(){
            var Canal = this;
            this.ServidorCorac.onopen = function(dados){
                //console.log(dados)
                Canal.onOpen_Dados.Open = true;
                window.onbeforeunload = function (event) {
                    return true;
                };
            }
              
        }
        
        RefreshFrame(Telas){
            var TP = false;
            for(var i in Telas){
                TP = Telas[i].Primary || false;
                if(TP){
                    this.Componente_Tela_Primary.src = "data:image/png;base64," + Telas[i].Primary;
                }else{
                    document.querySelector("#"+Telas[i].Monitor).src="data:image/png;base64," + Telas[i].ThumbnailImage;
                }
            }
        }
        
        async setCriarMonitores(){
            var Tipo = typeof this.Configuracoes, Nome = "";
            //Tipo === "object" && this.Configuracoes !== null
            if(Tipo === "object" && this.Configuracoes !== null){

                    $("body").append("<div id='ViewControlRemote' class='CViewControlRemote'></div>");
                    $("#ViewControlRemote").html(
                                                    '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/normalize.css" />'+
                                                   ' <link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/demo.css" />'+
                                                    '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/component.css?q=13" />'+
                                                    '<script src="./Componentes/RdeskView/js/modernizr.custom.js"></script>'+
                                                    '<div class="container-RdeskView">'+
                                                    '<div class="container-RdeskView-BarraMenu">'+
                                                        '<ul id="gn-menu" class="gn-menu-main">'+
                                                            '<li class="gn-trigger">'+
                                                                    '<a class="gn-icon-menu"><i class="mdi mdi-monitor-multiple " style="font-size:18px; cursor: pointer" title="" ></i></a>'+
                                                                    '<nav class="gn-menu-wrapper MenuRDeskView">'+
                                                                            '<div class="gn-scroller">'+
                                                                                    '<ul class="gn-menu">'+
                                                                                            '<li>'+
                                                                                                    '<a class="fas fa-plus fai-icon"><span style="margin-left: 18px;font-family: serif;">Dimensionamento</span></a>'+
                                                                                                    '<ul class="gn-submenu">'+
                                                                                                            '<li><a id="Area_de_Trabalho" class="fas fa-expand fai-icon submenu-final"><span style="margin-left: 18px;font-family: serif;">Área de Trabalho</span></a></li>'+
                                                                                                            '<li><a id="Area_Total"  class="fas fa-desktop fai-icon submenu-final"><span style="margin-left: 18px;font-family: serif;">Real</span></a></li>'+
                                                                                                    '</ul>'+
                                                                                            '</li>'+
                                                                                            '<li><a class="gn-icon gn-icon-cog">Settings</a></li>'+
                                                                                            '<li><a class="gn-icon gn-icon-help">Help</a></li>'+
                                                                                            '<li>'+
                                                                                                    '<a class="gn-icon gn-icon-archive">Archives</a>'+
                                                                                                    '<ul class="gn-submenu">'+
                                                                                                            '<li><a class="gn-icon gn-icon-article">Articles</a></li>'+
                                                                                                            '<li><a class="gn-icon gn-icon-pictures">Images</a></li>'+
                                                                                                            '<li><a class="gn-icon gn-icon-videos">Videos</a></li>'+
                                                                                                    '</ul>'+
                                                                                                '</li>'+
                                                                                    '</ul>'+
                                                                            '</div><!-- /gn-scroller -->'+
                                                                    '</nav>'+
                                                            '</li>'+
                                                            '<li><a id="teste" href="http://tympanus.net/codrops">Codrops</a></li>'+
                                                            '<li><a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/HeaderEffects/"><span>Previous Demo</span></a></li>'+
                                                            '<li><i class="mdi mdi-eye-off" title="Desconectar" style="font-size:18px; cursor: pointer; margin-left: 15px; margin-right: 15px" title="" onclick="AR_CORAC.WEBSOCKET_Close(false)"></i></li>'+
                                                        '</ul>'+
                                                    '</div>'+
                                                    '<div id="id_ViewDisplays_BA">'+
                                                        '<div id="id_container-RdeskView-Primario" class="container-RdeskView-Primario"></div>'+
                                                        '<div id="id_Barra_Acessoria">'+
                                                            '<div class="Table-Barra_A">'+
                                                                '<div id="Conteiner-Chat"></div>'+
                                                                '<div id="Conteiner-DisplayOther"></div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div >'+
                                                    '</div>'+
                                                    '<script src="./Componentes/RdeskView/js/classie.js"></script>'+
                                                    '<script src="./Componentes/RdeskView/js/gnmenu.js?q=6"></script>'+
                                                    '<script>'+
                                                            'new gnMenu( document.getElementById( "gn-menu" ) );'+
                                                    '</script>'
                    )

                    for(let i in this.Configuracoes.Displays){
                        if(this.Configuracoes.Displays[i].Primary == true){
                            Nome = this.Configuracoes.Displays[i].DeviceName;
                            await this.setDisplayPrimary(Nome);
                        }else{
                            Nome = this.Configuracoes.Displays[i].DeviceName;
                            await this.setDisplayOther(Nome);
                        }
                    }

                    $("html").css("overflow","hidden");

                }else{
                    await this.WEBSOCKET_Close(true);
                }

        }
        
        async setDisplayPrimary(DisplayPrimary){
            
            $("#id_container-RdeskView-Primario").append("\
                <div id='div_"+ DisplayPrimary +"' class='div_DisplayPrimary'> \n\
                        <img  id='"+ DisplayPrimary +"' class='IMG_DisplayPrimary' src='http://"+ Padrao.getHostServer() +"/CORAC/Imagens/loads/loaders.gif'></img>\n\
                </div>");
            this.Componente_Tela_Primary = document.querySelector("#"+ DisplayPrimary +"");
            this.DisplayTela = document.querySelector(".div_DisplayPrimary");
            var self = this;
            let count = 0;

            this.Componente_Tela_Primary.onmouseenter = function(ev){
                self._onHabilitarEnvioTeclas();

            }
            this.Componente_Tela_Primary.onmouseout = function(ev){
                self._onDesabilitarEnvioTeclas();
                $("#teste").html(count);
                count++;
            }
            this.Componente_Tela_Primary.onclick = function(ev){
                ev.preventDefault();
                ev.stopPropagation();
                self._onHabilitarEnvioMouse(ev);
            }
            this.Componente_Tela_Primary.ondrag = function(ev){
                ev.preventDefault();
                ev.stopPropagation();
                self._onHabilitarEnvioMouse(ev);

            }
            this.Componente_Tela_Primary.ondragstart = function(ev){
                ev.preventDefault();
                self._onHabilitarEnvioMouse(ev);
                
            }
            this.Componente_Tela_Primary.onmousemove = function(ev){
                self._onHabilitarEnvioMouse(ev);
                ev.preventDefault();
            }
            
            this.Componente_Tela_Primary.ondragstop = function(ev){
                //ev.preventDefault();
                self._onHabilitarEnvioMouse(ev);
                
            }
            this.Componente_Tela_Primary.oncontextmenu = function(ev){
                ev.preventDefault();
                self._onHabilitarEnvioMouse(ev);
                
            }
            
        }
        
        async setDisplayOther(DisplayOther){
             
            $("#Conteiner-DisplayOther").append("\
                <div id='div_"+ DisplayOther +"' class='div_DisplayOther' \n\
                    style=  ' '> \n\
                        <img id='"+ DisplayOther +"' class='IMG_DisplayOther' src='http://"+ Padrao.getHostServer() +"/CORAC/Imagens/loads/loaders.gif'></img>\n\
                </div>");
        }
        
       async WEBSOCKET_Close(D){
           window.onbeforeunload = null;
            if(D === true){
                this.ServidorCorac.close();
            }else{
                var Sair = this;
                bootbox.confirm({
                    title: "Desconectar acesso remoto",
                    message: "<h3>Tem certeza que deseja executar essa operação?</h3>",
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Não'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Sim'
                        }
                    },
                    callback: function(result){
                        if(result){
                            $("#ViewControlRemote").remove();
                            $("html").css("overflow","visible");

                            Sair.ServidorCorac.close();
                        }
                    }
                })
            }
            
        }
    /**
     * 
     * @param {array} Erros
     * @returns {void}
     */
    TratarErros(Erros){

        switch(Erros.Numero){
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

