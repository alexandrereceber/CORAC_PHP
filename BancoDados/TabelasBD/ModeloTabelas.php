<?php
if(@!include_once dirname(__DIR__) ."/../Config/Configuracao.php"){  //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 6000;
    $ResultRequest["Erros"][2]             = "O arquivo de configuração não foi encontrado. Modelo de tabelas";
    
    echo json_encode($ResultRequest);
    exit;
};

if(@!include_once ConfigSystema::get_Path_Systema() . '/BancoDados/Engines/BDSQL_PDO.php'){ //Include que contém o acesso ao banco de dados.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 6001;
    $ResultRequest["Erros"][2]             = "O arquivo Engines de configuração do banco de dados não foi localizado. Modelo de tabelas.";
    
    echo json_encode($ResultRequest);
    exit;
};

 
/**
 * Criado: 24/09/2018
 * Modificado: 
 */

/**
 * Modelo de classe abstrata que apresenta dos métodos e os atributos que deverão ser utilizados para a utilização de todas
 * as tabelas do banco de dados que serão visualizadas no sistema.
 * @Autor 04953988612
 */

/**
 * MODELAGEM DE ERROS
 * PDOException - Números, códigos de erros e a instrução onde ela ocorre.
 * 1 - SELECT()
 * 2
 */
abstract class ModeloTabelas extends BDSQL{
    /**
     * O total de deslocamento(s) que será(ão) realizado(s) ao realizar a busca no banco de dados
     * informados na variável $Limite.
     * @var int $Deslocamento
     */
    private $Deslocamento = 0;
    /**
     * Nome da tabela no banco de dados
     * @var type String
     */
    protected $NomeTabela = null;
    /**
     * Armazena as chaves primárias que serão utilizadas na inserção, atualização e remoção dos dados.
     * @var Array 
     */
    private $ChavesPrimarias = null;
    /** 
     * 
     * Variável que contém o nome dos campos que serão visualizados no banco de dados.
     * @var Array Contém os campos da tabela.
     */
    protected $TabelaCampos = false;
    /**
     * Filtro que será utilizado pela pesquisa
     * @var type String
     */
    protected $Filtros = "";
    
    /*
     * Usuário que esta tentando acesso à tabela
     */
    private $Usuario = null;
    /**
     * Armazena o total de linhas recuperadas pela consulta à tabela.
     * @var integer 
     */
    private $TotalLinhasTabela = 0;
    private $PaginaAtual = 0;    
    private $TotaldePaginas = 0;
    
    private $StartClock = [];
    private $EndClock = [];
    private $OrdemBy = 0;
    private $Privilegios = [];
    /**
     * @abstract
     */
    abstract function setNomeTabela(); //Método para recuperar o nome da classe que é o mesmo da tabela no banco de dados.
    /**
     * Retorna, em array, os usuários que poderão realizar operações nessa tabela.
     */
    abstract public function getPrivilegios();
    /**
     * Retorna, em array, os campos que serão utilizados pela pesquisa no banco de dados.
     * @return Array 
     */
    abstract public function getCampos();
    /**
     * Retorno o título da tabela definido na classe da tabela
     */
    abstract public function getTituloTabela();
    /**
     * Retorna se a páginação será simples ou completa.
     */
    abstract public function ModoPaginacao();
    /**
     * Obtém o total de linhas por página na tabela.
     */
    abstract public function getLimite();
    /**
     * Obtém a quantidade máxima visível de paginas por agrupamento.
     */
    abstract public function getTotalPageVisible();
    /**
     * Habilitar a apresentação da coluna que mostra uma coluna com contador.
     */
    abstract public function getMostrarContador();
    /**
     * Habilita a visualização de coluna com ícones para cada linha.
     *         $Habilitar = true;
                $Icones = [
                                [
                                    "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                                    "NomeBotao"=>"Localizar", 
                                    "Icone" => "fa fa-search", 
                                    "Func" => 0, 
                                    "Tipo" => "Bootstrap", 
                                    "tooltip"=> "busca"
                                ]
                            ];
                $ShowColumns[0] = $Habilitar;
                $ShowColumns[1] = $Icones;

                return $ShowColumns;
     */
    abstract public function showColumnsIcones();
    /**
     * Habilita a tabela em modo Real ou View se for true o sistema irá obter o nome da tabela real pelo método getNomeReal()
     */
    abstract public function getVirtual();
    /**
     * Informa qual o nome da tabela real que representa a tabela view;
     */
    abstract public function getNomeReal();
    /**
     * Retorna a expressão que será utilizada, como valor padrão, nos campos HTML
     * Ex.: 
     * A função foi criada com intuito de poder ser modificada. Abaixo somente um exemplo.
            $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
            $ValorPadraoCampos[1] = [Exist=>true, Valor=>"sim"];
            $ValorPadraoCampos[2] = [Exist=>true, Valor=>"sim"];
            $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];* 
     * Ou usar com a instrução switch para melhorar o desempenho.
     */
    abstract public function getValorPadrao($idx);
    /**
     * Método que habilita ao sistema buscar as informações de privilégios dentro da base de dados.
     * O padrão é um array, em cada classe, contendo os privilégios.
     * return true; return false;
     */
    abstract public function getPrivBD();
    /*
     * Objetivo é obter filtros personalizados para cada campo da tabela.
     * Esses são filtros padrões que são formados pelo operador e mais o filtro. Tudo ocorre a nível
     * de class php, não existe definição via javascript, pois é um filtro por campo e o conteúdo do método poderá ser alterado.
     * 
             $Campo[3] = [["like","%12321"]];
        
            return $Campo[$idx];
     
     * * Ou usar  a instrução swtich para melhorar o desempenho.
     */
    abstract public function getFiltrosCampo();
    /**
     * Objetivo é criar a possibilidade de extensão, uma vez que, qualquer funcionalidade personalizada para cada tabela, poderá
     * ser criada com o mecanismo de funções anônimas.
     * Obs.: As chamada dentro das funções devem ser $this->Jobs(__FUNCTION__, $Variavel)
     * Nos métodos Select, depois da execução, Insert, Update e delete possuem uma chamada, exceto a select,
     * antes da chamada      * propriamente dita e outra depois da execução das determinadas instruções mysql, 
     * viabilizando assim a possibilidade de lidar com transações. Begintransaction, roolback e commit.
     */
    abstract public function Jobs($Tipo, &$ConjuntoDados, $Action, $Resultado);
    /**
     * Verifica, para cada campo, o conteúdo do campo antes de inserí-lo no banco de dados e caso não esteja de acordo
     * com a regex o sistema aborta a ação.
     */
    abstract public function validarConteudoCampoRegex(&$Dados);

