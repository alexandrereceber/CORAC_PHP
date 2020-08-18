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
                    Screen: "",
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
                    deltaY: 0,
                    deltaX: 0,
                    offset :0,
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
        this.Display_Atual = null;
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
            await this.setCriarChat();
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
    
    deslocamentoScreen(){
        let PosMouseScreen = {Des_ScreenX: 0, Des_ScreenY: 0}
        for(var i in this.Configuracoes.Displays){
            if(this.Display_Atual == this.Configuracoes.Displays[i].DeviceName){
                PosMouseScreen.Des_ScreenX =  this.Configuracoes.Displays[i].X;
                PosMouseScreen.Des_ScreenY =  this.Configuracoes.Displays[i].Y;                
            }
        }
        return PosMouseScreen;
    }
    
    calcularDeslogamento(ev){
        let naturalHeight, naturalWidth, clientHeight, clientWidth, DfHeight, DfWidth;
        naturalHeight = ev.target.naturalHeight;
        naturalWidth = ev.target.naturalWidth;
        clientHeight = ev.target.clientHeight;
        clientWidth = ev.target.clientWidth;

        
        if(naturalHeight > clientHeight) {
            let Df = (naturalHeight / clientHeight);
            //console.log("naturalHeight >= : " + Df);
            DfHeight = parseInt(ev.offsetY * (Df));

        }else if(naturalHeight < clientHeight){
            let Df = (clientHeight / naturalHeight);
            //console.log("naturalHeight < : "+Df); 
            DfHeight = parseInt(ev.offsetY / Df);

        }else{
            DfHeight = ev.offsetY;
        }

        if(naturalWidth > clientWidth) {
            let Df = (naturalWidth / clientWidth);
            //console.log("naturalHeight >= : "+Df);    
            DfWidth = parseInt(ev.offsetX * Df);

        } else if(naturalWidth < clientWidth){
            let Df = (clientWidth / naturalWidth);
            //console.log("naturalHeight < : "+Df);    
            DfWidth = parseInt(ev.offsetX / Df);

        }else{
            DfWidth = ev.offsetX;
        }
        let D_Screen = this.deslocamentoScreen();
        
        let Tela_Deslocamento = {D_y: D_Screen.Des_ScreenY + DfHeight, D_x: D_Screen.Des_ScreenX + DfWidth};
        
        return Tela_Deslocamento;

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
        this.Pacote_Mouse.Screen = ev.target.id;
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

        if(ev.type == "wheel"){
            this.Pacote_Mouse.deltaY = ev.deltaY * -1;
            this.Pacote_Mouse.deltaX = ev.deltaX * -1;
        }

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


                    case 8: //Pacote de erro
                        if(Resultado.Error){
                            Configuracoes.TratarErros(Resultado);
                            switch (Resultado.Numero){
                                case 42002:
                                    
                                    break;
                                    
                                default:
                                    $("#ViewControlRemote").remove();
                                    $("html").css("overflow","visible");                                    
                                    break;
                            }


                            return false;
                        }

                    break;

                    case 20: //Pacote de Close
                        $("#ViewControlRemote").remove();
                        $("html").css("overflow","visible");
                        bootbox.alert("<h3><img style='width:40px; margin-right: 10px' src='http://"+ Padrao.getHostServer() +"/CORAC/Imagens/Chat/User_Close.jpg'/>Usuário finalizou atendimento!</h3>");
                        window.onbeforeunload = null;                    
                    break;

                    case 21: //Pacote chat usuário
                        let Pacote_User = {Nome: Resultado.Nome , Mensagem: Resultado.Mensagem, Hora: Resultado.Hora};
                        Configuracoes.Escrever_Mensagem_Usuario(Pacote_User);
                        return false;
                    break;

                    case 23: //Pacote chat usuário
                        Configuracoes.Usuario_Digitando(Resultado.Digitando);
                        return false;
                    break;

                    case 25: //Pacote Mensagens
                        Configuracoes.InstaladorRemoto(Resultado);
                        return false;
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
    InstaladorRemoto(Pacote){
        switch(Pacote.Tipo){
            case 60000:
                $("#id_container-RdeskView-Primario").append("<img style='positon: absolute; top:0px;right:0px' id='CarregandoInstalador' src='66'/>");
                break;
            case 60001:
                $("#CarregandoInstalador").remove();
                break;        }
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
                try{
                   document.querySelector("#"+Telas[i].Monitor).src = "data:image/png;base64," + Telas[i].Screen;
                }catch(err){
                    
                }
            }else{
                try{
                    document.querySelector("#"+Telas[i].Monitor).src="data:image/png;base64," + Telas[i].Screen;

                }catch(err){
                    
                }
            }
        }
    }

    _onEnviar_MensagemSuporte(Pacote_Suporte){
        this.Pacote_Base.Pacote = 22;
        this.Pacote_Base.Conteudo = JSON.stringify(Pacote_Suporte);
        this.enviarPacotes(this.Pacote_Base);
    }

    Usuario_Digitando(Rst){
        if(Rst == true){
            $("#userDigitando").css("display","inherit");
        }else{
            $("#userDigitando").css("display","none");
        }
    }

    Escrever_Mensagem_Usuario(Pacote_User){

        $(".chat-list").append('<li class="chat-item">'+
                                        '<div class="chat-content">'+
                                            '<h6 class="font-medium">'+ Pacote_User.Nome +'</h6>'+
                                            '<div class="chat-img"><img src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/chat_user.png" alt="Usuário"></div>'+
                                            '<div class="box bg-light-info">'+ Pacote_User.Mensagem +'</div>'+
                                        '</div>'+
                                        '<div class="chat-time">'+ Pacote_User.Hora +'</div>'+
                                    '</li>');
        $(".Painel-Dialog").scrollTop(parseInt($(".chat-list").css("height")));

    }

    Escrever_Mensagem_Suporte(Pacote_Suporte){
        $(".chat-list").append('<li class="odd chat-item">'+
                                        '<div class="chat-content">'+
                                            '<h6 class="font-medium">James Anderson</h6>'+
                                            '<div class="box bg-light-inverse">'+ Pacote_Suporte.Mensagem +'</div>'+
                                            '<br>'+
                                        '</div>'+
                                        '<div class="chat-img chat-Img-Left"><img src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/chat_Suporte.png" alt="user"></div>'+
                                        '<div class="chat-time">'+ Pacote_Suporte.Hora +'</div>'+
                                    '</li>');     
        $(".Painel-Dialog").scrollTop(parseInt($(".chat-list").css("height")));
    }

    async setCriarChat(){
        var Componente = this;
        $("#Conteiner-Chat").html(
            '<div class="row Painel-DialogMensagem">'+
                '<div class="col-12 Painel-Dialog">'+
                    '<div class="card">'+
                        '<div class="card-body">'+
                            '<div class="chat-box scrollable ps-container ps-theme-default ps-active-y" style="" data-ps-id="7646d4ca-ef31-3a6d-ea54-735f422da7e9">'+
                                '<ul class="chat-list">'+
                                //Mensagem Enviada e recebidas
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-12 Painel-Mensagem">'+
                    '<div id="userDigitando" style="display: none">\n\
                        <figure>\n\
                            <img src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/Digitando.gif" style="width:50px"/>\n\
                        <figcaption>Usuário Digitando</figcaption>\n\
                        </figure>\n\
                     </div>'+
                    '<div class="Conteiner-Mensagem"><div class="Conteiner-Input">\n\
                        <input data-Modificate=false id="Caixa_Mensagem" type="text"/>\n\
                    </div>\n\
                    <div class="Container-Button">\n\
                        <img id="Botao_Mensagem" src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/enviarmensagem.png" alt="Enviar" />\n\
                    </div>\n\
                    </div>'+
                '</div>'+
            '</div>');

    $("#Caixa_Mensagem").keydown(function(event){
        if(event.keyCode == 13){
            let Pacote_Suporte = {Pacote: 22, Mensagem: $("#Caixa_Mensagem").val(), Nome: "Suporte", Hora:  (new Date()).toLocaleTimeString().substring(0,4)}
            Componente._onEnviar_MensagemSuporte(Pacote_Suporte);
            Componente.Escrever_Mensagem_Suporte(Pacote_Suporte);
            $(this).val("");
            event.target.dataset.modificate = false;
            //console.log("nao modificado")

        }else if(event.keyCode == 8){
            if(event.target.dataset.modificate == "true" && ($(this).val().length == 1)){
                event.target.dataset.modificate = false;

                let Pacote_ChatDigitando = {Pacote: 23, Digitando: false}
                Componente.Pacote_Base.Pacote = 23;
                Componente.Pacote_Base.Conteudo = JSON.stringify(Pacote_ChatDigitando);
                Componente.enviarPacotes(Componente.Pacote_Base);
            }
        }
    })

    $("#Caixa_Mensagem").keypress(function(event){
        if(event.keyCode == 13) return false;
         if(event.target.dataset.modificate == "false"){
            event.target.dataset.modificate = true;

                let Pacote_ChatDigitando = {Pacote: 23, Digitando: true}
                Componente.Pacote_Base.Pacote = 23;
                Componente.Pacote_Base.Conteudo = JSON.stringify(Pacote_ChatDigitando);
                Componente.enviarPacotes(Componente.Pacote_Base);

         }
    }) 

    $("#Botao_Mensagem").click(function(){
        if($("#Caixa_Mensagem").val() != ""){
            let Pacote_Suporte = {Pacote: 22, Mensagem: $("#Caixa_Mensagem").val(), Nome: "Suporte", Hora:  (new Date()).toLocaleTimeString().substring(0,4)}
            Componente._onEnviar_MensagemSuporte(Pacote_Suporte);
            Componente.Escrever_Mensagem_Suporte(Pacote_Suporte);
            $("#Caixa_Mensagem").val("");                
        }
    })        
    }

    async setCriarMonitores(){
        var Tipo = typeof this.Configuracoes, Nome = "";
        //Tipo === "object" && this.Configuracoes !== null
        if(Tipo === "object" && this.Configuracoes !== null){

                $("body").append("<div id='ViewControlRemote' class='CViewControlRemote'></div>");
                $("#ViewControlRemote").html(
                                                '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/normalize.css" />'+
                                               ' <link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/demo.css" />'+
                                                '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/component.css?q=<?php echo time() ?>" />'+
                                                '<script src="./Componentes/RdeskView/js/modernizr.custom.js"></script>'+
                                                '<div class="container-RdeskView">'+
                                                '<div class="container-RdeskView-BarraMenu">'+
                                                    '<ul id="gn-menu" class="gn-menu-main">'+
                                                        '<li class="gn-trigger">'+
                                                                '<a class="gn-icon-menu"><i class="mdi mdi-monitor-multiple " style="font-size:25px; cursor: pointer; display: flex" title="" ></i></a>'+
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
                                                                                        '<li><a class="gn-icon-menu InstSoft"><i class="mdi mdi-package-variant mid-icon" style="font-size:28px; cursor: pointer;" title="" ></i><span class="mid-legend">Instalar Softwares</span></a></li>'+
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
                                                        '<li><a id="InstallSoftware" class="gn-icon-menu"><i class="mdi mdi-package-variant " style="font-size:31px; cursor: pointer; display: flex" title="Instalar Softwares" ></i></a></li>'+
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

            var Self = this;

            $(".InstSoft").click(function(event){
                Self.showWindows(Self);
            });

            $("#InstallSoftware").click(function(event){
                Self.showWindows();
            });

    }

    async setDisplayPrimary(DisplayPrimary){

        $("#id_container-RdeskView-Primario").append("\
            <div id='div_Primary' class='div_DisplayPrimary'> \n\
                    <img  id='"+ DisplayPrimary +"' class='IMG_DisplayPrimary' src='http://"+ Padrao.getHostServer() +"/CORAC/Imagens/loads/loaders.gif'></img>\n\
            </div>");
                                                            
        this.Display_Atual = DisplayPrimary;
        
        this.Componente_Tela_Primary = document.querySelector("#"+ DisplayPrimary +"");
        this.DisplayTela = document.querySelector(".div_DisplayPrimary");
        var self = this;
        let count = 0;

        this.Componente_Tela_Primary.onmouseenter = function(ev){
            self._onHabilitarEnvioTeclas();

        }
        this.Componente_Tela_Primary.onmouseout = function(ev){
            self._onDesabilitarEnvioTeclas();
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

        this.Componente_Tela_Primary.onwheel = function(ev){
            ev.preventDefault();
            self._onHabilitarEnvioMouse(ev);

        }

    }

    async setDisplayOther(DisplayOther){
        var Self = this;
        $("#Conteiner-DisplayOther").append("\
            <div id='div_"+ DisplayOther +"' class='div_DisplayOther' \n\
                style=  ' '> \n\
                    <img id='"+ DisplayOther +"' class='IMG_DisplayOther' src='http://"+ Padrao.getHostServer() +"/CORAC/Imagens/loads/loaders.gif'></img>\n\
            </div>");

        $("#"+DisplayOther).click(function(event){
           let Primary = document.querySelector(".IMG_DisplayPrimary");
           let SCREEN_P = Primary.id;
           
           let SCREEN_O = this.id;
           
           Primary.id = SCREEN_O;
           this.id = SCREEN_P;
           Self.Display_Atual = SCREEN_O;
        })
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

    _onEnviarCredenciais(Pacote_Credential){
        this.Pacote_Base.Pacote = 24;
        this.Pacote_Base.Conteudo = JSON.stringify(Pacote_Credential);
        this.enviarPacotes(this.Pacote_Base);
    }

    showWindows(){
    var Self = this;
    let FormsCampos = '<div id="Blok_EXEC"> '+
                    '<form id="Validar_Form" action="#">'+
                            '<div class="form-group">'+
                                '<label class="Rotulo_Label">Usuário:</label>'+
                                '<input required id="Usuario" type="text" class="form-control Autenticacao" id="" data-placeholder="">'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label class="Rotulo_Label">Senha:</label>'+
                                '<input required id="Senha"  type="password" class="form-control Autenticacao" id="" data-placeholder="">'+
                            '</div>'+                        
                            '<div class="form-group">'+
                                '<label class="Rotulo_Label">Domínio:</label>'+
                                '<input required id="Dominio"  type="text" class="form-control Autenticacao" id="" data-placeholder="">'+
                            '</div>'+
                    '<form>'+

                        '</div>';

    var Janela = {
                                Janela: {Nome: "myJanelas", Tipo: "modal-lg", Largura: "auto", Altura: "auto"},
                                Header: {Title: "Credenciais", CorTexto: "white", backgroundcolor: "#007bff"}, 
                                Body: {Conteudo: FormsCampos, Scroll: true}, 
                                Footer: {
                                            Cancelar: {Nome: "Cancelar", classe: "" , Visible: "block", Funcao: function(Self){

                                            }}, 
                                            Aceitar: {Nome: "Executar", classe: "" , Visible: "block", Funcao: function(event){
                                                    let Nome = "", Senha = "", Dominio = ""
                                                    Nome = $("#Usuario").val();
                                                    Senha = $("#Senha").val();
                                                    Dominio = $("#Dominio").val();

                                                    if(Nome == ""){
                                                        $("#Usuario").focus();
                                                        $(".status-footer").html("<span style='color: red'> O nome de usuário é obrigatório.</span>")
                                                        return false;
                                                    }else if(Senha == ""){
                                                        $("#Senha").focus();
                                                        $(".status-footer").html("<span style='color: red'> O preenchimento do campo senha é obrigatório.</span>")
                                                        return false;
                                                    }

                                                    let Credenciais = {Pacote: 24, Usuario: Nome, Senha: Senha, Dominio: Dominio};
                                                    Self._onEnviarCredenciais(Credenciais);
                                                   //$("#Validar_Form").submit();
                                            }},
                                            Status: {Display: true, Conteudo: "Credenciais do usuário com privilégios administrativos no computador remoto"}
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
        $(".ok").off("click");
        $(".ok").click(Componentes.Footer.Aceitar.Funcao);
        $(".ok").addClass(Componentes.Footer.Aceitar.classe);

        $("#" + Componentes.Janela.Nome).modal(Componentes.Modal);

    }
    
    /**
     * 
     * @param {array} Erros
     * @returns {void}
     */
    TratarErros(Erros){
        $("#CarregandoInstalador").remove();
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

