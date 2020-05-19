/* 
 * Criado: 16/05/2020
 * Autor: Alexandre José da Siva Marques
 */

/**
 * Classe que possibilita acesso ao clientes via broweser para controle remoto. 
 */
class ControleRemoto extends JSController{
    
constructor(Caminho_Config, Caminho_Acesso){
        super(Caminho_Config);
        this.CaminhoAcesso = Caminho_Acesso.replace("{PORTA}",":1199");
        this.Configuracoes = null;
        this.Servidor_AR = null;
        
        this.onClose_Dados = null;
        this.onError_Dados = null;
        this.onMessage_Dados = null;
        this.onOpen_Dados = null;
        
        this.ConfigViewDisplays = {"Primario": 
                                            [   {"Dimensao":{"width": "0px", "heigth": "0px"}}, 
                                                {"Posicao":{"Top": "0px", "Left": "0px"}}
                                            ],
                                  "Other": 
                                            [   {"Dimensao":{"width": "0px", "heigth": "0px"}}, 
                                                {"Posicao":{"Top": "0px", "Left": "0px"}}
                                            ]
                                };
    }
    
    async get_ControlAcessoRemoto(Maquina, Requisicao){
        
        this.DadosEnvio.ServidorCorac = Maquina;
        this.DadosEnvio.Requisicao = Requisicao;

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        
        TratarResposta = JSON.parse(TratarResposta.RST_AG);
        let Configuracoes = TratarResposta = JSON.parse(TratarResposta.Conteudo);
        
        if(Configuracoes.Resposta == "OK_2001"){
            this.Configuracoes = Configuracoes;
            this.setCriarMonitores();
            this.getIniciar_AC();
        }else{
            bootbox.alert("<h1 style='color: red; display: inline-flex'><i class='fas fa-user-times'></i></h1> <span style='font-size: 25px; margin-left: 8px'> O usuário negou o acesso remoto!</span>")
        }
        return true;
    }

        getIniciar_AC(){
            this.ServidorCorac = new WebSocket (this.CaminhoAcesso);
            this.setON_Close();
            this.setON_Error();
            this.setON_Message();
            this.setON_Open();

        }

        setON_Close(){
            this.ServidorCorac.onclose = function(dados){
                console.log(dados)
                this.onClose_Dados = dados;
                bootbox.alert('<h3><i class="m-r-10 mdi mdi-lan-disconnect" style="font-size: 56px; color: red"></i> A conexão foi encerrada de foram inesperada!</h3>')
            } 
        }
        setON_Error(){
            this.ServidorCorac.onerror = function(dados){
                console.log(dados)
                this.onError_Dados = dados;
            }  
        }

        setON_Message(){

            var Configuracoes = this;
            
            this.ServidorCorac.onmessage = function(dados){
                console.log(dados)
                this.onMessage_Dados = dados;
                let Resultado = JSON.parse(dados.data);   
                
                Resultado = JSON.parse(Resultado.Conteudo);
                
                if(Resultado.Error != false){
                    Configuracoes.TratarErros(Resultado);
                    return false;
                }
                let Pacote_Config_Inicial = '{\\\"Pacote\\\": 13,\\\"Conteudo\\\":\\\"\\\", \\\"DeviceName\\\": \\\"dd\\\", \\\"Width\\\":99, \\\"Height\\\":90,\\\"Chave_AR\\\": \\\"'+ Configuracoes.Configuracoes.ChaveAR +'\\\"\}'
                let Pacote_Base = '{"Pacote": 13, "Conteudo":"'+Pacote_Config_Inicial+'", "Remetente": 1}';

                Configuracoes.ServidorCorac.send(Pacote_Base);
            }
        }

        setON_Open(){

            this.ServidorCorac.onopen = function(dados){
                console.log(dados)

            }
              
        }
        setCriarMonitores(){
            var Tipo = typeof this.Configuracoes;
//Tipo === "object" && this.Configuracoes !== null
        if(1==1){

                $("body").append("<div id='ViewControlRemote' class='CViewControlRemote'></div>");
                $("#ViewControlRemote").html(
                                                '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/normalize.css" />'+
                                               ' <link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/demo.css" />'+
                                                '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/component.css?q=1" />'+
                                                '<script src="./Componentes/RdeskView/js/modernizr.custom.js"></script>'+
                                                '<div class="container-RdeskView">'+
                                                '<div class="container-RdeskView-BarraMenu">'+
                                                    '<ul id="gn-menu" class="gn-menu-main">'+
                                                        '<li class="gn-trigger">'+
                                                                '<a class="gn-icon-menu"><i class="mdi mdi-monitor-multiple " style="font-size:18px; cursor: pointer" title="" ></i></a>'+
                                                                '<nav class="gn-menu-wrapper">'+
                                                                        '<div class="gn-scroller">'+
                                                                                '<ul class="gn-menu">'+
                                                                                        '<li>'+
                                                                                                '<a class="gn-icon gn-icon-download">Downloads</a>'+
                                                                                                '<ul class="gn-submenu">'+
                                                                                                        '<li><a class="gn-icon gn-icon-illustrator">Vector Illustrations</a></li>'+
                                                                                                        '<li><a class="gn-icon gn-icon-photoshop">Photoshop files</a></li>'+
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
                                                        '<li><a href="http://tympanus.net/codrops">Codrops</a></li>'+
                                                        '<li><a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/HeaderEffects/"><span>Previous Demo</span></a></li>'+
                                                        '<li><i class="mdi mdi-eye-off" title="Desconectar" style="font-size:18px; cursor: pointer; margin-left: 15px; margin-right: 15px" title="" onclick="AR_CORAC.WEBSOCKET_Close(false)"></i></li>'+
                                                    '</ul>'+
                                                '</div>'+
                                                '<div class="container-RdeskView-Conteudo"></div>'+
                                                '</div>'+
                                                '<script src="./Componentes/RdeskView/js/classie.js"></script>'+
                                                '<script src="./Componentes/RdeskView/js/gnmenu.js"></script>'+
                                                '<script>'+
                                                        'new gnMenu( document.getElementById( "gn-menu" ) );'+
                                                '</script>'
                )
        
                $("html").css("overflow","hidden");
                
            }else{
                this.WEBSOCKET_Close(true);
            }
        

        }
        
        WEBSOCKET_Close(D){
            if(D === true){
                this.Servidor_AR.close();
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
                            Sair.Servidor_AR.close();
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