    /**
     * Antes de realizar qualquer filtro na tabela poderá ser utilizada uma função para normalizar ou
     * verificar ou até corrigir entradas de Filtro;
     */
    abstract public function NormalizarFiltro($Func);


    public function __construct() {
        parent::__construct();
        $this->setNomeTabela();
    }

    /**
     * Armazena a string criada na variável SqlCampos
     * @return Vazio
     */
    private function gerarStringCamposSQL(){

        $this->TabelaCampos = $this->getCampos();
        
        $Count = 0;
        foreach ($this->TabelaCampos as $Chave => $Valor) {
            if($Count == 0){
                if(empty($Valor["Field"])) continue;
                $SqlCampos = $Valor["Field"];
                $Count = 1;
            }else{
                if(empty($Valor["Field"])) continue;
                $SqlCampos .= ", ". $Valor["Field"] ." ";
            }
        }
        
        
        return $SqlCampos;
    }

    /**
     * Informa a quantidade de deslocamento que será realizado na busca dos dados.
     * @param integer $Deslocamento
     */
    public function setDeslocamento($Deslocamento) {
        $this->Deslocamento = $Deslocamento;
    }
    /**
     * Armazena o tipo e o filtro. Pode ser qualquer tipo
     * @param String $Tipo
     * @param String $Filtro
     */
    public function setFiltros(&$Filtro) {
        $this->Filtros = $Filtro;
    }
    
    /**
     * Obtém os filtros repassados ao servidor pelo cliente.
     * @return array
     */
    public function getFiltros() {
        return $this->Filtros;
    }
    
    /**
     * Filtros padrões são filtros que são declarados com diversas combinações.
     * @param array $Of - Indica se existe ou não filtros pré-existentes;
     * @return string
     */
    private function FiltrosPadroes($Of) {
        $FiltroPadraoCpt = "";
        $Filtros = $this->getFiltrosCampo();
        foreach ($Filtros as $key => $value) {
        $CountCI = 0;
            foreach ($value as $ky => $vl) {
                if($CountCI == 0){
                    $FiltroPadrao[$key] = $this->idx_NomeCampo($vl[0]) . " " . $vl[1] ." '" . $vl[2] . "'";
                    $CountCI++;
                }else{
                    $FiltroPadrao[$key] .= " OR " . $this->idx_NomeCampo($vl[0]) . " " . $vl[1] ." '" . $vl[2] . "'";
                    $CountCI++;                    
                }
            }
        }
        
        $CountCI = 0;

        foreach ($FiltroPadrao as $key => $value) {
            if($CountCI == 0){
                $FiltroPadraoCpt = "($FiltroPadrao[$key])";
                $CountCI++;
            }else{
                $FiltroPadraoCpt .= " AND ($FiltroPadrao[$key])";
                $CountCI++;
            }
        }
        if($FiltroPadraoCpt == "")
            return ""; 
        else{
            if(!$Of)
                return " WHERE " . $FiltroPadraoCpt;
            else 
                return " AND " . $FiltroPadraoCpt;
        }
    }
    
