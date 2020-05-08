/**
 * Criado: 03/10/2018
 * Modificado: 
 * 
 * Arrays definidos CGeral[15] - Pesquisa gerada pelo campo localizar da tabela
 */
class TabelaHTML extends JSController{
    constructor(Caminho){
        super(Caminho);
        this.Recipiente = null; //Nome do recipiente que receberá o componente com os dados.
        this.NomeInstancia = null; //Nome do objeto instanciado na memória.
        this.ChavesPrimarias = []; //Array que armazena, de uma determinada instância, as chaves primárias de uma tabela HTML
        this.FrameWork = "bootstrap"; //Informa com qual framework o componente mostrará os dados.
        this.DadosEnvio.sendPagina = 1;
        this.DadosEnvio.sendFiltros = [false, false, false];
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
        
        this.GeralTableClass = "table",
        this.GeralDivClass = "",
        this.GeralThClass = "",
        this.GeralTdClass = "",
        this.GeralTrClass = "",
        this.GeralLiClass = "page-item",
        this.GeralAClass = "page-link",
        this.GeralUClass = "pagination",
        this.GeralButtonClass = "btn btn-primary",
        this.visibleChavePrimaria = false,
        this.VisibleDetalhesUpdate = true;

        this.Configuracao = {
            Tabela: {
                Linha: {
                    Color: "",
                    Fonte: "",
                    Select_Color: "red",
                    Unselect_Color: "blue"
                },
                Celula: {
                    Color: "",
                    Fonte: ""
                }
            },
            
        }
        
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
        let Pai = L.parentNode.parentNode.classList, results = false;
        results = Pai.contains("LinhaSelecionada")
        if(results){
            $(L.parentNode.parentNode).removeClass("LinhaSelecionada");
            $(L.parentNode.parentNode).css("background",this.Configuracao.Tabela.Linha.Unselect_Color);
        }else{
            $(L.parentNode.parentNode).addClass("LinhaSelecionada");
            $(L.parentNode.parentNode).css("background",this.Configuracao.Tabela.Linha.Select_Color);

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
                ShowIcons = this.gerarLinhasIcones(DadosLinhas.ShowColumnsIcones[1], ChavePrimaria);
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

            TR += "<tr class='tr_"+ DadosLinhas.Indexador+"'>" + Check + Numerador + ShowIcons + LinhasHTML +"</tr>";

            
            LinhasHTML = "";
        }
        Html = TR === null ? "" : "<tbody>" + TR + "</tbody>" ;
        
        return Html;
    }
    
    setOrdemBy(o, BotaoChamador){
        var Campo = o.dataset.idn, OrBy = BotaoChamador.dataset.tipoordemby, Clss = this.ResultSet.OrdemBy;
        this.DadosEnvio.sendOrdemBY = [Campo, OrBy]
        this.show();
    }
    
