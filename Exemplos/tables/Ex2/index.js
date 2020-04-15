/**
 * Configurações realizadas dentro da classe PHP:
 * 1 - Título
 *  1.1 - getTituloTabela();
 *  
 * 2 - Total de Linhas por tabela;
 *  2.1 - getLimite();
 *  
 * 3 - Mostrar coluna contador.
 *  3.1 - getMostrarContador();
 * 
 * 4 - Configuração da paginação:
 *  4.1 - ModoPaginacao();
 *      4.1.1 - Simples
 *      4.1.2 - Salto de Página
 *      4.1.3 - Filtros
 *      4.1.4 - Botão Refresh
 *  
 *  5 - Definição do total de páginas que a tabela HTML mostrará.
 *      5.1 - getTotalPageVisible();
 *  
 *  6 - Definição de níveis de acesso: Existem 2 tipo de verificação um por variável array e outro 
 *  pela busca dos privilégios em uma tabela no banco de dados. Será utilizado a variável array caso
 *  o método getPrivBD() esteja retornando false;
 *      6.1 - getPrivilegios();
 *      6.2 - getPrivBD();
 *          6.2.1 - getPrivilerioBD();
 *          6.2.2 - busca na tabela privilegios os privilégios do usuário definido na classe.
 *                  dentro do arquivo ModeloTabelas.php esta a SQL que cria a tabela privilegios e login para seu uso efetivo.
 *                  Sem essas tabelas o sistema de verificação de privilégios por banco de dados não funcionará.
 *          6.2.3 - Quando da utilização desse sistema de privilégio será importante seu uso através do sistema de login com sessão.
 *          
 *  7 - Definição de colunas com ícones para execução de funções anônimas:
 *      7.1 - showColumnsIcones();
 *      7.1 - Define a exibição de colunas com ícones para realizar funções definidas na instânica da tabela. A defineção de exibição poderá ocorrer
 *            de forma geral ou por colunas.
 *            
 * 8 - Define filtros padrões por campos:
 *  8.1 - getFiltrosCampo();
 *
 * 9 - Executar instruções tipo triggers antes de operações serem realizadas dentro do banco de dados:
 *  9.1 - Jobs();
 *  9.2 - Durante a operação  de select() dentro da classe abstrata ModeloTabelas.php é chamada a instrução jobs() com 2 parametros, um o nome 
 *        da função que a chamou e outro, por referência, o conjunto de dados para munipulação.
 *  9.3 - Durante a operação de resgate do dados recuperador do banco de dados, após a operação select() terminar.
 *  9.4 - Durante a operação de inserir dados na tabela do banco de dados. Isso possibilita inumeras possibilidades de criações, presonalizadas, de
 *        funcionalidades.
 *  9.5 - O mesmo para as operações Update e Exclução.
 *      Obs.: Somente a operação, pura, de exclusão é que realizar o rollback caso ocorra algum erro na exclusão de 1 ou mais linhas.
 * 
 * 10 - Valida o conteúdo dos campos, antes de inserí-los, atualizá-los ou excluí-los da base de dados através de uma regex.
 *  10.1 - validarConteudoCampoRegex();
 *  10.2 - Utiliza, de cada campo, o campo regex que deverá ser preenchido com um array contendo um valor booleano e a regex que será
 *         aplicada nos dados do campo.
 * 
 * 11 - Controle sobre os campos que serão visualizados e atualizáveis, através do subarray de cada campo.
 * Formulario = [Exibir=>true, TypeComponente=>"inputbox"|"select", Name="Escolher"]
 * 
 * 12 - Valor padrão dos campos na tabela HTML na funcionalidade de inserção de dados.
 *  
 * @type TabelaHTML
 */
var tbl = new TabelaHTML("http://"+ Padrao.getHostServer() +"/CORAC/ControladorTabelas/");
/**
 * Nome da tabela que esta no formato MD5 no arquivo de configuração Config/Configuracao.php
 * @type String
 */
tbl.setTabela = "64b99121f7e18c0f8586f30bf78062e0";
tbl.setRecipiente = "dados";
tbl.Name = "tbl";
//tbl.Filtros = [[1,"like","%02%"],[2,"like","%8%",1]]
tbl.show();
            