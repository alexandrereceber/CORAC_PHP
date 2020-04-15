/**
 * Criado: 03/10/2018
 * Modificado: 
 * 
 * Arrays definidos CGeral[15] - Pesquisa gerada pelo campo localizar da tabela
 */
class PostEdition extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Recipiente = null; //Nome do recipiente que receberá o componente com os dados.
        this.NomeInstancia = null; //Nome do objeto instanciado na memória.
        this.ChavesPrimarias = []; //Array que armazena, de uma determinada instância, as chaves primárias de uma tabela HTML
        this.FrameWork = "bootstrap"; //Informa com qual framework o componente mostrará os dados.
        this.DadosEnvio.sendPagina = 1;
        this.DadosEnvio.sendFiltros = [false, false, false];
        this.CamposEditores = [];
        /**
         * Variável que armazena as funções anônimas das linhas, células e conteúdo.
         * Obs.: Conteudo é a variável que armazena a função anônima que é executada durante a apresentação da tabela HTML. Está
         * variável esta na função .getLinhas();
         */
        this.Funcoes = {
                            Linhas: false, 
                            Celulas: false, 
                            Conteudo: false
                        };

        /*
         * Ao ser chamada, a função recebe esses paramentros.
         * InstanciaTabela.FuncoesIcones[v.Func](InstanciaTabela, this);
         */
        this.FuncoesIcones = []; //Armazena as funções, criadas manualmente, para a execução dos ícones da tabela HTML, a função recebe os parâmetros Instância da tabela e o próprio objeto 
        this.FuncoesChvExt = []; //Armazena as funções para as chaves extrangeiras. São identificadas pelo numero da função. Esse número vem do ModeloTabela.php que fica no campo.
        this.StatusGeral = [];   //Amazena informações gerais como por exemplo se ja foi buscado os dados no banco. É a variável de estado do objeto.
        
        this.GeralTableClass = "table table-hover",
        this.GeralDivClass = "",
        this.GeralThClass = "",
        this.GeralTdClass = "",
        this.GeralTrClass = "",
        this.GeralLiClass = "page-item",
        this.GeralAClass = "page-link",
        this.GeralUClass = "pagination",
        this.GeralButtonClass = "btn btn-primary",
        this.visibleChavePrimaria = false;
        this.PageModel = {Inicial: 0, Final: 0}
        var Instancia = this;
        /**
         * 
         */
        this.FAnonimas = {
            Linha: function(){
                Instancia.Funcoes.Linhas(Instancia, this);
            }, 
            Celulas: function(){
                Instancia.Funcoes.Celulas(Instancia, this);
            }, 
            Conteudo: function(Index, VConteudo){
                return Instancia.Funcoes.Conteudo(Instancia, Index, VConteudo);
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
    setColorirLinha(L, T){
        if(T == 1){
            $(L.parentNode.parentNode).addClass("TabelaHTMLSelect");
        }else{
            $(L.parentNode.parentNode).removeClass("TabelaHTMLSelect");
        }
    }
    
    setSelecionarLinhas(Linha){
        var 
            ChP = Linha.dataset.chaveprimaria,
            Find = this.ChavesPrimarias.indexOf(ChP);
    
        if(Find > -1){
            this.ChavesPrimarias.splice(Find,1);
            this.setColorirLinha(Linha, 0); // 1 - Colorir Linha
        }else{
            this.ChavesPrimarias.push(ChP);
            this.setColorirLinha(Linha, 1); // 1 - Remover cor Linha
        }
        if(this.ChavesPrimarias.length > 0){
            $("#ButtonEditar_" + this.ResultSet.Indexador).removeAttr("disabled");
            $("#ButtonExcluir_" + this.ResultSet.Indexador).removeAttr("disabled");
        }else{
            $("#ButtonEditar_" + this.ResultSet.Indexador).prop("disabled","true");
            $("#ButtonExcluir_" + this.ResultSet.Indexador).prop("disabled","true");
        }
    }
    getTipoConteudo(id2, Valor){
        var TipoCampo = this.ResultSet.Campos[id2][18][0];
        switch (TipoCampo) {
            case "text":
                return "<span>"+ Valor +"</span>"
                break;

            case "image":
                var x = this.ResultSet.Campos[id2][18].width, y = this.ResultSet.Campos[id2][18].height
                x = x != "" ? "width: "+ x : ""
                y = y != "" ? "height: "+ y : ""
                
                return '<image style="'+ x +'; '+ y +'" src="">'
                break;
                
            case "Verify":
                var     caixa = "", v = ""
                    if(/sim|não/i.test(Valor)){
                        return '<input disabled type="checkbox" '+ (/sim/i.test(Valor) ? "checked" : "") +' >';
                    }
                    if(/certo|errado/i.test(Valor)){//
                        return '<i class="'+ (/certo/i.test(Valor) ? "fa fa-check" : "fa fa-remove") +'" style="font-size:19px"></i>';
                    }
                
                break;

            default:
                
                break;
        }
        
    }
    
    getLinhas(){
        
        var 
            LinhasHTML = "", 
                    TR = "", 
                    Html = "", 
                    indx1, 
                    indx2, 
                    Conteudo = "" ,
                    Valor = "", 
                    Check = "",
                    Numerador = "",
                    Edit = false, 
                    ChavePrimaria = "", 
                    eChave = false, 
                    DadosLinhas = null,
                    ShowIcons = "";
            
        DadosLinhas = this.ResultSet;
        
        if(DadosLinhas.Botoes["0"].Inserir || DadosLinhas.Botoes["1"].Editar || DadosLinhas.Botoes["2"].Delete){
           Edit = true;
        }
        
        for(var indx1 in DadosLinhas.ResultDados){
            /**
             * Busca os valores das chaves primárias, se existirem campos chave primária
             */
            ChavePrimaria = this.getValorChave(DadosLinhas.ResultDados[indx1]); 
            /**
             * Caso o usuário tenha permissão para editar a tabela será apresentada a caixa de seleção
             */
            if(Edit){
               Check = "<td  class='"+ this.GeralThClass +"'  style='text-align: center; vertical-align: inherit;'><input style='cursor: pointer' type='checkbox'  value='' data-chavePrimaria='" + ChavePrimaria +"' onclick='" + this.NomeInstancia +".setSelecionarLinhas(this)'></td>";
            }
            
            if(DadosLinhas.ContadorLinha){
                var NLinha = parseInt(DadosLinhas.InfoPaginacao.Deslocamento) + parseInt(indx1) + 1;
                Numerador = "<td class='"+ this.GeralThClass +"'  style='text-align: center;vertical-align: inherit;'>"+ NLinha +"</td>";
            }
            
            if(DadosLinhas.ShowColumnsIcones[0]){
                ShowIcons = this.gerarLinhasIcones(DadosLinhas.ShowColumnsIcones[1]);
            }            
            for(indx2 in DadosLinhas.Campos){

                if(DadosLinhas.Campos[indx2][3][0] && !DadosLinhas.Campos[indx2][3][1]){ //chave primaria e se view
                    continue;
                }
                if(DadosLinhas.Campos[indx2][6] == false){ //chave primaria e se view
                    continue;
                } 
                
                Conteudo = DadosLinhas.ResultDados[indx1][DadosLinhas.Campos[indx2][0]];
                
                if(this.Funcoes.Conteudo != false){
                    Valor = this.FAnonimas.Conteudo(indx2, Conteudo);
                }else{
                    Valor = this.getTipoConteudo(indx2, Conteudo);
                }
                
                LinhasHTML += "<td class='td_"+ DadosLinhas.Indexador+"' style='text-align: center; vertical-align: inherit;' data-chavePrimaria='" + ChavePrimaria +"' data-Valor='" + Conteudo +"'>"+ Valor +"</td>";
            }

            TR += "<tr style='display: flex;flex-direction: column-reverse;width: 100%;border-bottom: solid 3px #1b21da61;' class='tr_"+ DadosLinhas.Indexador+"'>" + Check + Numerador + ShowIcons + LinhasHTML +"</tr>";

            
            LinhasHTML = "";
        }
        Html = TR === null ? "" :  TR  ;
        
        return Html;
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
    gerarPopover(p){
        
        var Cabecalho = p.dataset.idn, instancia = this;
        
        if(this.ResultSet.Campos[Cabecalho][20] == false && this.ResultSet.Campos[Cabecalho][15] == false) return false;
        
        p.dataset.title = (this.ResultSet.Campos[Cabecalho][20] == true && this.ResultSet.Campos[Cabecalho][15] == true) ? "Filtrar e classificar" : ((this.ResultSet.Campos[Cabecalho][20] == true) ? "Filtrar" : ((this.ResultSet.Campos[Cabecalho][15] == true) ? "Classificar" : ""));
        p.dataset.animation = true;
        p.dataset.placement = "top";
        p.dataset.html = true;
        p.dataset.content = (this.ResultSet.Campos[Cabecalho][20] == true ?
                                '<div class="form-group">'+
                                    '<div class="input-group mb-2">'+
                                        '<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-search"></i></div></div>'+
                                        '<input type="text" class="form-control" data-idn="'+ Cabecalho +'" id="'+ this.NomeInstancia + "_"+ this.ResultSet.Indexador + "_" + Cabecalho + '">'+
                                    '</div>': "")+
                                    (this.ResultSet.Campos[Cabecalho][15] == true ? '<div style="margin-top: 10px; text-align: center"><button type="button" data-tipoOrdemby="asc" data-ordem="crescente" class="btn btn-primary">ASC <i class="fa fa-sort-amount-asc"></i></button> <button type="button"  data-tipoOrdemby="desc"  data-ordem="crescente" class="btn btn-primary">DESC <i class="fa fa-sort-amount-desc"></i></button></div>': "") +
                                '</div>';
        $(p).popover('show'); 
        $("[data-ordem='crescente']").unbind();
        $("[data-ordem='crescente']").click(function(){
            instancia.setOrdemBy(p, this);
            $(p).popover('hide'); 
        })
        
        $("#" + this.NomeInstancia + "_"+ this.ResultSet.Indexador + "_" + Cabecalho).keyup(function(){
            instancia.setGerarFiltrosCampo(this);
            if(event.keyCode == 13){
                $(p).popover('hide');
            }
        });
    }
    gerarLinhasIcones(Icon){
        
        if(Array.isArray(Icon)){
            var TdI = "", TipoIcone = "";
            for(var i in Icon){
                TipoIcone = Icon[i].Tipo;
                if(TipoIcone == "Bootstrap"){
                    TdI += "<td style='text-align: center;vertical-align: inherit;'><i class='"+ Icon[i].Icone + " "+ Icon[i].NomeBotao + "_"+ this.ResultSet.Indexador + "' style='font-size:18px; cursor: pointer' title='"+ Icon[i].tooltip +"'></i></td>";
                }else if(TipoIcone == "image"){
                    
                }
            }
            return TdI;
        }
    }
    gerarCabecalhoIcones(ColumnsIcon){
        if(Array.isArray(ColumnsIcon)){
            var ThI = "";
            for(var i in ColumnsIcon){
                ThI += "<td style='text-align: center; vertical-align: inherit;'>"+ ColumnsIcon[i].NomeColuna +"</td>";
            }
            return ThI;
        }
    }
    
   
    getBotoes(){
        var Bt = "", GetBotoes = this.ResultSet;
        if(GetBotoes.Botoes["0"].Inserir){
            Bt += "<td><center><button id='ButtonInserir_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"'  onclick='"+ this.NomeInstancia + ".showFormularioInserir()'>Inserir</button></center></td>";
        }
        if(GetBotoes.Botoes["1"].Editar){
            Bt += "<td><center><button id='ButtonEditar_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"' onclick='"+ this.NomeInstancia + ".showFormularioAtualizar()' disabled='true'>Editar</button></center></td>";
        }
        if(GetBotoes.Botoes["2"].Delete){
            Bt += "<td><center><button id='ButtonExcluir_"+ GetBotoes.Indexador + "' class='"+ this.GeralButtonClass +"' onclick='"+ this.NomeInstancia + ".JanelaExcluirDados()' disabled='true'>Excluir</button></center></td>";
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
            Refresh ='<td><div style="text-align: center;"><button type="button" class="btn btn-primary" onclick="'+ this.NomeInstancia +'.Refresh()"><i class="fa fa-refresh" style="font-size:18px;"></i></button></div></td>';
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
                                        <div style="margin-left: 2px;width: 141px;">\n\
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
        Tabela = "<table class='"+ this.GeralTableClass +"' style='margin-bottom:0px'>\n\
                                    <tr>\n\
                                        <th colspan='4' style='text-align: center'>"+ InfPag.TituloTabela +"</th>\n\
                                    </tr>"+ TH + "<tr>"+ FindAll + Refresh +"</tr>"+
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
        if(PaginacaoTotal == 1) return "";
        
        if(PgAtual == 1){
            this.PageModel.Inicial = 1;
            this.PageModel.Final   = PgTotalVisible < PaginacaoTotal ? PgTotalVisible : PaginacaoTotal;
            
        }else if(PgAtual > 1 && PgAtual > this.PageModel.Final && PgAtual <= PaginacaoTotal){
            this.PageModel.Inicial = parseInt(PgAtual);
            this.PageModel.Final = (parseInt(PgAtual) + parseInt(PgTotalVisible)) > PaginacaoTotal ? PaginacaoTotal : (parseInt(PgAtual) + parseInt(PgTotalVisible));
            
        }else if(PgAtual > 1 && PgAtual < this.PageModel.Inicial && PgAtual > 1){
            this.PageModel.Inicial = (parseInt(PgAtual) - parseInt(PgTotalVisible)) > 1 ? (parseInt(PgAtual) - parseInt(PgTotalVisible)) : 1;
            this.PageModel.Final = parseInt(PgAtual);
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
            Opcoes = "",
            Display = "block";
        
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
            
            if(Campo[8].TypeComponente == "textarea"){
                Label           = Campo[1];
                FNome           = Campo[8].Name;
                Tipo            = Campo[8].TypeConteudo;
                Title           = Campo[8].Titles;
                Display         = Campo[8].EditorText == true ? "display: none" : "";
                
                if(Campo[2].Exist && Modo != "Atualizar"){
                    Valor = Campo[2].Valor;
                }
                
                if(Campo[8].EditorText){
                    let NomeID = FNome + "_" + this.ResultSet.Indexador;
                    this.CamposEditores.push(NomeID);
                }
                
                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<textarea  title="'+ Title +'" class="form-control" rows="5" id="'+ FNome + "_" + this.ResultSet.Indexador +'" name="'+ FNome +'">'+ Valor +'</textarea>' +
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
        bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>")
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

    async showFormularioAtualizar(){
        var FormsCampos = await this.getCamposAtualizar();
    
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
                /**
         * Habilita o uso de editor de texto
         * @returns {void}
         */
        await this.habilitarEditor_Editor();

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
    async habilitarEditor_Editor(){
        CKEDITOR.removeAllListeners()
        let CamposEditores = this.CamposEditores
        if((CamposEditores.length > 0)){
            for(var i in CamposEditores){
                let CriarEvento = CKEDITOR.replace( CamposEditores[i] );
                
                CriarEvento.on('change', function(evt){
                    $("#"+CamposEditores[i]).html(evt.editor.getData());
                });
                
                this.CamposEditores = [];
            }
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
            ComponentCompleto = null,
            Indexador = 0,
            NomeTabela = "",
            Botoes = "",
            Paginacao = "",
            InfoP = "",
            InstanciaTabela = this;
        
        Indexador   = this.ResultSet.Indexador;
        NomeTabela  = this.ResultSet.NomeTabela;
        Linhas      = this.getLinhas();
        Botoes      = this.getBotoes();
        Paginacao   = this.getPaginacao();
        InfoP       = this.getInfoPaginacao();
        this.ChavesPrimarias = []; //Na mudança de página todas as chaves selecionadas são excluídas.
        
        ComponentCompleto = "\n\
            <div class=' "+ this.GeralDivClass +" ' id='Componente_" + Indexador + "'>                  \n\
                <div class='' id='Cabecalho_" + Indexador + "'>                                         \n\
                        "+ InfoP +"                                                                     \n\
                </div>                                                                                  \n\
                                                                                                        \n\
                <div  class='  "+ this.GeralDivClass +" ' id='Corpo_" + Indexador + "'>                 \n\
                    <table class='"+ this.GeralTableClass +"' id='"+ NomeTabela +"'>                    \n\
                        <tbody style='display: grid;width: 100%;'>                               \n\
                        "+ Linhas +"                                                                    \n\
                        </tbody>                                                                        \n\
                    </table>                                                                            \n\
                </div>                                                                                  \n\
                <div class=' "+ this.GeralDivClass +" ' id='Botoes_" + Indexador + "'>"+ Botoes + "</div>" 
                     + Paginacao 
        $("#" + this.Recipiente).html(ComponentCompleto);
        $("*").popover('hide');
        $("*").tooltip('hide');
        
        if(this.Funcoes.Linhas != false){
            $(".tr_" + this.ResultSet.Indexador).click(this.FAnonimas.Linha);
        }
        if(this.Funcoes.Celulas != false){
            $(".td_" + this.ResultSet.Indexador).click(this.FAnonimas.Celulas);
        }
        
        if(this.ResultSet.ShowColumnsIcones[0]){
            this.ResultSet.ShowColumnsIcones[1].forEach(function(v, i, p){
                var o = v
                $("." + v.NomeBotao + "_" + InstanciaTabela.ResultSet.Indexador).click(function(){
                    InstanciaTabela.FuncoesIcones[v.Func](InstanciaTabela, this)
                });
            });
        }
        
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
        if(TratarResposta.Error != false){
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

