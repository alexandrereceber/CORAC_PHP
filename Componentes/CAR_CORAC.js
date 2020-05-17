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
            //var Config = this.Configuracoes, WEB_SOCKET = this.ServidorCorac;
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

