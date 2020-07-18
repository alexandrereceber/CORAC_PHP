/* 
 * Envia os dados para verificar se o usuário esta ou não cadastrado no sistema.
 */

    
async function EnviarDados(obj){
    event.preventDefault();
    var Campos = $(obj).serializeArray(), 
        sendUsuario = "", 
        sendSenha = "", 
        BtsendContraSenha = "", 
        sendContraSenha = "",
        SiteEnvioDados = "";
    
    sendUsuario       = obj[0].value == "" ? true : false;
    sendSenha         = obj[1].value == "" ? true : false;
    BtsendContraSenha = obj[3].checked     ? true : false;
    if(BtsendContraSenha)
        sendContraSenha = obj[2].value == "" ? true : false;
    
    var snackbarContainer = document.querySelector('#Barra-de-Mensagem');
    var handler = function() {};    
    var data = {
      message: '',
      timeout: 4000,
      actionHandler: handler,
      actionText: 'OK'
    };
        
    if(sendUsuario){
        obj[0].focus();
        data.message = "Usuário necessário."
        snackbarContainer.MaterialSnackbar.showSnackbar(data);        
        return false;
    }
    if(sendSenha){
        obj[1].focus();
        data.message = "senha necessário."
        snackbarContainer.MaterialSnackbar.showSnackbar(data);        
        return false;
    }
    if(BtsendContraSenha){
        if(sendContraSenha){
            obj[2].focus();
            data.message = "Repita a senha novamente!"
            snackbarContainer.MaterialSnackbar.showSnackbar(data);        
            return false;
        }
        if(!(obj[2].value == obj[1].value)){
            obj[2].focus();
            obj[2].value = "";
            
            data.message = "Os 2 campos de senha estão diferentes, a senha deve ser a mesma."
            snackbarContainer.MaterialSnackbar.showSnackbar(data);        
            return false;
        }
        
    }
    sendUsuario = obj[0].value;
    sendSenha   = obj[1].value;
    BtsendContraSenha == true ? (sendContraSenha = obj[2].value) : false;
    
    SiteEnvioDados = BtsendContraSenha == true ? ("/CORAC/Cadastrar/") : ("/CORAC/Validar/");
    
    
    var Dados = new JSController("http://"+ Padrao.getHostServer() + SiteEnvioDados), Result = "";
    Dados.DadosEnvio.sendUsuario    = sendUsuario;
    Dados.DadosEnvio.sendSenha      = sendSenha;
    
    BtsendContraSenha == true ? (Dados.DadosEnvio.sendContraSenha = sendContraSenha) : false;
    
    Dados.DadosEnvio.sendDispositivo = "pc"

    Result = await Dados.Atualizar();   
    if(Result.Error != false){
        switch (Result.Codigo) {
            case 14001:
                Result.Mensagem = "Banco de dados não encontrado. Favor entrar em contato com o administrador."
                break;
                
            case 6005:
                Result.Mensagem = "Usuário definido não possui privilégios nessa tabela para essa operação: Insert"
                break;

            case 8005:
                Result.Mensagem = "Usuário já cadastrado, favor escolha outro nome de usuário!"
                obj[0].focus();
                obj[0].value = "";
                break;

            case 14006:            
            case 14004:

                Result.Mensagem = "<i class='fas fa-user-times' style='color: red; font-size: 30px'/> " + Result.Mensagem + ""
                
                break;

            case 14005:
                break;

            case 14006:
                break;

            case 14004:
                break;

            case 14003:
                Result.Mensagem = "O dispositivo utilidado não é válido para esse sistema."
                break;

            case 15005:
                break;

            case 14007:
                break;

            case 23000:
                Result.Mensagem = "Usuário já existe no sistema."
                break;
                
            default:
                Result.Mensagem = "Error não tratado ou inesperado. Favor entrar em contato com o administrador."
                break;
        }
        
        //$(".mdl-dialog__content").html("<h4>" +  Result.Mensagem + "</h4>");
        //dialog.showModal();
        bootbox.alert({
            message: "<h4>" +  Result.Mensagem + "</h4>",
            className: 'rubberBand animated'
        , callback: function(){location.reload()}});
        
    }else{
        if(Result.Modo == "Login")
            window.location = Result.Header;
        else if(Result.Modo == "Cadastro"){
            bootbox.alert({
                message: "<h4>" +  Result.Mensagem + "</h4>",
                className: 'rubberBand animated'
            });            
            //$(".mdl-dialog__content").html("<h4>Usuário cadastrado com sucesso!.</h4>");
            //dialog.showModal();            
            //$("#android").click();
        }
    }
    
}

function setCadastrar(o){
    if(o.checked){
        $(".Linha_CPassword").css("display","inline-block");
        $(".LoginCadastrar").text("Cadastrar")
    }
    else{
        $(".LoginCadastrar").text("Acessar")
        $(".Linha_CPassword").css("display","none");
    }
}