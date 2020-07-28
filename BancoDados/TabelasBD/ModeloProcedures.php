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
abstract class ModeloProcedures extends BDSQL{

    /**
     * Nome da tabela no banco de dados
     * @var type String
     */
    protected $NomeProcedures = null;

    /** 
     * 
     * Variável que contém o nome dos campos que serão visualizados no banco de dados.
     * @var Array Contém os campos da tabela.
     */
    private $Saidas = false;
    private $Entradas = false;

    
    /*
     * Usuário que esta tentando acesso à tabela
     */
    private $Usuario = null;
    
    private $StartClock = [];
    private $EndClock = [];
    private $Privilegios = [];
    /**
     * @abstract
     */
    abstract function setNomeProcedure(); //Método para recuperar o nome da classe que é o mesmo da tabela no banco de dados.
    /**
     * Retorna, em array, os usuários que poderão realizar operações nessa tabela.
     */
    abstract public function getPrivilegios();

    /**
     * Habilita a tabela em modo Real ou View se for true o sistema irá obter o nome da tabela real pelo método getNomeReal()
     */
    abstract public function getVirtual();
    /**
     * Informa qual o nome da tabela real que representa a tabela view;
     */
    abstract public function getNomeReal();
    /**
     * Obtém as saídas que serão geradas pela store procedures;
     */
    abstract public function getSaidas();
    /**
     * Método que habilita ao sistema buscar as informações de privilégios dentro da base de dados.
     * O padrão é um array, em cada classe, contendo os privilégios.
     * return true; return false;
     */
    abstract public function getPrivBD();

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
        $this->setNomeProcedure();
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
        `Procedures` varchar(60) NOT NULL,
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
            $this->NomeProcedures = $this->getNomeReal();
        };        
        $StringSQL = "Select login.usuario as usuario, privilegios.priv as priv from login, Privilegios Where login.idLogin=privilegios.idLogin and usuario = '$this->Usuario' and (privilegios.Tabela='$this->NomeTabela' or privilegios.Procedures='$this->NomeProcedures')";
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
    public function setEntrada($e) {
        $this->Entradas = $e;
    }
    
    public function setSaidas($s) {
        $this->Saidas = $s;
    }
    /**
     * Realiza a consulta propriamente dita.
     */
    public function Execute() {
        $StringSQL = null;
        
        $this->obterPrivilegios();
        $this->getVerificarPrivilegios("Execute");

        /**
         * Executa funções anianhadas dentro da função Jobs.
         */
        $this->Jobs(__FUNCTION__, $Dados, "BeforeExecute", null);
        if($this->Entradas == false){
            $StringSQL = "CALL " . $this->getNomeProcedure() ." (". $this->getSaidas() .")"; //Páginas e deslocamentos
        }else{
            $StringSQL = "CALL " . $this->getNomeProcedure() ." ($this->Entradas, ". $this->getSaidas() .")"; //Páginas e deslocamentos
           
        }
        
        $this->stringSQLExecutar($StringSQL);
        $rst = $this->ExecutarProcedureSQL();
        if($rst == false){
            $this->GerarError();
        }
        
        $StringSQL = "SELECT ". $this->getSaidas();
        
        $this->stringSQLExecutar($StringSQL);
        $rst = $this->ExecutarProcedureSQL();
        if($rst == false){
            $this->GerarError();
        }
        
        return true;
    }
    public function getInfoCampos(){
        $Saidas = preg_replace("/@/", "",$this->getSaidas());
        $Exist = preg_match("/,/", $Saidas);
        if($Exist)
            $R = preg_split ("/,/", $Saidas);
        else $R[0] = $Saidas;
        
        return $R;
    }
    
    /**
     * Retorna os dados da tabela em formato de array, possibilita, também, a execução de funções anônimas, caso queria
     * criar funções de conteúdo ou de campo.
     * @return array
     */
    public function getArrayDados() {
        $Dados = $this->getArrayResultadoProcedure();
        $this->Jobs(__FUNCTION__, $Dados, "AfterExecute", null);
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
    public function getNomeProcedure() {
        return $this->NomeProcedures;
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
    
    public function getChaves() {
        return $this->ChavesPrimarias;
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
