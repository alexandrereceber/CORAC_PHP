
var Padrao = function(){
    var Operacao= {readyState: 0}; //Armazena o status da operação de XMLRequest. Verifica se o sistema já esta realizando outra tarefa.
    return{
        addload: function(Recipente, Descricao){
            var Scroll = window.scrollY,
                Description = Descricao || "";
                
                $(Recipente).append('<center><div \n\
                                        class="" \n\
                                        id="myLoader" \n\
                                        style="z-index: 9999;top:'+ Scroll +'px;background-color: #efeef2b3;text-align: -webkit-center;position: absolute;left: 0px;width: 100%;height: 100%;"><div style="display: table-cell;vertical-align: middle;height: 50vw;"> \n\
                                        <div style="height: 40vw;display: table-cell;vertical-align: middle;">\n\
                                            <figure><img src="http://'+ this.getHostServer() +'/CORAC/Imagens/loads/loaders.gif" style="width: 50%;"><figcaption>'+ Description +'</figcaption></figure>\n\
                                        </div>\n\
                                    </div></center>\n\
                                </div>').addClass("modal-open");
            $(".fecharAjax").unbind();
            $(".fecharAjax").click(function(){
                Operacao.abort();
            });
            
        },
        removeLoad: function(){
            $("#myLoader").remove();
            $("body").removeClass('modal-open');
            
        },
        
        setAjax: function(obj){
            Operacao = obj;
        },
        getAjax: function(){
            return Operacao.readyState;
        },
        getHostServer: function(){
            return "177.106.114.165"
        }
    }
}()
class JSController{
    constructor(Caminho){
        /**
         * Armazena os campos e dados que serão enviados para o servidor.
         */
        this.DadosEnvio = {};
        /**
         * Endereço do servidor
         */
        this.URL = Caminho;
        /**
         * Método de envio de dados.
         */
        this.TypeEnvio = "POST";
        /**
         * //Tipo de conteúdo geral. Essa variável poderá ser configurada nas outras classes
         */
        this.TipoConteudo = "application/x-www-form-urlencoded"; 
        this.ProcessarDados = true; //Configuração do ajax.
        
        this.ResultSet = {}
        /**
         * Variável de uso geral e local, seus dados não são enviado para o servidor. 
         * O campo Load é utilizado para configurar se o ícone load será exibido e várias outras configurações,
         * vindas de outras classes.
         * Background: sync - Significa que o carregamento será protegido por uma tela e bloqueia qualquer outra função ajax.
         * Background async - sisnifica que o carregamento não serão precedido de uma tela e não haverá bloqueio de outra funções ajax.
         */
        this.Config = {Load: true, Background: false};

        /**
         * Verifica a existência de uma chave secreta. É um prototype
         */
        this.DadosEnvio.enviarChaves = this.Chaves();

    }
    
    set TipoEnvio(type){
        this.TypeEnvio = type;
    }
    
    BuscarDados(F, E){
        /**
         * Objeto do javascript que representa uma função assíncrona para buscar dados no servidor.
         * por ser promisse as funções async com await é esperado por seus términos.
         * @param function resolve
         * @param function errors
         * @returns {undefined}
         */
        return new Promise((resolve, errors) => 
        {
            if(this.Config.Background == false){
                if(Padrao.getAjax() == 1 ){
                    bootbox.alert("Já existe outro processo em andamento. Favor aguarde...");
                    return false;
                };
                this.Config.Load = true;
            }else{
                this.Config.Load = false;
            }

            var op = $.ajax({
                        cache: false,
                        url: this.URL,
                        type: this.TypeEnvio,
                        async: true,
                        enctype: "multipart/form-data",
                        contentType: this.TipoConteudo,
                        processData: this.ProcessarDados,
                        Config: this.Config,
                        beforeSend: function(Antes){
                            if(this.Config.Load == true)
                                Padrao.addload("body", "Aguarde...");
                        },
                        complete: function(Completo){ //Método é chamado automaticamento pelo objeto ajax.
                            if(this.Config.Load == true)
                                Padrao.removeLoad();
                        },
                        data: this.DadosEnvio,
                        success: function(Resultado, status, xhr){
                            resolve(F(Resultado, status, xhr));
                        },
                        error: function(xhr,status,error){
                            errors(E(xhr, status, error));
                        },
                        xhr: function() {
                            let ConfigInfo = this.Config
                                var myXhr = $.ajaxSettings.xhr();
                                if(myXhr.upload){
                                    myXhr.upload.onprogress = function(e){
                                        let perct = parseInt((e.loaded / e.total) * 100);
                                        $(ConfigInfo.Componente).css("width", perct + "%");
                                    }
                                }
                                return myXhr;
        }
            });
            Padrao.setAjax(op);
        });
    }
    
    async Atualizar(){
       var Dados = await this.BuscarDados(
            function(s, status, xhr){
                var Saida = [];
                Saida[0] = s;
                Saida[1] = status;
                Saida[2] = xhr;
                return Saida;
            }, 
            function(xhr,status, e){
                var Saida = [];
                Saida[0] = e;
                Saida[1] = status;
                Saida[2] = xhr;            
                bootbox.alert("<h4 style='color: red'>Status: "+ status +" - Connection.</h4>")
                return Saida;
            });
        try {
            var ResultadoDados = JSON.parse(Dados[0]);

            if(ResultadoDados.Error != false){
                return ResultadoDados;
            }else{
                if(ResultadoDados.Modo == "S")
                    this.ResultSet = ResultadoDados;
                return ResultadoDados; //Retorna para todas as operaÃ§Ãµes se ocorreram erros, caso tenha acontecido
                                         //a instruÃ§Ã£o que chamou e esta esperando podera ter acesso aos dados do eros
                                         //pela variÃ¡vel glocal this.ResultSet
            }
        } catch (e) {
            bootbox.alert("<h3 style='color: red'><i class='fas fa-exchange-alt'/> Ocorreu algum erro no servidor! Favor contatar o administrador.</h3>")
            console.log(e, Dados[0]);
        }
    
    }
    
    show(){
        
    }
}
JSController.prototype.Chaves = function(){
    try {
        return Chave;
    } catch (e) {
        return null;
    }

}