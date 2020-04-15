/**
 * Modo de visualização padão sem nenhuma configuração especial, somente mapeamento dos campos
 * @type TabelaHTML
 */
var t = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
/**
 * Nome da tabela que esta no formato MD5 no arquivo de configuração Config/Configuracao.php
 * @type String
 */
t.setTabela = "64b99121f7e18c0f8586f30bf7806213";
t.setRecipiente = "dados";
t.Name = "t";
t.show();
            