    /**
     * Recupera o nome do campo através do índice enviado pelo sistema.
     * @param int $idx
     * @return type
     */
    private function idx_NomeCampo($idx) {
        $Campos = $this->getCampos();
        
        foreach ($Campos as $key => $value) {
            if($value["Index"] == $idx){
                return $value["Field"];
            }
        }
    }
    /**
     * Converte em string os filtros informados na variável $this->Filtros.
     * @return string
     * @example path Descrição
     * [0][*][*] - 1° Campo, esta definido como filtros inseridos manualmente que serão carregador durante o processamento do script.
     * [0][1][*] - 2° Campo, Quantidade de campos que serão filtrados
     * [0][1][0] - 3º Campo, representa o index do campo o operador os caracteres de filtro e o tipo de operador AND ou OR.
     * 
     * 
     * [0][0][0] = "cpf"         -> Nome do campo
     * [0][0][1] = "="           -> Operador
     * [0][0][2] = "04953988612" -> Filtro
     * [0][0][3]  = 1            -> Logico 1 - AND / 2 OR => Funciona a partir do segundo campo, o primeiro não adianta.
     *  
     *  AND
     * 
     * [1][0][0] = "Nome"        -> Nome do campo
     * [1][0][1] = "like"        -> Operador
     * [1][0][2] = "%Alexandre%" -> Filtro
     * [1][0][3]  = 1/2          -> Logico 1 - AND / 2 OR => Funciona a partir do segundo campo, o primeiro não adianta.
     * 
     * AND ou OR -  Quem define qual o tipo de operador é a igualdade entre os campos ou o último campo do array
     * 
     * [1][0][0]  = "cpf"         -> Nome do campo
     * [1][0][1]  = "like"        -> Operador
     * [1][0][2]  = "%andre%"     -> Filtro
     * [1][0][3]  = 1/2           -> Logico 1 - AND / 2 OR
     * 
     *   
        NomeInstancia.Filtros[0 {Filtro Padrão}, 1{Filtro campo localizar}] = 
              *[
                    [
                        [1  {Nome do campo},   "like" {Operador} ,   "rf061040002292%" {qual caracter procurar}],
                        [2  {Nome do campo},   "like" {Operador} ,   "10.56.34.11%"    {qual caracter procurar},   2{Partir do segundo campo - informa que o operador usado para união com o campo anterior é o 1 AND ou 2 OR}]
                    ]
                ];
     * 
     * 
     *          [
                    [
                        [1  {Nome do campo},   "like" {Operador} ,   "rf061040002292%" {qual caracter procurar}],
                        [1  {Nome do campo},   "like" {Operador} ,   "10.56.34.11%"    {qual caracter procurar},   2{Partir do segundo campo - informa que o operador usado para união com o campo anterior é o 1 AND ou 2 OR}]
     *                  Quando os index são iguais o operador é automaticamente selecionado como OR
                    ]
                ];
     * 
         */
    private function setPreparaFiltro($Filtros) {//$this->Filtros = $this->Filtros != null ? "" : " WHERE ";
        $Chv = 0;
        $Count2 = 0;
        $W = NULL;
        
        if(is_array($Filtros)){
            $Count = 0; //Inicia o contador
            
            foreach ($Filtros as $key => $value) {
                if(($value) == "false") continue;
                foreach ($value as $Chave => $Valores) {
                        $NomeCampo = $this->idx_NomeCampo($Valores[0]);
                        if($Count == 0){
                            $StringFlt = $NomeCampo . " " .$Valores[1] . " '" . $Valores[2] . "' ";
                            $Count++;
                        }else{
                            if($Valores[3] == 1){ //Verifica se a chave ainda é a atual, caso seja atual o operador será o AND
                                $StringFlt .= " AND " . $NomeCampo . " " .$Valores[1] . " '" . $Valores[2] . "' ";
                            }else{ //Caso a chave seja outra o operador será OR
                                $StringFlt .= " OR " . $NomeCampo . " " .$Valores[1] . " '" . $Valores[2] . "' ";
                            }

                        }

                }
                
                if(($Chv != $key) && ($W != NULL)){
                    $W = "($W) AND ($StringFlt)";
                    $Chv = $key;
                }else{
                    $W = $StringFlt;
                    $StringFlt = '';
                    $Chv = $key;
                    $Count = 0;
                }

            }
            
            if(!$W) return "";
            return " WHERE (" . $W . ") ";
        }else{
            return "";
        }
        
    }
    /*
     * Método obrigatório que deverá ser utilizado após a instância da classe.
     * Esse método é case sensitive.
     */
    public function setUsuario($Usuario) {
        $this->Usuario = $Usuario;
    }
    /**
     * BANCO DE DADOS - ESQUEMA
     * TABELA LOGIN
     * CREATE TABLE `login` (
            `idLogin` int(11) NOT NULL AUTO_INCREMENT,
            `usuario` varchar(50) NOT NULL,
            `senha` varchar(100) NOT NULL,
            `tipousuario` enum('Comum','Gerente','Administrador') NOT NULL,
            `habilitado` bit(1) NOT NULL,
            `tentativa` tinyint(4) NOT NULL,
            `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`idLogin`),
            UNIQUE KEY `usuario` (`usuario`)
           ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
                * 
     * TABELA PRECISA DA TABELA LOGIN ANTES DE SUA CRIAÇÃO.
     * CREATE TABLE `privilegios` (
                `idPriv` int(11) NOT NULL AUTO_INCREMENT,
                `idLogin` int(11) NOT NULL,
                `Tabela` varchar(60) NOT NULL,
                `Priv` enum('Select','Select/Insert','Select/Insert/Update','Select/Insert/Update/Delete') NOT NULL,
                `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`idPriv`),
                KEY `FK_IDLogin` (`idLogin`),
                CONSTRAINT `FK_IDLogin` FOREIGN KEY (`idLogin`) REFERENCES `login` (`idLogin`)
               ) ENGINE=InnoDB DEFAULT CHARSET=latin1
     * 
     * @throws PDOException
     */
    public function getPrivilerioBD() {
        if($this->getVirtual()){
            $this->NomeTabela = $this->getNomeReal();
        };        
        $StringSQL = "Select login.usuario as usuario, privilegios.priv as priv from login, Privilegios Where login.idLogin=privilegios.idLogin and usuario = '$this->Usuario' and privilegios.Tabela='$this->NomeTabela'";
        $this->stringSQLExecutar($StringSQL);
        $rst = $this->ExecutarSQL();
        if($rst == false){
            throw new PDOException("Tabela de privilégios não foi encontrada.", 6002);
        }
        $Linhas = $this->getArrayResultado();
        
        return [[$Linhas[0][0],$Linhas[0][1]]];
    }
    /**
     * Busca privilégios que foram definidos no banco de dados ou manualmente.
     */
    private function obterPrivilegios() {
        if(!$this->getPrivBD()){ //Verifica se será avaliado os privilégios vindos do banco de dados ou array da tabela class
            $this->Privilegios = $this->getPrivilegios(); //Privilégios atribuídos manualmente.
        }else{
            $this->Privilegios = $this->getPrivilerioBD(); //Privilégios atribuídos pelo banco de dados.
        } 
    }
    /**
     * Verifica se o usuário, que foi definido pelo método $Class->setUsuarios($Usuario), tem privilégios para realizar a operação na tabela.
     * <br>Para que o usuário "Todos" possa ser utilizado, a variável $Privilegios da classe instânciada deverá conter esse usuário.
     * @param String $Tipo [Select | Insert | Delete | Update]
     * @return boolean
     * @throws Exception Usuário não foi definido pelo método $Class->setUsuarios($Usuario) ou não possue privilégios para a operação desejada.
     */
    private function getVerificarPrivilegios($Tipo){
        
        if(($this->Usuario != null)){
            foreach ($this->Privilegios as $Chave => $Valor) {
                if($Valor[0] == "Todos"){
                    $PRV = preg_match('/' . $Tipo . '/i', $Valor[1]);
                    if($PRV){
                        return true;
                    }else{
                        if($Tipo == "Select"){
                            throw new Exception("Usuário definido não possui privilégios nessa tabela(".md5($this->NomeTabela).") para essa operação: $Tipo", 6003);
                        }else{
                            return false;
                        }                        
                    }
                }
                if (preg_match('/^' . $this->Usuario . '$/i', $Valor[0])) {
                    $PRV = preg_match('/' . $Tipo . '/i', $Valor[1]);
                    if($PRV == true){
                        return true;
                    }else{
                        if($Tipo == "Select"){
                            throw new Exception("Usuário definido não possui privilégios nessa tabela(".md5($this->NomeTabela).") para essa operação: $Tipo", 6004);
                        }else{
                            return false;
                        }
                    }
                }
            }
            //Para evitar perguntas ao sistema a mensagem foi definida como padrão.
            throw new Exception("Usuário definido não possui privilégios nessa tabela(".md5($this->NomeTabela).") para essa operação: $Tipo", 6005);

        }else{
            throw new Exception("Nenhum usuário foi definido para que possa ser verificado o acesso.", 6006);
        }
    }
    public function setOrderBy($Order) {
        if(is_array($Order)){
            $this->OrdemBy = $Order;
        }
    }
    
