/**
 * Modo de visualização padão sem nenhuma configuração especial, somente mapeamento dos campos
 * @type TabelaHTML
 */
var t = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
/**
 * Nome da tabela que esta no formato MD5 no arquivo de configuração Config/Configuracao.php
 * @type String
 */
t.setTabela = "5ca5579ec4bd2e5ca5d9608be68ae733";
t.setRecipiente = "dados";
t.Name = "t";
t.show();
            