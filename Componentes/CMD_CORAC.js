/* 
 * Date: 09/05/2020
 * Autor: Alexandre josé da silva marques
 */

class Commands extends JSController{
    constructor(Caminho){
        super(Caminho);
    }

    async getCommand(Comando){
        this.DadosEnvio.Command = Comando;

        let TratarResposta = await this.Atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        
        return TratarResposta;
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