    public function getOrderBy() {
        return $this->OrdemBy;
    }
    
    private function getStringOrderBy() {
        if(is_array($this->OrdemBy)){
            $NomeCampo = $this->idx_NomeCampo($this->OrdemBy[0]);
            $ORD = "ORDER BY $NomeCampo " . $this->OrdemBy[1]. " ";
            return $ORD;
        }
        return "";
    }
    /**
     * Realiza a consulta propriamente dita.
     */
    public function Select() {
        $this->obterPrivilegios();
        $this->getVerificarPrivilegios("Select");
        /**
         * Executa funções anônimas no filtro.
         */
        $Filters = $this->NormalizarFiltro(__FUNCTION__);
        $Filtros = $Filters == null ? $this->Filtros : $Filters;
        $Filtro = $this->setPreparaFiltro($Filtros);

        /**
         * Define que tipo de retorno será enviado pelo filtroPadrões, uma vez que, na existência de filtros, vindos do sistema,
         * o retorno será diferente, sendo AND caso já existe filtro e WHERE caso não exista filtro pré-existente.
         */
        $FiltrosPadroes = $Filtro === "" ? $this->FiltrosPadroes(false) : $this->FiltrosPadroes(true) ;
        $OrdemBy = $this->getStringOrderBy();
        
        $SqlCampos = $this->gerarStringCamposSQL();
        $this->TotalLinhasTabela = $this->getTotalLinhas(); //Obtém o total de linhas que será recuperado na consulta para que o delocamento ocorra de maneira correta.
        
        if(($this->getLimite() == 0) || ($this->TotalLinhasTabela < $this->getLimite())){ //Não gera nenhuma página, todos os registros são retornados
            $Limite = "";
        }else{
            $Limite = "limit " . $this->getLimite() . " offset $this->Deslocamento"; //Deslocamento ocorre em função da página.
        }
        $StringSQL = "Select $SqlCampos from $this->NomeTabela  ". 
                                                                            $Filtro  . //{Filtros vindo do sistema}
                                                                            $FiltrosPadroes .
                                                                            $OrdemBy .
                                                                            $Limite; //Páginas e deslocamentos
        $this->stringSQLExecutar($StringSQL);
        $rst = $this->ExecutarSQL();
        if($rst == false){
            $this->GerarError();
        }
        
        return true;
    }
    
