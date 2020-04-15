
class ControladorPaginaWEBAtualizar extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.NomeInstancia = null; //Nome do objeto instanciado na memória.
    }
    
    async atualizar(){
        this.DadosEnvio.sendModoOperacao = "1b24931707c03902dad1ae4b42266fd6";//
        this.DadosEnvio.sendTabelas = "9e9524af7942ab2ca5efc37ea3738659";
        
        return await this.Atualizar();
    }
    
    async EnviarFormularioEditar(){
        var Campos = [], CodigoHTMLPWEB = "";

        this.DadosEnvio.sendCamposAndValores = Campos;
        this.DadosEnvio.sendChavesPrimarias = [[0,IDPWEB]];
        $("#FerramentasOnJustTime").remove();
        $("#CxFerramentaWEBDesign").remove();
        
        CodigoHTMLPWEB       = $("#CodigoHTMLPWEB").html();

        this.DadosEnvio.sendCamposAndValores[0] = {name:"CodigoHTML", value: CodigoHTMLPWEB};

       var TratarResposta = await CPaginaWEBAtualizar.atualizar();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
    }    
}

var CPaginaWEBAtualizar = new ControladorPaginaWEBAtualizar("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
