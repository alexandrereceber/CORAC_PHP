/**
 * Criado: 03/10/2018
 * Modificado: 
 * 
 * Arrays definidos CGeral[15] - Pesquisa gerada pelo campo localizar da tabela
 */
class postView extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Recipiente = null; //Nome do recipiente que receberá o componente com os dados.
        this.NomeInstancia = null; //Nome do objeto instanciado na memória.
        this.ChavesPrimarias = []; //Array que armazena, de uma determinada instância, as chaves primárias de uma tabela HTML
        this.FrameWork = "bootstrap"; //Informa com qual framework o componente mostrará os dados.
        this.DadosEnvio.sendPagina = 1;
        this.DadosEnvio.sendFiltros = [false, false, false];

        /*
         * Ao ser chamada, a função recebe esses paramentros.
         * InstanciaTabela.FuncoesIcones[v.Func](InstanciaTabela, this);
         */
        this.FuncoesIcones = []; //Armazena as funções, criadas manualmente, para a execução dos ícones dos cards, a função recebe os parâmetros Instância da tabela e o próprio objeto 
        this.FuncoesChvExt = []; //Armazena as funções para as chaves extrangeiras. São identificadas pelo numero da função. Esse número vem do ModeloTabela.php que fica no campo.
        this.StatusGeral = [];   //Amazena informações gerais como por exemplo se ja foi buscado os dados no banco. É a variável de estado do objeto.
        
        this.GeralTableClass = "table ",
        this.GeralDivClass = "",
        this.GeralThClass = "",
        this.GeralTdClass = "",
        this.GeralTrClass = "",
        this.GeralLiClass = "page-item",
        this.GeralAClass = "page-link",
        this.GeralUClass = "pagination",
        this.GeralButtonClass = "btn btn-primary",

        this.PageModel = {Inicial: 0, Final: 0};
        this.PostCards = {
                            Config: {
                                        Imagem: false,           //Exibe ou oculta a visualização da imagem que representa o post
                                        ShowImage: false ,
                                        Titulo: true,           //Título do post visivel ou não
                                        Autor: true ,           //Autor do post visibel ou não
                                        Descricao: true,        //Descrição do post visível ou não funciona junto com o campo botoes se tirar a descrição botoes terá que ficar.
                                        Botoes: false,          //Botões personalidado visible ou não
                                        Paginacao: true        //Haverá ou não paginação
                                    },
                               Card:{
                                        Imagem: {
                                                    width: "400px", 
                                                    height: "50px",
                                                    cursor: "pointer"
                                                },
                                        Titulo: {
                                                    fonteFamily: "cursive", 
                                                    color: "blue"
                                                },
                                        Auto: {
                                                    fonteFamily: "cursive", 
                                                    color: "green"
                                                },
                                        Descricao: {
                                                        fonteFamily: "cursive", 
                                                        color: "red",
                                                        Align: "center"
                                                    },
                                        Over: {
                                                hoverColor: "#28a799", 
                                                hoverColorLetras: "green"
                                            }
                                    },
                            Post:   {
                                        width: '100%', 
                                        height:'auto', 
                                        minheight: '0px'
                                    }, 
                            Campos: {
                                        Imagem: 1/*Realiza a indexão do índice do campo com a Imagem*/, 
                                        Titulo: 2/*Realiza a indexão do índice com o campo Título da tabela*/, 
                                        Autor:  3/*Realiza a indexão do Auto com o campo Autor da tabela*/,
                                        Descricao: 4/*Realiza a indexão da Descricao com o campo Descricao da tabela*/
                                    }
                        }
                /**
         * Variável que armazena as funções anônimas das linhas, células e conteúdo.
         * Obs.: Conteudo é a variável que armazena a função anônima que é executada durante a apresentação da tabela HTML. Está
         * variável esta na função .getLinhas();
         */
        this.Funcoes = {
                            Linhas: false
                        };


        var Instancia = this;
        /**
         * 
         */
        this.FAnonimas = {
            Linha: function(Linha){
                Instancia.Funcoes.Linhas(Instancia, Linha);
            }
        }
    }

   /**
    * Atribui um array contendo os filtros de pesquisa.
    * @type array Fts
    */
    set Filtros(Fts){
        this.DadosEnvio.sendFiltros[0] = (Fts);
    }
    /**
     * Nome da instância que armazenará as informações da tabela HTML
     * @type string
     */
    set Name(Nome){
       this.NomeInstancia = Nome;
    }
    /**
     * Nome do objeto HTML que receberá a tabela HTML
     * @type string
     */
    set setRecipiente(recp){
        this.Recipiente = recp;
    }
    
    set setTabela(T){
        this.DadosEnvio.sendTabelas = T;
    }
    
    getValorChave(Linha){
        var CHValores = "", Count = 0, Total = 0;
        
        if(Array.isArray(Linha)){
            Total = this.ResultSet.ChavesPrimarias.length;
            
            for(var ind in Linha){
                if(Total == Count) break;
                
                for(var idx in this.ResultSet.ChavesPrimarias){
                    
                    if(ind == this.ResultSet.ChavesPrimarias[idx]){
                        CHValores += this.ResultSet.ChavesPrimarias[idx] + "@" + Linha[ind] + ";";
                        Count++;
                        break;
                    }
                    
                }
            }
        }
        return CHValores;
    }
   
   
    setOrdemBy(o, BotaoChamador){
        var Campo = o.dataset.idn, OrBy = BotaoChamador.dataset.tipoordemby, Clss = this.ResultSet.OrdemBy;
        this.DadosEnvio.sendOrdemBY = [Campo, OrBy]
        this.show();
    }
    
    getCampoExistFiltro(F,V){
        var Filtros = F, Valor = [];
        for(var i in Filtros){
            if(Filtros[i][0] == V){
                Valor[0] = true;
                Valor[1] = i;
                Valor[2] = Filtros[i][2];
                return Valor;
            }
        }
        
        return Valor[0] = false;
    }
    /**
     * Atualiza os arrays já existentes ou não.
     * @param {type} obj
     * @returns {Boolean}
     */
    async setGerarFiltrosCampo(obj){
        if(event.keyCode == 13){
            var Valor = obj.value, getIndex = obj.dataset.idn, CGeral = this.DadosEnvio.sendFiltros[2], Exist = false, Count = 0;
            if(Valor == "") return false;

            
            if(CGeral != false){
                Exist = this.getCampoExistFiltro(CGeral, getIndex);
                if(Exist[0] == true){
                    Count = Exist[1];
                }else{
                    Count = CGeral.length;
                    CGeral.push([Count]);
                }
            }else{
                CGeral = [];
                CGeral.push([]);
            }
            CGeral[Count][0] = getIndex;
            CGeral[Count][1] = "like";
            CGeral[Count][2] = Valor;
            CGeral[Count][3] = 1;
                 
            
            this.DadosEnvio.sendFiltros[2] = CGeral;
            var Atualizar = await this.Atualizar();
            var Mostrar   = await this.show();
        }        
    }
    
    getBotoes(){
        var Bt = "", GetBotoes = this.ResultSet;

        if(GetBotoes.Botoes["0"].Inserir){
            Bt += "<td><center><button data-chaveprimaria='{{ChavePrimaria}}' id='ButtonInserir_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"'  onclick='"+ this.NomeInstancia + ".showFormularioInserir(this)'>Inserir</button></center></td>";
        }
        if(GetBotoes.Botoes["1"].Editar){
            Bt += "<td><center><button data-chaveprimaria='{{ChavePrimaria}}'  id='ButtonEditar_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"' onclick='"+ this.NomeInstancia + ".showFormularioAtualizar(this)' >Editar</button></center></td>";
        }
        if(GetBotoes.Botoes["2"].Delete){
            Bt += "<td><center><button data-chaveprimaria='{{ChavePrimaria}}'  id='ButtonExcluir_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"' onclick='"+ this.NomeInstancia + ".JanelaExcluirDados(this)' >Excluir</button></center></td>";
        }
        
        Bt = "<table class='"+ this.GeralTableClass +"' ><tr class='"+ this.GeralTrClass +"' >"+ Bt +"</tr></table>";
        
        return Bt;
    }
    /**
     * 
     * @param {type} obj
     * @returns {Boolean}
     */
    async setGerarFiltroBusca(obj){
        this.DadosEnvio.sendFiltros[1] = false
        if(event.keyCode == 13 || event.type == "click"){
            var Valor = obj.value, getResultado = this.ResultSet.Campos, CGeral = [], Count = 0;
            if(Valor == "") return false;

            for(var i in getResultado){
                //var t = this.getCampoExistFiltro(CGeral, i);
                CGeral.push([i]);
                CGeral[i][0] = getResultado[i][0];
                CGeral[i][1] = "like";
                CGeral[i][2] = Valor;
                CGeral[i][3] = 2;
                 
            }
            
            this.DadosEnvio.sendFiltros[1] = CGeral;
            var Atualizar = await this.Atualizar();
            var Mostrar   = await this.show();
            //this.DadosEnvio.sendFiltros[1] = []
        }
    }
    
    async setRemoverFiltros(L){
        this.DadosEnvio.sendFiltros[L] = false;
        await this.Atualizar();
        await this.show();
    }
    
    getInfoPaginacao(){
        var InfPag      = this.ResultSet.InfoPaginacao, 
            Tabela      = "", 
            FindAll     = "",
            TH          = null,
            Refresh     = "";
    
        if(InfPag.ModoPaginacao.Simples){
            TH = "<tr><th colspan=4>"+ InfPag.TotalLinhas + " Registro(s) - "+ InfPag.TotaldePaginas + " Página(s)</th></tr>";
        }else{
            var Inicio = 1, Fim = 0;
            Inicio = InfPag.Deslocamento + 1;
            Fim = InfPag.Deslocamento + this.ResultSet.ResultDados.length
            
            TH = "<tr><th colspan=4>Página atual: <i class='fa fa-file-text-o'></i> "+ InfPag.PaginaAtual +"/"+ InfPag.TotaldePaginas  +"  <br>Registro: "+ Inicio +" até "+ Fim +"</th></tr><tr><th>"+ InfPag.TotalLinhas + " Total registro(s) - "+ InfPag.TotaldePaginas + " Página(s)</th></tr>";
        }

        if(InfPag.ModoPaginacao.BRefresh){
            Refresh ='<td><div style="text-align: center"><button type="button" class="btn btn-primary" onclick="'+ this.NomeInstancia +'.Refresh()"><i class="fa fa-refresh" style="font-size:18px;"></i></button></div></td>';
        }
        
        /**
         * Verifica se a tabelaHTML irá exibir a caixa de salto de página
         */
        if(InfPag.ModoPaginacao.Filtros){
            var getFilter = this.ResultSet.Filtros[1], BFlt = ""
            if(getFilter != "false"){
                BFlt = '<button \n\
                                                id="FiltroPequisa" \n\
                                                type="button" \n\
                                                class="btn btn-danger" \n\
                                                data-toggle="tooltip" \n\
                                                data-placement="top" \n\
                                                title="Remove filtro de pesquisa" \n\
                                                onclick="'+ this.NomeInstancia +'.setRemoverFiltros(1)">\n\
                                                    <i \n\
                                                        class="fa fa-filter" \n\
                                                        style="font-size:18px">\n\
                                                    </i>\n\
                                            </button><script>$("#FiltroPequisa").tooltip()</script>'
            }
            if(this.FrameWork == "bootstrap"){
                FindAll =   "\n\
                                <td>"+
                                    "<form onsubmit='event.preventDefault()' style='display:  inline-flex;width: 100%; margin: 0px'><div class='input-group'>" +
                                        '<div class="input-group-prepend">' +
                                            '<span class="input-group-text">Filtro:</span>' +
                                        '</div>' +
                                        '<input id="INPUT_'+ this.ResultSet.Indexador +'" onkeyup="'+ this.NomeInstancia +'.setGerarFiltroBusca(this)" type="text" class="form-control" placeholder="" name="Filter">' +
                                        '</div> \n\
                                        <div style="margin: 0px;width: 11%;">\n\
                                            <button \n\
                                                type="button" \n\
                                                class="btn btn-primary" \n\
                                                onclick="'+ this.NomeInstancia +'.setGerarFiltroBusca(INPUT_'+ this.ResultSet.Indexador +')">\n\
                                                    <i \n\
                                                        class="fa fa-search" \n\
                                                        style="font-size:18px">\n\
                                                    </i>\n\
                                            </button> '+
                                            BFlt +
                                        "</div>" +
                                    "</form>";
            }if(this.FrameWork == "getmdl.io"){
                
            }

            
        }
        Tabela = "<table class='"+ this.GeralTableClass +"' style='margin-bottom:0px'>"+
                                    "<tr>"+
                                        (InfPag.TituloTabela != false ? "<th colspan='4' style='text-align: center'>"+ InfPag.TituloTabela +"</th>" : "")+
                                    "</tr>"+ TH + "<tr>"+ FindAll + Refresh +"</tr>"+
                                "</table>";        
        
        return Tabela;
    }
    
    setSaltoPagina(obj){
        if(event.keyCode == 13){
            var Valor = obj.value;
            if(Valor >=1 && Valor <= this.ResultSet.InfoPaginacao.TotaldePaginas)
            this.setIrPagina(Valor);
            
        }
    }
    
    getPaginacao(){
        var CabHTML = "",
        GetResultado    = this.ResultSet,
        Indexador       = GetResultado.Indexador,
        PgAtual         = GetResultado.InfoPaginacao.PaginaAtual,
        PgTotalVisible  = GetResultado.InfoPaginacao.TotalPaginaVisivel,
        PaginacaoTotal = GetResultado.InfoPaginacao.TotaldePaginas,
        Active          = "",
        PBotao        = "",
        UBotao          = "",
        NextPagina      = "",
        RetroPagina     = "",
        FuncNext        = "",
        FuncUltima      = "",
        FuncRetro       = "",
        FuncPrimeira    = "",
        PrimeiraPagina  = "",
        UltimaPagina    = "",
        SaltoPagina     = "";
        
        if(GetResultado.ResultDados.length == 0) return "";
        if(PaginacaoTotal == 1 || PaginacaoTotal == 0) return "";
        
        if(PgAtual == 1){
            this.PageModel.Inicial = 1;
            this.PageModel.Final   = PgTotalVisible < PaginacaoTotal ? PgTotalVisible : PaginacaoTotal;
            
        }else if(PgAtual > 1 && PgAtual > this.PageModel.Final && PgAtual <= PaginacaoTotal){
            this.PageModel.Inicial = parseInt(PgAtual);
            this.PageModel.Final = (parseInt(PgAtual) + parseInt(PgTotalVisible)) > PaginacaoTotal ? PaginacaoTotal : (parseInt(PgAtual) + parseInt(PgTotalVisible));
            
        }else if(PgAtual > 1 && PgAtual < this.PageModel.Inicial && PgAtual > 1){
            this.PageModel.Inicial = (parseInt(PgAtual) - parseInt(PgTotalVisible)) > 1 ? (parseInt(PgAtual) - parseInt(PgTotalVisible)) : 1;
            this.PageModel.Final = parseInt(PgAtual);
        }else{
            
        }
        
        for(var indx = this.PageModel.Inicial; indx <= this.PageModel.Final; indx++){
            
            if(indx == PgAtual){
                Active = " active ";
            }else{
                Active = "";
            }
            
            CabHTML += "\
                            <li class='"+ this.GeralLiClass + Active +"' onclick='"+ this.NomeInstancia + ".setIrPagina("+ (parseInt(indx)) +")'>\n\
                                <a class='"+ this.GeralAClass +  "' href='javascript:void(0)'>"+ indx +"</a>\n\
                            </li>" ;
        }
        
        if(PgAtual != PaginacaoTotal){
            FuncNext = this.NomeInstancia + ".setIrPagina("+ (parseInt(PgAtual) + 1) +")";
            FuncUltima = this.NomeInstancia + ".setIrPagina("+ (parseInt(PaginacaoTotal)) +")";;
            UBotao = "";
        }else UBotao = " disabled ";

        if(PgAtual != 1){
            FuncRetro = this.NomeInstancia + ".setIrPagina("+ (parseInt(PgAtual) - 1) +")";
            FuncPrimeira = this.NomeInstancia + ".setIrPagina(1)";;
            PBotao = "";
        }else PBotao = " disabled ";
        /*
         * Avança para a próxima página.
         */
        NextPagina = "<li class='"+ this.GeralLiClass + UBotao +" ' onclick='"+ FuncNext +"'>\n\
                    <a class='"+ this.GeralAClass +  "' href='javascript:void(0)'><i class='fa fa-chevron-right' style='font: normal normal normal 17px/1 FontAwesome;/* font-size: initial; */'></i></a>\n\
                </li>";
        /**
         * Volta uma página
         */
        RetroPagina = "<li class='"+ this.GeralLiClass + PBotao +"' onclick='"+ FuncRetro +"'>\n\
            <a class='"+ this.GeralAClass +  "' href='javascript:void(0)'><i class='fa fa-chevron-left'  style='font: normal normal normal 17px/1 FontAwesome;/* font-size: initial; */'></i></a>\n\
        </li>";
        
        /**
         * Leva para a primeira página.
         */
        PrimeiraPagina = "<li class='"+ this.GeralLiClass + PBotao +"' onclick='"+ FuncPrimeira +"'>\n\
            <a class='"+ this.GeralAClass +  "' href='javascript:void(0)'><i class='fa fa-fast-backward'  style='font: normal normal normal 17px/1 FontAwesome;/* font-size: initial; */'></i></a>\n\
        </li>";

        /**
        * Leva para a última página.
        */
        UltimaPagina = "<li class='"+ this.GeralLiClass + UBotao +"' onclick='"+ FuncUltima +"'>\n\
            <a class='"+ this.GeralAClass +  "' href='javascript:void(0)'><i class='fa fa-fast-forward'  style='font: normal normal normal 17px/1 FontAwesome;/* font-size: initial; */'></i></a>\n\
        </li>";
        
        /**
         * Verifica se a tabelaHTML irá exibir a caixa de salto de página
         */
        if(GetResultado.InfoPaginacao.ModoPaginacao.SaltoPagina){
            SaltoPagina = "<div style='display: inline-block; margin-left: 5px'><input onkeyup='"+ this.NomeInstancia +".setSaltoPagina(this)' class='form-control' id='FomControl_"+ GetResultado.Indexador + "' type='number' min=1 max="+ PaginacaoTotal +"><div>";
        }

        /**
         * Monta todos os botões relativos à paginação.
         */
        CabHTML = "<center><div  class=' "+ this.GeralDivClass +" ' id='Rodape" + Indexador + "' style='display: inline-block;'>    \n\
                    <ul class='"+ this.GeralUClass + "'>"+ PrimeiraPagina + RetroPagina + CabHTML + NextPagina + UltimaPagina +"</ul>                   \n\
                </div>"+SaltoPagina+"</center>";
        
        return CabHTML;
    }
    
    setIrPagina(p){
        this.DadosEnvio.sendPagina = p;
        this.show();
    }
    /**
     * Quebra as chaves em modo texto para modo array
     * @param {string} Chp
     * @returns {Array|TabelaHTML.getBreakChaves.ChavesArray}
     */
    getBreakChaves(Chp){
        var Quebrar = Chp.substring(0, Chp.length - 1), ChavesArray = [], temp = null;
        Quebrar = Quebrar.split(";");
        for(var i in Quebrar){
            temp = Quebrar[i].split("@");
            ChavesArray.push(temp);
        }
        return ChavesArray;
    }
    /**
     * var y = v.getBreakChaves("0@36;1@337;")
       v.getObterLinhaInteira(y);
     * Busca, através do array de chaves, a linha correspondente à chave primaria e a retorna.
     * @param {string} Chaves
     * @returns {unresolved}
     */
    getObterLinhaInteira(Chaves){
        var Valores = this.ResultSet.ResultDados, vChp1 , vChp2, Fins = false;
        for(var i in Valores){
            for(var idx in Chaves){
                vChp1 = Valores[i][Chaves[idx][0]]; //Busca direto pela chave, sem ficar vasculhando cada campo
                vChp2 = Chaves[idx][1];
                if(vChp1 != vChp2){
                    Fins = false
                    break;
                }else{
                    Fins = true;
                    break;
                }
            }
            if(Fins == true) return Valores[i];
        }
    }
    /**
     * Retorna o valor do campo, representado pelo parâmetro indxCampos, de uma determinada chave primária.
     * @param {array} Chaves
     * @param {int} indxCampos Representa o campo através do index
     * @returns {string} O conteúdo de um campo de uma chave primária
     */
    getFindValor(Chaves, indxCampos){
        var Valores = this.ResultSet.ResultDados, vChp1 , vChp2, Fins = false;
        for(var i in Valores){
            for(var idx in Chaves){
                vChp1 = Valores[i][Chaves[idx][0]]; //Busca direto pela chave, sem ficar vasculhando cada campo
                vChp2 = Chaves[idx][1];
                if(vChp1 != vChp2){
                    Fins = false
                    break;
                }else{
                    Fins = true;
                    break;
                }
            }
            if(Fins == true) return Valores[i][indxCampos];
        }
    }
    
   
    /**
     * Obtém o valor de um campo. Método utilizado para preencher o campo de um formulário.
     * @param {int} indxCampo
     * @returns {String}
     */
    getObterValorCampos(indxCampo){
        var Chps = []
        if(this.ChavesPrimarias.length > 0){
            Chps = this.getBreakChaves(this.ChavesPrimarias[0]);
            return this.getFindValor(Chps, indxCampo);
        }else{
            
        }
    }
    /**
     t.FuncoesChvExt[0] = function(v,p){
            var Dados = new JSController("http://10.56.32.78:8080/CORAC/Controlador/");
    
        }   * 
     * Função que é chamada quando no mapeamento de campos em php é especificado o campo como chave estrangeira e a opção func tem o numero da função que será chamada quando for executada. Antes de aparecer a tela.
     * @param {int} NF
     * @returns {TabelaHTML@arr;@call;FuncoesChvExt}
     */
    async setFExecuteChv(NF){
       return await this.FuncoesChvExt[NF](this, NF);
    }
    /**
     * Cria um campo especial para as chaves extrangeiras.
     * @param {array} Campo
     * @returns {undefined}
     */
    async getCamposChaveExtrangeira(Campo, Valor){
        var 
            Template = "", 
            Label = "", 
            FNome = "", 
            Tipo = "",
            Leitura = "",
            Botao = "",
            Func = "";
                
    Label           = Campo[1];
    FNome           = Campo[8].Name;
    Tipo            = Campo[8].TypeConteudo;
    Leitura         = Campo[8].readonly == true ? "readonly" : "";
    Botao           = Campo[19].NomeBotao;
    Func            = Campo[19].Funcao;
    
    if(this.FrameWork == "bootstrap"){
        if(Campo[8].TypeComponente == "button"){

                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<input type="'+ Tipo +'" '+ Leitura +' class="form-control" name="'+ FNome +'" value="'+ Valor +'"><button type="button" onclick="'+ this.NomeInstancia +'.setFExecuteChv(this,'+ Func +')" class="btn btn-primary Bt_ChvExt_'+ this.ResultSet.Indexador +'">'+ Botao +'</button>' +
                                '</div>';
                return Template;
        }   
            
        if(Campo[8].TypeComponente == "select"){
                
                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<select class="form-control"  name="'+ FNome +'" >'+ await this.setFExecuteChv(Func) +'</select>' +
                                '</div>';
                return Template;
            }  
    }
                    
                    
    }
    /**
     * Cria um formulário com os campos que podem ser enviado.
     * @param {array} Campo Representa o conjunto de atributos de uma campo para formulários.
     * @param {string} Modo
     * @returns {String}
     */
    async getGrupoCamposFramework(Campo, Modo){
        var 
            Template = "", 
            Valor = "", 
            Label = "", 
            Placeholder = "", 
            FNome = "", 
            Tipo = "", 
            Required = "", 
            Title = "", 
            Patterns = "",
            Formenctype = "",
            Leitura = "",
            Opcoes = "";
        
        if(Modo == "Atualizar" && !Campo[19].TExt){
            Valor = this.getObterValorCampos(Campo[0]);
        }
        //Chave extrangeira.
        if(Campo[19].TExt){
            Valor = Modo == "Atualizar" ? this.getObterValorCampos(Campo[19].IdxCampoVinculado) : ""; //IdxCampoVinculado -> Vem do banco de dados e é o vínculo entre a chave extrangeira
            return await this.getCamposChaveExtrangeira(Campo, Valor);
        }
        
        if(this.FrameWork == "bootstrap"){
            
           
            if(Campo[8].TypeComponente == "inputbox"){
                Label           = Campo[1];
                Placeholder     = Campo[8].Placeholder;
                FNome           = Campo[8].Name;
                Tipo            = Campo[8].TypeConteudo[0];
                Required        = Campo[8].Required;
                Title           = Campo[8].Titles;
                Patterns        = Campo[8].Patterns;
                Leitura         = Campo[8].readonly == true ? "readonly" : "";
                Formenctype     = Campo[8].formenctype == "" ? "" : "formenctype='"+ Campo[8].formenctype + "'";
                
                if(Campo[2].Exist && Modo != "Atualizar"){
                    Valor = Campo[2].Valor;
                }
                
                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<input type="'+ Tipo +'" '+ Required +' title="'+ Title +'"  '+ Patterns +' class="form-control" '+ Leitura +' placeholder="'+ Placeholder +'" name="'+ FNome +'" value="'+ Valor +'">' +
                                '</div>';
                return Template;
            }
            
            if(Campo[8].TypeComponente == "select"){
                Label           = Campo[1];
                FNome           = Campo[8].Name;
                Tipo            = Campo[8].TypeConteudo;
                
                Tipo.forEach(function(v,i,p){
                    var S = v == Valor ? "selected" : "";
                    Opcoes += "<option "+ S +" >"+ v +"</option>";
                })
                
                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<select class="form-control"  name="'+ FNome +'">'+ Opcoes +'</select>' +
                                '</div>';
                return Template;
            }           
            
        

            
        }else if(this.FrameWork == "getcmdl.io"){
            
        }
        
        return Template;
    }
    /**
     * 
     * @param {array} Erros
     * @returns {void}
     */
    TratarErros(Erros){
        bootbox.alert("<h3>"+ Erros[2] +"</h3>")
    }