    /**
     * Retorna o total de linhas existente na tabela, sem considerar o filtro da consulta. Obs.: Esse método deverá ser
     * executado antes mesmo da consulta propriamente dita Select() para não haver problemas com o resultado que é compartilhado
     * por ambos os métodos.
     * @return integer
     */
    protected function getTotalLinhas() {
        $Filters = $this->NormalizarFiltro(__FUNCTION__);
        $Filtros = $Filters == null ? $this->Filtros : $Filters;
        
        $Filtro = $this->setPreparaFiltro($Filtros);
        $FiltrosPadroes = $Filtro === "" ? $this->FiltrosPadroes(false) : $this->FiltrosPadroes(true) ;
        
        $StringSQL = "Select count(*) as TotalLinhas from $this->NomeTabela $Filtro $FiltrosPadroes"; //Páginas e deslocamentos
        $this->stringSQLExecutar($StringSQL);
        $this->ExecutarSQL();
        return $this->getArrayResultado()[0][0];
    }
    /**
     * Retorna, em forma de array, as informações das colunas da tabela. Esse método deverá ser executado
     * antes da consulta propriamente dita.
     * @return Array 
     */
    public function getShowColumns(){
        $StringSQL = "SHOW FULL COLUMNS FROM $this->NomeTabela"; //Páginas e deslocamentos
        $this->stringSQLExecutar($StringSQL);
        $this->ExecutarSQL();
        
        //$this->ShowColumns = $this->getObjectResultado();
        return $this->getArrayResultado();
    }
    /**
     * Retorna os dados da tabela em formato de array, possibilita, também, a execução de funções anônimas, caso queria
     * criar funções de conteúdo ou de campo.
     * @return array
     */
    public function getArrayDados() {
        $Dados = $this->getArrayResultado();
        $this->Jobs(__FUNCTION__, $Dados, "AfterSelect", null);
        return $Dados;
    }
    /**
     * Imprimi vardump object
     */
    public function getVarDumpObject() { //depuração
        var_dump($this->getObjectResultado());
    }
    
    /**
     * Imprimi vardump array
     */
    public function getVarDumpArray() { //depuração
        var_dump($this->getArrayResultado(), false);
    }
    /**
     * Retorna o nome da tabela que será realizada a busca dos dados.
     * @return String
     */
    public function getNomeTabela() {
        return $this->NomeTabela;
    }
    /**
     * Atribui o salto para qual página deverá ser listada. Para compatibilizar
     * favor inserir o número da página começando com 1.
     * @param integer $Pagina
     */
    public function setPagina($Pagina) {
        if($Pagina != 0){
            $this->PaginaAtual = $Pagina;
            $Salto = ($Pagina - 1) * $this->getLimite();
            $this->Deslocamento = $Salto;
        }
    }
    /**
     * Método usado para averiguar o tempo gasto com as operações do sistema
     */
    public function StartClock() {
        $this->StartClock[0] = round(microtime(true) * 1000);
        $this->StartClock[1] = date("H:i:s",time());
    }
    
    /**
     * Método usado para averiguar o tempo gasto com as operações do sistema
     */
    public function EndClock(){
        $this->EndClock[0] = round(microtime(true) * 1000);
        $this->EndClock[1] = date("H:i:s",time());
    }
    /**
     * Metodo que calcula o tempo gasto com as operações do sistema.
     * @return Array
     */
    public function getTempoTotal() {
        $HTimes[0] = $this->StartClock[0];
        $HTimes[1] = $this->StartClock[1];
        $HTimes[2] = $this->EndClock[0];
        $HTimes[3] = $this->EndClock[1];
        $HTimes[4] = $HTimes[2] - $HTimes[0];
        $HTimes[5] = $HTimes[4] / 1000 . " Segundos <->$HTimes[4] MicroSegundos";
        return $HTimes;
    }
    
    public function getInfoPaginacao() {
        $Tabela["TituloTabela"]         =  $this->getTituloTabela();
        $Tabela["TotalLinhas"]          = $this->TotalLinhasTabela;
        $Tabela["Limite"]               =  $this->getLimite();
        $Tabela["Deslocamento"]         =  $this->Deslocamento;
        $Tabela["TotalPaginaVisivel"]   =  $this->getTotalPageVisible();
        $Tabela["PaginaAtual"]          =  $this->PaginaAtual;
        $Tabela["TotaldePaginas"]       =  $this->TotaldePaginas;
        $Tabela["ModoPaginacao"]        =  $this->ModoPaginacao();
        
        return $Tabela;            

    }
    
    private function getInforCampoBD(&$Info, $Cmp) {
        foreach ($Info as $key => $value) {
            if($value[0] == $Cmp){
                return $value[1];
            }
        }
        return "";
    }
    
