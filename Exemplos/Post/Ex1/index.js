/**
 * Configurações realizadas dentro da classe PHP:
 * 13 - Tabelas virtuais ou view
 *  13.1 - Chaves primárias
 *  13.2 - Chaves extrangeiras
 *  13.3 - setNomeTabela(); Informa o nome verdadeiro ou virtual da tabela.
 *  13.4 - getNomeReal(); Informa o nome real no banco de dados.
 *  13.5 - getVirtual(); Informa se a tabela é uma view. true|false
 *  
 * @type TabelaHTML
 */
var tbl = new postView("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
/**
 * Função obrigatoriamente assíncrona que busca as informações e apresentam em uma caixa select os dados referentes à chve extrangeira
 * Usa a classe JSController para buscar somente os dados
 * @param {type} v - Instancia que chamou a função
 * @param {type} p - numero da função
 * @param {type} o - Objeto que chamou a funcção
 * @returns {unresolved}
 */
tbl.FuncoesChvExt[0] =async function(v, p, o){
           var Dados = new JSController("http://10.56.32.78:8080/CORAC/ControladorTabelas/"), result;
           Dados.DadosEnvio.sendTabelas = "52c1592330d80979c6df1f8bd9d27be3"
           Dados.DadosEnvio.sendModoOperacao = "ab58b01839a6d92154c615db22ea4b8f";
           //Dados.sendFiltros = [false,false,false]
           await Dados.Atualizar();
           for (var i in Dados.ResultSet.ResultDados){
               result += "<option value='"+ Dados.ResultSet.ResultDados[i][0] +"'>"+ Dados.ResultSet.ResultDados[i][1] +"</option>"
           }
           return result;
       }  
/**
 * Nome da tabela que esta no formato MD5 no arquivo de configuração Config/Configuracao.php
 * @type String
 */
tbl.setTabela = "64b99121f7e18c0f8586f30bf7806213";
tbl.setRecipiente = "dados";
tbl.Name = "tbl";
/**
 * Função que será executada ao clicar em qualquer linha da tabela.
 * @param {Objeto} v - Instância da tabela que criou a linha
 * @param {DOM} p - A linha com suas células.
 * @returns {void}
 */
/*tbl.Funcoes.Linhas1 = function(v,p){
    console.log(v)
    console.log(p)
}*/
/**
 * 
 * @param {Objeto} v - Instância da tabela que criou a linha
 * @param {DOM} p - A Célula da tabela html que chamou.
 * @returns {undefined}
 */
/*tbl.Funcoes.Celulas = function(v,p){
    console.log(v)
    console.log(p)
}*/

/**
 * Tem como função trabalhar com o conteúdo e retornar o mesmo ou outro valor.
 * @param {Objeto} Instancia
 * @param {int} Index
 * @param {DOM} Conteudo
 * @returns {String}
 */
/*tbl.Funcoes.Conteudo = function(Instancia, Index, Conteudo){
    console.log(Instancia);
    console.log(Index);
    console.log(Conteudo);
    Index = parseInt(Index);
    switch (Index) {
        case 2:
            return "Amostra " + Conteudo
            break;
            
        default:
            return "Conteúdo gerado Javascrip";
            break;
    }
}*/

tbl.show();
            