    setDefaultOrderBy(Campo, Ordem){
        this.DadosEnvio.sendOrdemBY = [Campo, Ordem]
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
        
        let Title = (this.ResultSet.Campos[Cabecalho][20] == true && this.ResultSet.Campos[Cabecalho][15] == true) ? "Filtrar e classificar" : ((this.ResultSet.Campos[Cabecalho][20] == true) ? "Filtrar" : ((this.ResultSet.Campos[Cabecalho][15] == true) ? "Classificar" : ""));
        //p.dataset.animation = true;
        //p.dataset.placement = "left";
        //p.dataset.html = true;
        var ctp = (this.ResultSet.Campos[Cabecalho][20] == true ?
                                '<div class="form-group">'+
                                    '<div class="input-group mb-2">'+
                                        '<div class="input-group-prepend"><div class="input-group-text"><i class="fa fa-search"></i></div></div>'+
                                        '<input type="text" class="form-control" data-idn="'+ Cabecalho +'" id="'+ this.NomeInstancia + "_"+ this.ResultSet.Indexador + "_" + Cabecalho + '">'+
                                    '</div>': "")+
                                    (this.ResultSet.Campos[Cabecalho][15] == true ? '<div style=\"margin-top: 10px; text-align: center\"><button type=\"button\" data-tipoOrdemby=\"asc\" data-ordem=\"crescente\" class=\"btn btn-primary\">ASC <i class=\" fas fa-sort-amount-up\"></i></button> <button type=\"button\"  data-tipoOrdemby=\"desc\"  data-ordem=\"crescente\" class="btn btn-primary\">DESC <i class=\" fas fa-sort-amount-down\"></i></button></div>': "") +
                                '</div>';
        var Content = '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>';
                            
 
        var t = $(p).viewPopover({Conteudo: ctp, Titulo: Title, Clear: true})
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
    gerarLinhasIcones(Icon, ChavePrimaria){
        
        if(Array.isArray(Icon)){
            var TdI = "", TipoIcone = "";
            for(var i in Icon){
                if(!Icon[i].Visible) continue;
                TipoIcone = Icon[i].Tipo;
                if(TipoIcone == "Bootstrap"){
                    TdI += "<td style='text-align: center;vertical-align: inherit;'><i data-chavePrimaria='" + ChavePrimaria +"'  class='"+ Icon[i].Icone + " "+ Icon[i].NomeBotao + "_"+ this.ResultSet.Indexador + "' style='font-size:18px; cursor: pointer' title='"+ Icon[i].tooltip +"'></i></td>";
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
                if(!ColumnsIcon[i].Visible) continue;
                ThI += "<th style='text-align: center; vertical-align: inherit;'>"+ ColumnsIcon[i].NomeColuna +"</th>";
            }
            return ThI;
        }
    }
    
    getCabecalho(){
        var 
            indx = null, 
            CabHTML = "", 
            Html = null, 
            GetCabecalho = this.ResultSet, 
            FCampo = "", 
            FFilter = "",
            Ordered = "",
            Numerador = "",
            ShowColunasIcons = "";
        
        if(GetCabecalho.Botoes["0"].Inserir || GetCabecalho.Botoes["1"].Editar || GetCabecalho.Botoes["2"].Delete){
           var Auto = "<th  class='"+ this.GeralThClass +"'  style='text-align: center'>#</th>";
        }else{
            var Auto = "";
        }
        
        if(GetCabecalho.ContadorLinha){
            Numerador = "<th  class='"+ this.GeralThClass +"'  style='text-align: center'>N°</th>";
        }
        
        if(GetCabecalho.ShowColumnsIcones[0]){
            ShowColunasIcons = this.gerarCabecalhoIcones(GetCabecalho.ShowColumnsIcones[1]);
        }
        
            /**
             * Exibe ou não as chaves primárias. Essa configuração fica configurada por declaração de campos da tabela via php
             * TabelaBD -> nome do banco de dados -> class
             */
            for(indx in GetCabecalho.Campos){
                if(GetCabecalho.Campos[indx][3][0] && !GetCabecalho.Campos[indx][3][1]){
                    continue;
                }
                /**
                 * Exibe ou não o campo atual. Essa configuração fica configurada por declaração de campos da tabela via php
                 * TabelaBD -> nome do banco de dados -> class
                 */
                if(GetCabecalho.Campos[indx][6] == false){
                    continue;
                }
                
                /**
                 * Verifica se foram utilizado filtros. Essa configuração fica configurada por declaração de campos da tabela via php
                 * TabelaBD -> nome do banco de dados -> class
                 */
                
                if(GetCabecalho.Filtros[2] != "false"){
                    if(Array.isArray(GetCabecalho.Filtros[2])){
                        var exist = this.getCampoExistFiltro(GetCabecalho.Filtros[2], GetCabecalho.Campos[indx][0])
                        if(exist[1]){
                            if(exist[2] != "%"){
                                FFilter = ' <i id="FiltroCampo" data-toggle="tooltip" title="Filtro: '+ exist[2] +'" class="fa fa-filter" style="font-size:14px; color: red; cursor: pointer"></i>';
                            }
                            else{
                                FFilter = '';
                            }
                            exist = false;
                        }else{
                            FFilter = "";
                        }
                    }
                }
                if(GetCabecalho.OrdemBy[0] == GetCabecalho.Campos[indx][0]){
                    
                    if(GetCabecalho.OrdemBy[1] == "asc"){
                        Ordered = ' <i id="Ordered" data-toggle="tooltip" title="Crescente" class="fas fa-sort-amount-up" style="font-size:14px; color: red; cursor: pointer"></i>';
                    }else {
                        Ordered = ' <i id="Ordered" data-toggle="tooltip" title="Decrescente" class=" fas fa-sort-amount-down" style="font-size:14px; color: red; cursor: pointer"></i>';
                    }
                }else{
                    Ordered = '';
                }
                FCampo = "<a href='#' onclick='"+ this.NomeInstancia +".gerarPopover(this)' data-OrdemBy='"+ GetCabecalho.OrdemBy[1] +"'  data-idn='"+ GetCabecalho.Campos[indx][0] +"' <span>"+ GetCabecalho.Campos[indx][1] + "</span></a>";

                CabHTML += "<th  class='"+ this.GeralThClass +"'  style='text-align: center'>"+ FCampo + FFilter + Ordered + "</th>";
            
        }

        Html = CabHTML === null ? "" : "<thead><tr>" + Auto + Numerador + ShowColunasIcons + CabHTML + "</tr></thead>" ;
        
        return Html;
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
            TH = "<tr ><th colspan=20>"+ InfPag.TotalLinhas + " Registro(s) - "+ InfPag.TotaldePaginas + " Página(s)</th></tr>";
        }else{
            var Inicio = 1, Fim = 0;
            Inicio = InfPag.Deslocamento + 1;
            Fim = InfPag.Deslocamento + this.ResultSet.ResultDados.length
            
            TH = "<tr><th colspan=20>Página atual: <i class='fa fa-file'></i> "+ InfPag.PaginaAtual +"/"+ InfPag.TotaldePaginas  +"  <br>Registro: "+ Inicio +" até "+ Fim +"</th></tr><tr><th colspan=20>"+ InfPag.TotalLinhas + " Total registro(s) - "+ InfPag.TotaldePaginas + " Página(s)</th></tr>";
        }

        if(InfPag.ModoPaginacao.BRefresh){
            Refresh ='<td><div style="text-align: center;"><button type="button" class="btn btn-primary" onclick="'+ this.NomeInstancia +'.Refresh()"><i class=" fas fa-sync-alt" style="font-size:18px;"></i></button></div></td>';
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
                                        <div style="margin-left: 2px;width: 141pxmargin-left: 2px;width: 141px;padding-top: 3px">\n\
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
                                        "+ (InfPag.TituloTabela == false ? "" : "<th colspan='4' style='text-align: center'>"+ InfPag.TituloTabela) +"</th>\n\
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
        if((PaginacaoTotal == 1)| (PaginacaoTotal == 0)) return "";
        
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
    async setFExecuteChv(NF, Objeto){
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
            Func = "",
            Required = "";
                
    Label           = Campo[1];
    FNome           = Campo[8].Name;
    Tipo            = Campo[8].TypeConteudo;
    Leitura         = Campo[8].readonly == true ? "readonly" : "";
    Botao           = Campo[19].NomeBotao;
    Required        = Campo[8].Required == true ? "required='true'" : "";
    /**
     * Campo muito importante para o sistema de chave extrangeira, fica configurado lá no arquivo de php. Caso
     * seu valor seja false, significa que os dados da tabela extrangeira foram incorporados ao dados da tabela atual.
     * e que estão localizados no campo DadosTblExt pra tratamento.
     */
    Func            = Campo[19].Funcao; 
    
    if(this.FrameWork == "bootstrap"){
        if(Campo[8].TypeComponente == "button"){

                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<input '+ Required +' type="'+ Tipo +'" '+ Leitura +' class="form-control" name="'+ FNome +'" value="'+ Valor +'"><button type="button" onclick="'+ this.NomeInstancia +'.setFExecuteChv('+ Func +', this)" class="btn btn-primary Bt_ChvExt_'+ this.ResultSet.Indexador +'">'+ Botao +'</button>' +
                                '</div>';
                return Template;
        }   
            
        if(Campo[8].TypeComponente == "select"){
                if(Func !== false){
                    Template = ' \n\
                                    <div class="input-group mb-3">' +
                                        '<div class="input-group-prepend">' +
                                            '<span class="input-group-text">'+ Label +':</span>' +
                                        '</div>' +
                                        '<select  '+ Required +'  class="form-control"  name="'+ FNome +'" >'+ 

                                            await this.setFExecuteChv(Func) 

                                        +'</select>' +
                                    '</div>';
                    
                }else{
                    Template = ' \n\
                                    <div class="input-group mb-3">' +
                                        '<div class="input-group-prepend">' +
                                            '<span class="input-group-text">'+ Label +':</span>' +
                                        '</div>' +
                                        '<select  '+ Required +'  class="form-control"  name="'+ FNome +'" >'+ 

                                            await this.getSelectChExtrangeira(Campo, Valor) 

                                        +'</select>' +
                                    '</div>';
                    
                }
                return Template;
            }  
    }
                    
                    
}
/**
 * Método que gera as opções da caixa de select para as janalas do botão inserir e editar
 * @param {Array} Dados
 * @param {Text} Valor
 * @returns {String}
 */
    async getSelectChExtrangeira(Dados, Valor){
        let Selects = '<option value=""></option>',
            Selected = '';

        for (var i in Dados[19].DadosTblExt) {
            for(var c in Dados[19].DadosTblExt[i]){
                
                if(c == Dados[19].IdxCampoVinculado) continue;
                
                Selected = Dados[19].DadosTblExt[i][Dados[19].IdxCampoVinculado] == Valor ? "selected" : "";
                
                Selects += '<option '+ Selected + ' value="'+ Dados[19].DadosTblExt[i][Dados[19].IdxCampoVinculado] + '">'+ Dados[19].DadosTblExt[i][c] + '</option>';
            }
        }
       
        return Selects;
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
            Valor = Modo == "Atualizar" ? this.getObterValorCampos(Campo[0]) : ""; //IdxCampoVinculado -> Vem do banco de dados e é o vínculo entre a chave extrangeira
            return await this.getCamposChaveExtrangeira(Campo, Valor);
        }
        
        if(this.FrameWork == "bootstrap"){
            
           
            if(Campo[8].TypeComponente == "inputbox"){
                Label           = Campo[1];
                Placeholder     = Campo[8].Placeholder;
                FNome           = Campo[8].Name;
                Tipo            = Campo[8].TypeConteudo[0];
                Required        = Campo[8].Required == true ? "required='true'" : "";;
                Title           = Campo[8].Titles;
                Patterns        = Campo[8].Patterns;
                Leitura         = Campo[8].readonly == true ? "readonly" : "";
                Formenctype     = Campo[8].formenctype == "" ? "" : "formenctype='"+ Campo[8].formenctype + "'";
                //TabelaBD - Campos valores padrões, devem ter uma definição para cada uma
                if(Campo[2].Exist && Modo != "Atualizar"){
                    Valor = Campo[2].Valor;
                    if(Campo[2].Readonly){
                        Leitura = "readonly";
                    }
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
                Required        = Campo[8].Required == true ? "required='true'" : "";
                
                Tipo.forEach(function(v,i,p){
                    var S = v == Valor ? "selected" : "";
                    Opcoes += "<option "+ S +" >"+ v +"</option>";
                })
                
                Template = ' \n\
                                <div class="input-group mb-3">' +
                                    '<div class="input-group-prepend">' +
                                        '<span class="input-group-text">'+ Label +':</span>' +
                                    '</div>' +
                                    '<select  '+ Required +' class="form-control"  name="'+ FNome +'">'+ Opcoes +'</select>' +
                                '</div>';
                return Template;
            }           
            
            if(Campo[8].TypeComponente == "textarea"){
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
                                    '<textarea '+ Required +' title="'+ Title +'"  '+ Patterns +' class="form-control" '+ Leitura +' placeholder="'+ Placeholder +'" name="'+ FNome +'">'+ Valor +'</textarea>' +
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
        switch(Erros.Codigo){
            case 12006:
                bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>");
                window.location = Erros.Dominio;
                break;
            default:
                bootbox.alert("<h3>"+ Erros.Mensagem +"</h3>");
                break;
        }
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
                                    Body: {Conteudo: FormsCampos, Scroll: true}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", classe: "" , Visible: "block", Funcao: function(){}},
                                                Status: {Display: false, Conteudo: ""}
                                            },
                                    Modal: {backdrop: true,keyboard: true}
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
            let Diferenca = this._TotalRegistroUpdate - this.ChavesPrimarias.length + 1;
            $("#ContadorRegistro").html(Diferenca)
            
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
        var Campos = "", GetResultado = this.ResultSet, DetalhesUpdate = "";
        
        for(var indx in GetResultado.Campos){
            if(GetResultado.Campos[indx][8].Exibir !== true) continue;
            Campos += await this.getGrupoCamposFramework(GetResultado.Campos[indx], "Atualizar");
        }
        
        if(Campos != ""){
            Campos = "<form onsubmit='"+ this.NomeInstancia +".EnviarFormularioEditar(this)'>"+ Campos + "<button class='btn btn-success btn-block'>Atualizar</button></form>";
        } else return false;
        
        return Campos;
    }

    async showFormularioAtualizar(){
        var FormsCampos = await this.getCamposAtualizar();
            if(FormsCampos == false) {
                bootbox.alert("<h3><i class='fa fa-check-square-o' style='font-size:36px;'></i> Não há campos para serem editados.</h3>");
                return false;
            }
            this._TotalRegistroUpdate = this.ChavesPrimarias.length;
            let Status = "<div style='font-style: italic;font-family: monospace;'><span><b>Registro(s)</b></span> <span id='ContadorRegistro'>:0</span><span> / "+ this.ChavesPrimarias.length +"</span></div>";
            
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-lg", Tamanho: "50%"},
                                    Header: {Title: "Editar", CorTexto: "white", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: FormsCampos, Scroll: true}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "none", Funcao: function(){var o}}, 
                                                Aceitar: {Nome: "Close", classe: "" , Visible: "block", Funcao: function(){var o}},
                                                Status: {Display: true, Conteudo: Status}
                                            },
                                    Modal: {backdrop: true,keyboard: true}
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
        cabecalho   = this.getCabecalho();
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
                        "+ cabecalho +"                                                                 \n\
                        "+ Linhas +"                                                                    \n\
                    </table>                                                                            \n\
                </div>                                                                                  \n\
                <div class=' "+ this.GeralDivClass +" ' id='Botoes_" + Indexador + "'>"+ Botoes + "</div>" 
                     + Paginacao 
        $("#" + this.Recipiente).html(ComponentCompleto);
        //$("*").popover('hide');
        //$("*").tooltip();
        
        if(this.Funcoes.Linhas != false){
            $(".tr_" + this.ResultSet.Indexador).click(this.FAnonimas.Linha).css("cursor","pointer");
            $(".tr_" + this.ResultSet.Indexador).hover(function(){
                $(this).css("background-color","#557775")
            }, function(){
                $(this).css("background-color","initial")
            })
        }
        if(this.Funcoes.Celulas != false){
            $(".td_" + this.ResultSet.Indexador).click(this.FAnonimas.Celulas).css("cursor","pointer");
            $(".td_" + this.ResultSet.Indexador).hover(function(){
                $(this).css("background-color","#557775")
            }, function(){
                $(this).css("background-color","initial")
            })
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
                                    Janela: {Nome: "myJanelas", Tipo: "modal-sm", Tamanho: "400px"},
                                    Header: {Title: "<i class='fa fa-trash-o' style='font-size:36px'></i> Excluir", CorTexto: "white", backgroundcolor: "#dc3545"}, 
                                    Body:   {Conteudo: Mensagem}, 
                                    Footer: {
                                                Cancelar: {Nome: "Não", classe: "btn-success" , Color: "white" ,Visible: "block", Funcao: function(){var o}}, 
                                                Aceitar: {Nome: "Excluir", classe: "btn-danger" , Color:"white", Visible: "block", Funcao: function(){o.excluir()}},
                                                Status: {Display: false, Conteudo: ""}
                                            },
                                    Modal: {backdrop: true,keyboard: true}
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
                                    Body: {Conteudo: Mensagem, Scroll: true}, 
                                    Footer: {
                                                Cancelar: {Nome: "nao", Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", Visible: "block", Funcao: function(){}},
                                                Status: {Display: false, Conteudo: ""}
                                            },
                                    Modal: {backdrop: false,keyboard: true}
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
        
        if(Componentes.Body.Scroll){
            $(".modal-dialog").addClass("modal-dialog-scrollable")
        }else{
            $(".modal-dialog").removeClass("modal-dialog-scrollable")
        }
        
        $(".modal-body").html(Componentes.Body.Conteudo);

        if(Componentes.Footer.Status.Display == false){
            $(".status-footer").css("display","none")
        }else{
            $(".status-footer").css("display","initial")
            $(".status-footer").html(Componentes.Footer.Status.Conteudo)
        }
        
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
        
        $("#" + Componentes.Janela.Nome).modal(Componentes.Modal);
        
    }
}