//####################MÓDULO INSERIR###########################    

    /**
     * Envia em forma de array os campos e seus valores para armazenamento no banco de dados.
     * @param {objeto} F
     * @returns {Boolean}
     */
    async EnviarFormularioInserir(F){
        var TratarResposta = "";
        
        event.preventDefault();
        var Campos = [];
        Campos = $(F).serializeArray();
        this.DadosEnvio.sendCamposAndValores = Campos;
        TratarResposta = await this.inserir();

        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta, "Inserir");
            return false;
        }else{
            F.reset();
        }
        
        await this.show();
    }
    /**
     * Obtém os campos que comporão o formulário para envio dos dados.
     * @returns {String}
     */
    async getCamposInserir(){
        var Campos = "", GetResultado = this.ResultSet;
        
        for(var indx in GetResultado.Campos){
            if(GetResultado.Campos[indx][8].Exibir !== true) continue; 
            Campos += await this.getGrupoCamposFramework(GetResultado.Campos[indx], "Inserir");
        }
        Campos = "<form onsubmit='"+ this.NomeInstancia +".EnviarFormularioInserir(this)'>"+ Campos+ "<button class='btn btn-primary btn-block'>Inserir</button></form>"
        return Campos;
    }
    /**
     * Obtém as informações para a criação da janela inserir dados.
     * @returns {void}
     */
    async showFormularioInserir(){
        var FormsCampos = await this.getCamposInserir();
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-lg", Tamanho: "30vw"},
                                    Header: {Title: "Inserir", CorTexto: "white", backgroundcolor: "#007bff"}, 
                                    Body: {Conteudo: FormsCampos}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", classe: "" , Visible: "block", Funcao: function(){}}
                                            }
                                };
            this.CustomJanelaModal(Janela);        
    }
    /**
     * Método assíncrono que envia os dados para inserção.
     * @returns {TabelaHTML@call;Atualizar}
     */
    async inserir(){
        this.DadosEnvio.sendModoOperacao = "5a59ffc82a16fc2b17daa935c1aed3e9";
        return await this.Atualizar();
    }
    
