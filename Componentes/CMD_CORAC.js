/* 
 * Date: 09/05/2020
 * Autor: Alexandre josé da silva marques
 */

class Commands extends JSController{
    constructor(Caminho){
        super(Caminho);
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
        let ArrayUser = (TratarResposta[0].Usuario).split("-");

        
        TratarResposta[0].Usuario = ArrayUser[ArrayUser.length - 1];
        TratarResposta[0].SOCaption = (TratarResposta[0].SOCaption).replace("Windows","");
        TratarResposta[0].Memoria = Number((TratarResposta[0].Memoria) / (1024 * 1024)).toFixed(2) + " GB";
        let Regx = /(i[0-5]|Celerom).*/ig
        
        TratarResposta[0].Processador = Regx.exec(TratarResposta[0].Processador)[0];
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

