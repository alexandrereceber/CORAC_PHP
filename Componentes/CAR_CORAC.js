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
        this.Componente_Tela_Primary = null;
        
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

        setON_Close(){
            var Configuracoes = this;
            this.ServidorCorac.onclose = function(dados){
                console.log(dados)
                //this.onClose_Dados = dados;
                if(dados.reason == "") {
                    $("#ViewControlRemote").remove();
                    bootbox.alert('<h3><i class="m-r-10 mdi mdi-lan-disconnect" style="font-size: 56px; color: red"></i> A conexão foi encerrada de foram inesperada!</h3>');
                }

                let Resultado = JSON.parse(dados.reason);   
                //this.onError_Dados = dados;
                
                switch (Resultado.Pacote) {
                case 15:
                    
                    break;
                    
                default:
                    $("#ViewControlRemote").remove();
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
                            let Pacote_Config_Inicial = '{\\\"Pacote\\\": 13,\\\"Conteudo\\\":\\\"\\\", \\\"DeviceName\\\": \\\"dd\\\", \\\"Width\\\":99, \\\"Height\\\":90,\\\"Chave_AR\\\": \\\"'+ Configuracoes.Configuracoes.ChaveAR +'\\\"\}'
                            let Pacote_Base = '{"Pacote": 13, "Conteudo":"'+Pacote_Config_Inicial+'", "Remetente": 1}';

                            Configuracoes.ServidorCorac.send(Pacote_Base);                    
                            break;

                        case 14:
                            Configuracoes.RefreshFrame((Resultado.Telas))
                        break;
                        
                        case 8: //Pacote de erro
                            switch (Resultado.Numero) { //Subnotificações
                            case 42001:
                                $("#ViewControlRemote").remove();
                                break;
                                
                            default:
                                
                                break;
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

            this.ServidorCorac.onopen = function(dados){
                console.log(dados)

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
            if(1==1){

                    $("body").append("<div id='ViewControlRemote' class='CViewControlRemote'></div>");
                    $("#ViewControlRemote").html(
                                                    '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/normalize.css" />'+
                                                   ' <link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/demo.css" />'+
                                                    '<link rel="stylesheet" type="text/css" href="./Componentes/RdeskView/css/component.css?q=11" />'+
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
                                                                                                    '<a class="fas fa-plus fai-icon"><span style="margin-left: 18px;font-family: serif;">Downloads</span></a>'+
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
                                                    '<script src="./Componentes/RdeskView/js/gnmenu.js?q=2"></script>'+
                                                    '<script>'+
                                                            'new gnMenu( document.getElementById( "gn-menu" ) );'+
                                                    '</script>'
                    )

                    for(let i in this.Configuracoes.Configuracoes){
                        if(this.Configuracoes.Configuracoes[i].Primary == true){
                            Nome = this.Configuracoes.Configuracoes[i].DeviceName;
                            await this.setDisplayPrimary(Nome);
                        }else{
                            Nome = this.Configuracoes.Configuracoes[i].DeviceName;
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
                        <img  id='"+ DisplayPrimary +"' class='IMG_DisplayPrimary' src='0'></img>\n\
                </div>");
            this.Componente_Tela_Primary = document.querySelector("#"+ DisplayPrimary +"");
  
        }
        
        async setDisplayOther(DisplayOther){
             
            $("#Conteiner-DisplayOther").append("\
                <div id='div_"+ DisplayOther +"' class='div_DisplayOther' \n\
                    style=  ' '> \n\
                        <img id='"+ DisplayOther +"' class='IMG_DisplayOther' src=''></img>\n\
                </div>");
        }
        
       async WEBSOCKET_Close(D){
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