    /**
     * Metodo que cria o cabeçalho da tabela HTML
     * @return String
     */
    public function getInfoCampos(){
        $Cabecalho = null;
        
        if(is_array($this->TabelaCampos)){
            foreach ($this->TabelaCampos as $Chave => $Valor) {
                $Cabecalho[$Chave][0]  = $Valor["Index"];
                $Cabecalho[$Chave][1]  = $Valor["CodNome"];
                $Cabecalho[$Chave][2]  = $this->getValorPadrao($Valor["Index"]);
                $Cabecalho[$Chave][3]  = $Valor["Key"];
                $Cabecalho[$Chave][4]  = $Valor["Mask"];
                $Cabecalho[$Chave][5]  = $Valor["Editar"];
                $Cabecalho[$Chave][6]  = $Valor["Visible"];
                $Cabecalho[$Chave][7]  = $Valor["Regex"];
                $Cabecalho[$Chave][8]  = $Valor["Formulario"];
                $Cabecalho[$Chave][15] = $Valor["OrdemBY"]; //sem utlização no momento
                $Cabecalho[$Chave][16] = "Vazio"  ;
                $Cabecalho[$Chave][17] = $this->getInforCampoBD($InfoCamposBD, $Valor["Field"]); //Busca informações do campo no banco de dados; Uso futuro, esta implementado, mas não esta em uso
                $Cabecalho[$Chave][18] = $Valor["TypeConteudo"];
                $Cabecalho[$Chave][19] = $this->getDadosTBLExtrangeira($Valor["ChvExt"]);
                $Cabecalho[$Chave][20] = $Valor["Filter"];
                
                if($Valor["Key"][0] === true){
                    $this->ChavesPrimarias[] = $Valor["Index"];
                }
                
            }
            return $Cabecalho;
        }
        $Cabecalho[0] = "";
        return $Cabecalho;
    }
    /**
     * Carrega os dados da tabela estrangeira e apenas os campos informados no campo ChvExt["Tabela"]
     * @param type $Tabela
     * @param type $Campos
     */
    private function LoadCamposTableExtrangeira($Tabela, $Campos) {
        $cmp = "";
        $count = 0;

        foreach ($Campos as $key => $value) {
            if($count == 0){
                $cmp = $value;
                $count++;
            }else{
                $cmp .= ", " . $value;
            }
        }
        
        $SqTbl = "select " . $cmp . " from " . $Tabela . " limit 50";
        
        $DadosTblExt = $this->query($SqTbl, PDO::FETCH_NUM);
        $DadosTblExt = $DadosTblExt->fetchAll();
        return $DadosTblExt;
    }
    
    /**
     * Verifica se o campo ChvExt enviará os dados já carregado.
     */
    private function getDadosTBLExtrangeira(&$ChvExtrangeira) {
        if($ChvExtrangeira["TExt"] === false) return $ChvExtrangeira;
        if($ChvExtrangeira["Funcao"] === false){
            $ChvExtrangeira["DadosTblExt"] = $this->LoadCamposTableExtrangeira($ChvExtrangeira["Tabela"], $ChvExtrangeira["CamposTblExtrangeira"]);
        
            return $ChvExtrangeira;
        }else{
            return $ChvExtrangeira;
        }
    }
    
    public function getPaginacao(){
        $Celulas = NULL; $Linha = NULL; $Tabela = NULL;
        if($this->getLimite() > 0){
            $Total = $this->TotalLinhasTabela;
            $Resto = $Total % $this->getLimite();
            if($Resto > 0 ){
                $this->TotaldePaginas = ($Total - $Resto) / $this->getLimite() + 1;
            }else{
                $this->TotaldePaginas = $Total / $this->getLimite();
            }
            if($this->TotaldePaginas === 1) return "";
            
            for($i = 0; $i < $this->TotaldePaginas; $i++){
                $Celulas[$i] = $i + 1;
            }
           
            return $Celulas;
        }
        
    }

    public function getBotoes() {
        $this->getBotaoIncluir() === false ? ""   :  $Botoes[] = $this->getBotaoIncluir();
        $this->getBotaoEditar() === false ? ""    :  $Botoes[] = $this->getBotaoEditar();
        $this->getBotaoDelete() === false ? ""    :  $Botoes[] = $this->getBotaoDelete() ;
        
        return $Botoes;
    }
    
    private function getBotaoEditar() {
        $Bt = $this->getVerificarPrivilegios("Update");
        
        if($Bt){
            $Botao["Editar"] = true;
        }else{
            $Botao["Editar"] = False;
        }
        return $Botao;
    }
    
    private function getBotaoIncluir() {
        
        $Bt = $this->getVerificarPrivilegios("Insert");
        if($Bt){
            $Botao["Inserir"] = true;
        }else{
            $Botao["Inserir"] = false;
        }
        return $Botao;
    }
    /**
     * Através dos privilégios que o usuário tem na tabela, o sistema determina se os botões serão ou não visualizados.
     * @return boolean
     */
    private function getBotaoDelete() {
        $Bt = $this->getVerificarPrivilegios("Delete");
        if($Bt){
            $Botao["Delete"] = true;
        }else{
            $Botao["Delete"] = false;
        }
        return $Botao;
    }
    /**
     * Obtém os campos que foram declarados na instrução $this->getCampos() da classe que herdou o método abstrato.
     * Obs.: Esse método, getCampos(), não esta implementado pois é um método abstrato.
     * @return boolean
     */
    public function obterCampos() {
        if(!$this->getUsarCamposTabelaOriginal()){
            return $this->getCampos();
        }
        $Campos[0] = false;
        return $Campos;
    }
    
