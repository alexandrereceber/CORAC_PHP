/* 
 * Criado: 16/05/2020
 * Autor: Alexandre José da Siva Marques
 */

/**
 * Classe que possibilita acesso ao clientes via broweser para controle remoto. 
 */
class ControleRemoto extends JSController{
    
constructor(Caminho){
        super(Caminho);
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
            
        }else{
            bootbox.alert("<h1 style='color: red; display: inline-flex'><i class='fas fa-user-times'></i></h1> <span style='font-size: 25px; margin-left: 8px'> O usuário negou o acesso remoto!</span>")
        }
        return Configuracoes;
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

