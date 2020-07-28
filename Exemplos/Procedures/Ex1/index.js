/**
 * Modo de visualização padão sem nenhuma configuração especial, somente mapeamento dos campos
 * @type TabelaHTML
 */
var t = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorProcedures/");
/**
 * Nome da tabela que esta no formato MD5 no arquivo de configuração Config/Configuracao.php
 * @type String
 */
t.sendProcedure = "bb22afd6fd3058670dbdf0bcc064ddde";
t.setRecipiente = "dados";
t.DadosEnvio.sendProcedure = "bb22afd6fd3058670dbdf0bcc064ddde";
t.DadosEnvio.sendEntradas = "1,3";

t.Name = "t";
//t.CSSEspefTableBD[0].Cabecalho.thead = "CabtheadModelHoriz"
//t.CSSEspefTableBD[0].Cabecalho.th = "CabthModelHoriz"
//t.CSSEspefTableBD[0].Cabecalho.td = "CabtdModelHoriz"
//t.CSSEspefTableBD[0].Cabecalho.tr = "CabtrModelHoriz"
//
//t.CSSEspefTableBD[1].Corpo.tbody = "bodytheadModelHoriz"
//t.CSSEspefTableBD[1].Corpo.tr = "bodytrModelHoriz"
//t.CSSEspefTableBD[1].Corpo.td = "bodytdModelHoriz"

//t.GeralTableClass = "";
t.show();
            