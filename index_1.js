/**
 * Funcionalidades:
 * Recebe dados de um site via JSON
 * 1 - Coluna numeração
 *          public function getMostrarContador() {
                return true;
            }
 * 2 - Colunas icones - Projetadas em php
 *      2.1 - showColumnsIcones()
 *      
 * 3 - Botões Refresh - Configurados em php
 *      private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
 *      
 * 4 - Contabilização de páginas - idem (Pagina atual, Registros atuais, Total de registros)
 * 5 - Filtro geral
 *      
 * 6 - Filtro por campo acumulavel com os outros campos e o geral.
 * 7 - Botões incluir, editar e deletar - configurados por permissões no banco de dados ou manual via php
 * 8 - Tabelas view - São chamadas de virtuais pelo sistema
 * 9 - Ordem de campos - Asc Desc
        * t.DadosEnvio.sendOrdemBY = [1, "asc"]
        * 
 * 10 - Título das tabelas
 * 11 - Funções por ícones via variavel FuncoesIcones - configuradas via class php referente a cada tabela
        t.FuncoesIcones[0] = function(v, p){
           var y =v.getBreakChaves("0@36;1@337;")
           var t = v.getObterLinhaInteira(y);

       }
 * 
 * 12 - Funções por Coluna, Linha ou Célula via variável.
        t.Funcoes.Celulas = function(Obj, Chamador){
           //alert(Chamador.dataset.chaveprimaria)
       };
*
*
       t.Funcoes.Conteudo = function(a, v,p){
           return p;
       } 
 * 
 * 
 * 13 - Funções Chave Extrangeira.
 *          Arquivo PHP class tabela.
                "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ]
 * 
        * t.FuncoesChvExt[0] = async function(v,p){
           var Dados = new JSController("http://192.168.15.66:8080/CORAC/Controlador/"), result;
           Dados.DadosEnvio.sendTabela = "c258c5ff249499cba616a87265044965"
           Dados.DadosEnvio.sendModoOperacao = "ab58b01839a6d92154c615db22ea4b8f";
           //Dados.sendFiltros = [false,false,false]
           await Dados.Atualizar();
           for (var i in Dados.ResultSet.ResultDados){
               result += "<option>"+ Dados.ResultSet.ResultDados[i][0] +"</option>"
           }
           return result;
       }
 * 
 * @type TabelaHTML
 */
 
    
var t = new PostEdition("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
t.setTabela = "9e9524af7942ab2ca5efc37ea3738659";
t.setRecipiente = "dados";
t.Name = "t";
t.DadosEnvio.sendOrdemBY = [0, "asc"]
t.FuncoesIcones[0] = function(p1, p2){
        var Janela = {
                                    Janela: {Nome: "myJanelas", Tipo: "modal-lg", Tamanho: "fit-content"},
                                    Header: {Title: "Uploads", CorTexto: "white", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: "oi"}, 
                                    Footer: {
                                                Cancelar: {Nome: "Cancelar", classe: "" , Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", classe: "btn-primary" , Visible: "block", Funcao: function(){}}
                                            }
                                };
    p1.showJanela(Janela)
    var InstanciarUpload = new ReceberEnviar(".modal-body",2,"http://10.56.32.78:8080/CORAC/Controlador/", "a868a1388d958fb560eb17f2d71cbb9e");                                
}
t.FuncoesIcones[1] = function(p1, p2){
    alert(p1)
}
/*t.FuncoesChvExt[0] = async function(v,p){
    var Dados = new JSController("http://192.168.15.66:8080/CORAC/Controlador/"), result;
    Dados.DadosEnvio.sendTabela = "c258c5ff249499cba616a87265044965"
    Dados.DadosEnvio.sendModoOperacao = "ab58b01839a6d92154c615db22ea4b8f";
    //Dados.sendFiltros = [false,false,false]
    await Dados.Atualizar();
    for (var i in Dados.ResultSet.ResultDados){
        result += "<option>"+ Dados.ResultSet.ResultDados[i][0] +"</option>"
    }
    return result;
}*/
t.Funcoes.Conteudo = function(Obj, Linha, Ct){
    return Ct
};
//t.Filtros = [[1,"like","%020%"]]

t.show();
            