    public function getChaves() {
        return $this->ChavesPrimarias;
    }
    /**
     * Recebe do método InserirDadosTabela() um array contendo os campos e valores para a inserção dos dados na tabela.
     * $Dados = entrada: 
        [0] => array(2) (
                            [name] => (string) NomeMaquina          Variável $this->TabelaCampos Mapeado como Name
                            [value] => (string) rf061040003322
                        )
        [1] => array(2) (
                            [name] => (string) EndIP
                            [value] => (string) 10.56.33.44
    *                   )
     * @param Array $Dados
     * @return Array
     */
    private function gerarStringCamposSQLInsert($Dados) {
        $Count = 0; $Campos = ""; $Valores = "";
        $this->TabelaCampos = $this->getCampos();
        
        foreach ($Dados as $Key => $Value) {
            $IndCampo = $Value["name"];
            $ValorCampo = $Value["value"];
            if($Count == 0 ){
                foreach ($this->TabelaCampos as $K => $V) {
                    if($V["Formulario"]["Name"] == $IndCampo){
                        $Campos = $V["Field"];
                        $Values = ":f" . $V["Field"];
                        $fnomeCampo = "f" . $V["Field"];
                        $ArrayCampos[$fnomeCampo] = $ValorCampo ;
                        $Count++;
                        break;
                    }
                    $Count++;
                }
            }else{
                foreach ($this->TabelaCampos as $K => $V) {
                    if($V["Formulario"]["Name"] == $IndCampo){
                        $Campos .= ", ". $V["Field"];
                        $Values .= ", :f" . $V["Field"];
                        $fnomeCampo = "f" . $V["Field"];
                        $ArrayCampos[$fnomeCampo] = $ValorCampo ;

                        $Count++;
                        break;
                    }
                    $Count++;
                }
            }
        }
        $cmp[0] = $Campos;
        $cmp[1] = $Values;
        $cmp[2] = $ArrayCampos;
        return $cmp;
    }
    /**
     * Método para inserir dados no banco de dados usando PDO. O array, através da página WEB, chega nesse formato pelo
     * uso da instrução de serialização do jquery um formulário
     * @param Array $Dados [["name","NomeCampo"],["value","valor"]]
     * @return boolean
     * @throws PDOException
     */
    public function InserirDadosTabela($Dados) {
        /**
         * Obtém os privilégio desta tabela.
         */
        $this->obterPrivilegios();
        $this->getVerificarPrivilegios("Insert"); //Verifica se o usuário que chamou essa instrução possue privilégios de inserção.
        /**
         * Verifica, para cada campo, se o dados enviados estão de acordo com o campo.
         */
        $this->validarConteudoCampoRegex($Dados);
        
        /**
         * Executa funções anônimas.
         */
        $Saida = $this->Jobs(__FUNCTION__, $Dados, "BeforeInsert", null);
       
        $SqlCampos = $this->gerarStringCamposSQLInsert($Dados);
        
        if($this->getVirtual()){
            $this->NomeTabela = $this->getNomeReal();
        };
        
        $StringSQL = "Insert into $this->NomeTabela($SqlCampos[0]) values ($SqlCampos[1])";
        $this->stringSQLExecutar($StringSQL);
        /**
         * Ocorrendo erro a instrução retornará false, com isso basta buscar o método getError herdado da classe BDSQL_PDO
         * para obter os detalhes dos erros.
         */
        $rst = $this->ExecutarSQL($SqlCampos[2]);

        $Saida = $this->Jobs(__FUNCTION__, $Dados, "AfterInsert", $rst);

        if($rst == false){
            $this->GerarError();
        }    

        return true;
    }
    
    /**
     * Gera uma string no formato sql para PDO. O array, através da página WEB, chega nesse formato pelo
     * uso da instrução de serialização do jquery um formulário
     * @param Array $Dados
     * @return String
     */
    private function gerarStringCamposSQLEditar($Dados) {
        $Count = 0; $Campos = ""; $Valores = "";
        $this->TabelaCampos = $this->getCampos();
        
        foreach ($Dados as $Key => $Value) {
            $IndCampo = $Value["name"];
            $ValorCampo = $Value["value"];
            if($Count == 0 ){
                foreach ($this->TabelaCampos as $K => $V) {
                    if($V["Formulario"]["Name"] == $IndCampo){
                        $Campos = $V["Field"] . " = :" . $V["Field"];
                        $ArrayCampos[$V["Field"]] = $ValorCampo ;
                        $Count++;
                        break;
                    }
                    $Count++;
                }
            }else{
                foreach ($this->TabelaCampos as $K => $V) {
                    if($V["Formulario"]["Name"] == $IndCampo){
                        $Campos .= ", " .$V["Field"] . " = :" . $V["Field"];
                        $ArrayCampos[$V["Field"]] = $ValorCampo ;
                        $Count++;

                        $Count++;
                        break;
                    }
                    $Count++;
                }
            }
        }
        $cmp[0] = $Campos;
        $cmp[1] = $ArrayCampos;
        return $cmp;
    }
    