//####################FIM MÓDULO INSERIR###########################    
//
//####################MÓDULO ATUALIZAR###########################    
    async EnviarFormularioEditar(F){
        var TratarResposta = "";
        
        event.preventDefault();
        var Campos = [];
        Campos = $(F).serializeArray();
        this.DadosEnvio.sendCamposAndValores = Campos;
        this.DadosEnvio.sendChavesPrimarias = this.getBreakChaves(this.ChavesPrimarias[0]);
        TratarResposta = await this.atualizar();
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }else{
            
            this.ChavesPrimarias.splice(0,1);
            if(this.ChavesPrimarias.length > 0){
                var FormsCampos = await this.getCamposAtualizar();
                $(".modal-body").html(FormsCampos);
            }else{
                $("#ButtonEditar_" + this.ResultSet.Indexador).prop("disabled","true");
                $("#ButtonExcluir_" + this.ResultSet.Indexador).prop("disabled","true");
                
                $("#myJanelas").modal('hide');
        
                await this.show(); //Somente após a atualização de todas as linhas;
            }
        }
    }
    
    async getCamposAtualizar(){
        var Campos = "", GetResultado = this.ResultSet;
        
        for(var indx in GetResultado.Campos){
            if(GetResultado.Campos[indx][8].Exibir !== true) continue; 
            Campos += await this.getGrupoCamposFramework(GetResultado.Campos[indx], "Atualizar");
        }
        Campos = "<form onsubmit='"+ this.NomeInstancia +".EnviarFormularioEditar(this)'>"+ Campos+ "<button class='btn btn-success btn-block'>Atualizar</button></form>"
        return Campos;
    }

    async showFormularioAtualizar(o){
        let Chave = o.dataset.chaveprimaria;
        
        this.ChavesPrimarias = [];
        this.ChavesPrimarias.push(Chave);
        
        let FormsCampos = await this.getCamposAtualizar();
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-lg", Tamanho: false},
                                    Header: {Title: "Editar", CorTexto: "white", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: FormsCampos}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "none", Funcao: function(){var o}}, 
                                                Aceitar: {Nome: "Close", classe: "" , Visible: "block", Funcao: function(){var o}}
                                            }
                                };

        this.CustomJanelaModal(Janela);
    }
    
    /**
     * 
     * @returns {TabelaHTML@call;Atualizar}
     */
    async atualizar(){
        this.DadosEnvio.sendModoOperacao = "1b24931707c03902dad1ae4b42266fd6";
        this.ChavesEnvio = this.getBreakChaves(this.ChavesPrimarias[0]);
        return await this.Atualizar();
    }
//####################FIM MÓDULO EDITAR###########################    
    async showJanela(Janela){
            this.CustomJanelaModal(Janela);        
    }
//################################################################

    getTipoCards(tp){
        switch (tp) {
            case 1:
            return    '<div class="card" style="width: {{widthCard}}; height: {{heightCard}};min-height:{{minheightCard}}; margin: 6px; flex-direction: row">'+
                                  (this.PostCards.Config.Imagem == true ? ('<div style="width: '+ this.PostCards.Card.Imagem.width +'; height: '+ this.PostCards.Card.Imagem.height +'; cursor: '+ this.PostCards.Card.Imagem.cursor +';"><img class="card-img-top'+ (this.PostCards.Config.ShowImage == true ? ' showImage_'+ this.ResultSet.Indexador : "") +'" src="{{cardImagem}}" alt="Card image" style="width:98%; height: 100px;"></div>'): "")+
                                  
                                    ((this.PostCards.Config.Descricao == true || this.PostCards.Config.Botoes == true) ?(
                                        '<div class="card-body" style="text-align: justify" >'+
                                            (this.PostCards.Config.Titulo == true ? '<div><div id="idTituloPost"><h4 class="card-title" style="font-family: '+ this.PostCards.Card.Titulo.fonteFamily +'; color: '+ this.PostCards.Card.Titulo.color +'; ">{{TituloCard}}</h4></div>'+  (this.PostCards.Config.Autor == true ? '<div id="idTituloAutor" style="font-family: '+ this.PostCards.Card.Auto.fonteFamily +'; color: '+ this.PostCards.Card.Auto.color +'; ">{{cardAutor}}</div></div>':"</div>") : "") +
                                            (this.PostCards.Config.Descricao == true ? '<div class="card-text" style="font-family: '+ this.PostCards.Card.Descricao.fonteFamily +'; color: '+ this.PostCards.Card.Descricao.color +'; text-align: '+ this.PostCards.Card.Descricao.Align +';">{{TextoCard}}</div>' : "") +
                                            (this.PostCards.Config.Botoes == true ? '<div id="Botaos_CardPerson">{{BotaosCardPerson}}</div>' : "") +
                                            '{{BotaosCard}}' +
                                  '</div>') : "") +
                            '</div>'  
                            
  
                break;
                
            default:
                
                break;
        }
    }
    
    async gerarIcones(Icon){
        
        if(Array.isArray(Icon)){
            var TdI = "", TipoIcone = "";
            for(var i in Icon){
                TipoIcone = Icon[i].Tipo;
                if(TipoIcone == "Bootstrap"){
                    TdI += "<div style='text-align: center;padding: 9px;display: inline-flex;'><i class='"+ Icon[i].Icone + " "+ Icon[i].NomeBotao + "_"+ this.ResultSet.Indexador + "' style='font-size:18px; cursor: pointer' title='"+ Icon[i].tooltip +"'></i></div>";
                }else if(TipoIcone == "image"){
                    
                }
            }
            return TdI;
        }
    }    
    /**
     * 
     * @returns {Boolean}
     */
    async show(){
        var TratarResposta = null;
        this.DadosEnvio.sendModoOperacao = "ab58b01839a6d92154c615db22ea4b8f";
        TratarResposta = await this.Atualizar();
        
        if(TratarResposta.Error != false){
            this.TratarErros(TratarResposta);
            return false;
        }
        
        var 
            cabecalho = null,
            Linhas = null,
            Card = "",
            allCards = "",
            Indexador = 0,
            NomeTabela = "",
            Botoes = "",
            Paginacao = "",
            InfoP = "",
            InstanciaTabela = this,
            ChavePrimaria = "",
            ShowIcons = "";
        
        Indexador   = this.ResultSet.Indexador;
        NomeTabela  = this.ResultSet.NomeTabela;
        Linhas      = this.ResultSet.ResultDados;
        Botoes      = this.getBotoes();
        Paginacao   = this.PostCards.Config.Paginacao == true ? this.getPaginacao(): "";
        InfoP       = this.getInfoPaginacao();
        this.ChavesPrimarias = []; //Na mudança de página todas as chaves selecionadas são excluídas.
        
        let Container = ''+
                            '<div class="container">'+
                                '<div id="CardsCabecalho"> {{CabecalhoCards}}</div>'+
                                '<div id="CardsBody" style="text-align: center">{{BodyContainer}}</div>'+
                                '<div id="CardsPaginacao">{{PaginacaoCard}}</div>'+
                            '</div><style>.card:hover{background: '+ this.PostCards.Card.Over.hoverColor +'; color: '+ this.PostCards.Card.Over.hoverColorLetras +'}</style> ';
        
        if(this.ResultSet.ShowColumnsIcones[0]){
            ShowIcons = await this.gerarIcones(this.ResultSet.ShowColumnsIcones[1]);
        }
        
        for(var i = 0; i < Linhas.length; i++){
            
            ChavePrimaria = this.getValorChave(Linhas[i]);
            
            /** 
             * Executa um função para cada linha dos cards. Há, existe uma função similar, em php, com essa mesma
             * finalidade. jobs()
             * Php - Servidor
             * Javascript - Client
             */
            if(this.Funcoes.Linhas != false){
                this.FAnonimas.Linha(Linhas[i]);
            }
            
            Card = this.getTipoCards(1);
            let TituloCard = Linhas[i][this.PostCards.Campos.Titulo /*Represenda o index do campo na tabela de cards*/],
                Autor      = Linhas[i][this.PostCards.Campos.Autor /*Represenda o index do campo na tabela de cards*/],
                CardsCorpo = Linhas[i][this.PostCards.Campos.Descricao /*Represenda o index do campo na tabela de cards*/],
                Imagem  = Linhas[i][this.PostCards.Campos.Imagem /*Represenda o index do campo na tabela de cards*/]
                
                Card = this.PostCards.Config.Imagem == true ? Card.replace(/{{cardImagem}}/i, Imagem) : Card;
                Card = this.PostCards.Config.Titulo == true ? Card.replace(/{{TituloCard}}/i, TituloCard) : Card;
                Card = this.PostCards.Config.Autor == true ? Card.replace(/{{cardAutor}}/i, Autor) : Card;
                
                Card = this.PostCards.Config.Descricao == true ? Card.replace(/{{TextoCard}}/i, CardsCorpo) : Card;
                Card = Card.replace(/{{widthCard}}/i, this.PostCards.Post.width);
                Card = Card.replace(/{{heightCard}}/i, this.PostCards.Post.height);
                Card = Card.replace(/{{minheightCard}}/i, this.PostCards.Post.minheight);
                Card = this.PostCards.Config.Botoes == true ? Card.replace(/{{BotaosCardPerson}}/i, ShowIcons) : Card;
                
                if(this.ResultSet.Botoes[0].Inserir || this.ResultSet.Botoes[1].Editar || this.ResultSet.Botoes[2].Delete){
                    let Bt  = Botoes.replace(/{{chaveprimaria}}/i, ChavePrimaria);
                    Card = Card.replace(/{{BotaosCard}}/i, Bt);
                }else{
                    Card = Card.replace(/{{BotaosCard}}/i, "");
                }

                
                allCards += Card;
        }

        Container = Container.replace(/{{CabecalhoCards}}/i, InfoP);
        Container = Container.replace(/{{BodyContainer}}/i, allCards);
        Container = Container.replace(/{{PaginacaoCard}}/i, Paginacao);
        
        $("#" + this.Recipiente).html(Container);
        
        if(this.ResultSet.ShowColumnsIcones[0]){
            this.ResultSet.ShowColumnsIcones[1].forEach(function(v, i, p){
                var o = v
                $("." + v.NomeBotao + "_" + InstanciaTabela.ResultSet.Indexador).click(function(){
                    InstanciaTabela.FuncoesIcones[v.Func](InstanciaTabela, this)
                });
            });
        }
        var idx = ".showImage_" + this.ResultSet.Indexador
        var Apresentar = new ViewImage(idx);
        
        if(this.PostCards.Config.ShowImage)
        $(".showImage_" + this.ResultSet.Indexador).unbind().click(function(e){
            Apresentar.showSlides(e);
        })
    }
    
    /**
     * Atualiza a tabela
     * @returns {void}
     */
    async Refresh(){
        this.show();
    }
    
    async excluir(){
        var Chaves = [], Quebradas = [], TratarResposta = null;
        for (var i in this.ChavesPrimarias) {
            Quebradas.push(this.getBreakChaves(this.ChavesPrimarias[i]));
        }
        this.DadosEnvio.sendModoOperacao = "1570ef32c1a283e79add799228203571";
        this.DadosEnvio.sendChavesPrimarias = Quebradas;
        TratarResposta = await this.Atualizar();
        if(TratarResposta.Error == false){
            this.TratarErros(TratarResposta, "Excluir");
            return false;
        }else{
            this.show();
        }
    }
    /**
     * Exclui as linhas selecionadas na tabela HTML
     * @returns {TabelaHTML@call;Atualizar}
     */
    JanelaExcluirDados(){
        var Mensagem = "<h4>Tem certeza que deseja excluir o(s) registro(s) selecionado(s)?</h4>";//<h4><span class='glyphicon glyphicon-trash'></span> </h4>
        //this.r;
        var o = this;
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-sm", Tamanho: false},
                                    Header: {Title: "<i class='fa fa-trash-o' style='font-size:36px'></i> Excluir", CorTexto: "white", backgroundcolor: "#dc3545"}, 
                                    Body:   {Conteudo: Mensagem}, 
                                    Footer: {
                                                Cancelar: {Nome: "Não", classe: "btn-success" , Color: "white" ,Visible: "block", Funcao: function(){var o}}, 
                                                Aceitar: {Nome: "Excluir", classe: "btn-danger" , Color:"white", Visible: "block", Funcao: function(){o.excluir()}}
                                            }
                                };
            this.CustomJanelaModal(Janela);        

    }
    /**
     * Seta os valores para a criação de uma janela bootstrap.
     * @param {object} o
     * @returns {void}
     */
    CustomJanelaModal(o){
        var Componentes = o; /*{
                                    Janela: {Nome: "myJanelas", Tipo: false, Tamanho: "300px"},
                                    Header: {Title: "Excluir", CorTexto: "", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: Mensagem}, 
                                    Footer: {
                                                Cancelar: {Nome: "nao", Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", Visible: "block", Funcao: function(){}}
                                            }
                                };

                        };*/
        
        if(Componentes.Janela.Tipo != false){
            $(".modal-dialog").removeClass("modal-sm").removeClass("modal-lg");
            $(".modal-dialog").addClass(Componentes.Janela.Tipo);
            $(".modal-dialog").css("width","inherit");
        }

        if(Componentes.Janela.Tamanho  != false){
            $(".modal-dialog").css("width",Componentes.Janela.Tamanho);
            $(".modal-dialog").css("max-width","100%");
        }
        
        $(".modal-header").css("background-color", Componentes.Header.backgroundcolor);
        $(".modal-title").html(Componentes.Header.Title);
        $(".modal-title").css("color", Componentes.Header.CorTexto);
        $(".modal-body").html(Componentes.Body.Conteudo);
        
        $(".cancelar").css("display", Componentes.Footer.Cancelar.Visible);
        $(".cancelar").html(Componentes.Footer.Cancelar.Nome);
        $(".cancelar").unbind();
        $(".cancelar").click(Componentes.Footer.Cancelar.Funcao);
        $(".cancelar").addClass(Componentes.Footer.Cancelar.classe);
        
        $(".ok").css("display", Componentes.Footer.Aceitar.Visible);
        $(".ok").html(Componentes.Footer.Aceitar.Nome);
        $(".ok").unbind();
        $(".ok").click(Componentes.Footer.Aceitar.Funcao);
        $(".ok").addClass(Componentes.Footer.Aceitar.classe);
        
        $("#" + Componentes.Janela.Nome).modal();
        
    }
}