    /**
     * gera a string das chaves primárias para a cláusula WHERE SQL. O array, através da página WEB, chega nesse formato pelo
     * uso da instrução de serialização do jquery um formulário
     * @param Array $Chaves
     * @return type
     */
    private function gerarStringWhereCHPrimaria($Chaves){
        $Count =0;
        $this->TabelaCampos = $this->getCampos();

        foreach ($this->TabelaCampos as $K => $V) {
            foreach ($Chaves as $key => $value) {
                if($Count == 0){
                    if($V["Index"] == $value[0]){
                        $Campos = $V["Field"] . " = :" . $V["Field"];
                        $ArrayCampos[$V["Field"]] = $value[1] ;
                        $Count++;
                        break;
                    }                            
                }else{
                    if($V["Index"] == $value[0]){
                        $Campos .= " AND " . $V["Field"] . " = :" . $V["Field"];
                        $ArrayCampos[$V["Field"]] = $value[1] ;
                        $Count++;
                        break;
                    }                            
                }
            }
        }
        $cmp[0] = $Campos;
        $cmp[1] = $ArrayCampos;
        return $cmp;
    }
    
    /**
     * Instrução que executa o merge(junção) dos array dos campos e das chaves primárias e a chamada
     * da instrução update da SQL. O array, através da página WEB, chega nesse formato pelo
     * uso da instrução de serialização do jquery um formulário
     * @param Array $ChavesPrimarias Chaves primárias da tabela
     * @param Array $Dados Campos e os dados de atualização
     * @return boolean
     * @throws PDOException
     */
    public function AtualizarDadosTabela($ChavesPrimarias, $Dados) {
        $this->obterPrivilegios();
        $this->getVerificarPrivilegios("Update");

        //Valida o conteudo dos dados de acordo com o regex do campo.
        $this->validarConteudoCampoRegex($Dados);

        /**
         * Executa funções anônimas.
         */
        $Saida = $this->Jobs(__FUNCTION__, $Dados, "BeforeUpdate", null);

        $SqlCampos = $this->gerarStringCamposSQLEditar($Dados);
        $Where = $this->gerarStringWhereCHPrimaria($ChavesPrimarias);
        $SqlArray = array_merge($SqlCampos[1], $Where[1]);

        if($this->getVirtual()){
            $this->NomeTabela = $this->getNomeReal();
        };
        
        $StringSQL = "UPDATE $this->NomeTabela set $SqlCampos[0] where $Where[0]";
        $this->stringSQLExecutar($StringSQL);
        $rst = $this->ExecutarSQL($SqlArray);
        
        $Saida = $this->Jobs(__FUNCTION__, $Dados, "AfterUpdate", $rst);

        if($rst == false){
            $this->GerarError();
        }

        return true;
    }

    private function gerarStringWhereCHPrimariaExcluir($Chaves){
        $Count =0;

            foreach ($Chaves as $Chp => $Valor) {
                $NomeCampo = $this->idx_NomeCampo($Valor[0]);
                    if($Count == 0){

                            $Campos = $NomeCampo . " = :" . $NomeCampo;
                            $ArrayCampos[$NomeCampo] = $Valor[1] ;
                            $Count++;
                    }else{
                            $Campos .= " AND " . $NomeCampo . " = :" . $NomeCampo;
                            $ArrayCampos[$NomeCampo] = $Valor[1] ;
                    }
                    
        }
        $cmp[0] = $Campos;
        $cmp[1] = $ArrayCampos;
        return $cmp;
    }
    
    /**
     * Exclui os dados da tabela mediante as chaves enviadas.
     * @param array $ChavesPrimarias
     * @return boolean
     * @throws PDOException
     */
    public function ExcluirDadosTabela($ChavesPrimarias) {
        $this->obterPrivilegios();
        $this->getVerificarPrivilegios("Delete");
        /**
         * Executa funções anônimas.
         */
        $Saida = $this->Jobs(__FUNCTION__, $ChavesPrimarias, "BeforeDelete", null);
            
        foreach ($ChavesPrimarias as $key => $value) {
            $Where = $this->gerarStringWhereCHPrimariaExcluir($value);

            if($this->getVirtual()){
                $this->NomeTabela = $this->getNomeReal();
            };
            
            $StringSQL = "DELETE FROM $this->NomeTabela WHERE $Where[0]";
            $this->stringSQLExecutar($StringSQL);
            
            $rst = $this->ExecutarSQL($Where[1]);  
            $Saida = $this->Jobs(__FUNCTION__, $ChavesPrimarias, "LoopDelete", $rst);

            if($rst == false){
                $this->GerarError();
            }

        }
        
        $Saida = $this->Jobs(__FUNCTION__, $ChavesPrimarias, "AfterDelete", $rst);

        return true;
    }
    /**
     * Gera todos os erros conhecidos e os que não foram catalogados é gerado uma mensagem padrão
     * para verificá-los.
     * @throws Exception
     */
    private function GerarError(){
        $Numero = $this->getErros()[1];
        $Descricao = $this->getErros()[3];
        switch ($Numero) {
            case "HY093":
                throw new Exception("Inválido o número de parâmetros.");

                break;

            case 23000:
                throw new Exception("Violação de integridade - " . $Descricao);
                break;
            default:
                throw new Exception("Ocorreram erros que não foram tratador, favor verificar o arquivo ModelosTabela.php para tratá-los. - " . $Descricao);
                break;
        }
    }
}
