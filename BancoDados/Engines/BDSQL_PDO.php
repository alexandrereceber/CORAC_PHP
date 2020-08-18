<?php

if(@!include_once dirname(__DIR__) . "/../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3587;
    $ResultRequest["Erros"][2]             = "O arquivo de configuração não foi encontrado. BDSQL";
    
    echo json_encode($ResultRequest);
    exit;
};
/*
 * @Desenvolvedor: Alexandre José da Silva Marques
 * @Data: 01/06/2018
 * @Alteração: 01/06/2018
 */

/**
 * Descrição CRUD
 *
 * @author Alexadre Marques
 * 
 */
class BDSQL extends PDO{
    /**
     * Conjunto de variável que armazenam os dados de conexão com o banco de dados.
     * @var type 
     */
    private $StringBD   = null;
    private $Usuario    = null;
    private $Senha      = null;
    
    /**
     *Contém a nome da tabela que será utilizada na string PrepareSQL
     * @var type string
     */
    private $TabelaSQL  = null;

    /**
     * Variável que contém a string de busca no banco de dados
     * @var type string
     */
    private $SQLPrepare  = false;
    
    /**
     *  Variável true|false => true - A SQLPrepare foi executada; 
     *                        false - A SQLPrepare não foi executada ou o método nem foi chamado.
     * @var type bool
     */
    private $StatusExecutarSQL = false;
    /**
     * Armazena os dados da conexão PDO
     * @var ObjetoPDO 
     */
    private $Estado = null;
    /*
     * Armazena as linhas retornadas do banco de dados para uso futuro.
     */
    private $Linhas = null;
    
    private $Error = [];

    /**
     * 
     * @param string $StringBD mysql:host=localhost;dbname=test - Mysql podendo ser outros
     * @param string $Usuario - Usuário para acesso ao banco de dados
     * @param string $Senha - Senha de acesso ao banco de dados
     * @param string $Debug - Retorno completo do erro através da variável ErrorDetalhes - retorno PDOException
     */
    public function __construct() {
        
        $this->StringBD = AcessoBancoDados::get_string_conexao();
        $this->Usuario = AcessoBancoDados::get_Usuario();
        $this->Senha = AcessoBancoDados::get_Senha();
        parent::__construct($this->StringBD, $this->Usuario, $this->Senha);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    /**
     * Retorna os erros ocorridos pela função ExecutarSQL
     * @return Array exception
     */
    public function getErros() {
        return $this->Error;
    }
    
    /**
     * Variável que contém a string SQL
     * @param type $StringSQL
     */
    protected function stringSQLExecutar($StringSQL){
        $this->SQLPrepare = $StringSQL;
    }

    /**
     * Método que retorna o total de linhas atingidas pelos métodos DML(Insert, Update, Delete)
     * @return inteiro
     * /
     */
    protected function GetLinhasAtingidas() {
       return $this->Estado->rowCount();
    }
    
    /**
     * Retorno o último ID inserido na tabela.
     * @return type
     */
    protected function GetUltimoID() {
        return $this->lastInsertId();
    }
    /**
     * Executa a SQL da variável $this->SQLPrepare. Também obtém o total de linhas afetadas
     * pela consulta.
     * 
     * @throws PDOException
     */
    protected function ExecutarSQL($Array = null){
 
        if($this->SQLPrepare == false) throw new PDOException("A variável SQLPrepare não foi preparada.");
        
        try {
            $this->Estado = $this->prepare($this->SQLPrepare);
            $this->StatusExecutarSQL = $this->Estado->execute($Array);
        } catch (Exception $exc) {
            $this->Error[0] = true;
            $this->Error[1] = $exc->getCode();
            $this->Error[2] = $exc->getFile();
            $this->Error[3] = $exc->getMessage();
            $this->Error[4] = $exc->getTraceAsString();
        }
        
        /**
         * Apesar do erro ocorrer o mesmo não é lançado para outros métodos, ele é tratado dentro deste método
         * que armazena os dados dos erros.
         * Essa instrução apenas retorna se foi concluída ou não a instrução SQL, pois o erro poderá ser resgatado pela função
         * que chamou esse método através do método getErro().
         */
        if($this->StatusExecutarSQL == false) return false; else return true;
 
    }
    /**
     * Executa a SQL da variável $this->SQLPrepare. Também obtém o total de linhas afetadas
     * pela consulta.
     * 
     * @throws PDOException
     */
    protected function ExecutarProcedureSQL($Array = null){
 
        if($this->SQLPrepare == false) throw new PDOException("A variável SQLPrepare não foi preparada.");
        
        try {
            $this->StatusExecutarSQL = $this->query($this->SQLPrepare);
        } catch (Exception $exc) {
            $this->Error[0] = true;
            $this->Error[1] = $exc->getCode();
            $this->Error[2] = $exc->getFile();
            $this->Error[3] = $exc->getMessage();
            $this->Error[4] = $exc->getTraceAsString();
        }
        
        /**
         * Apesar do erro ocorrer o mesmo não é lançado para outros métodos, ele é tratado dentro deste método
         * que armazena os dados dos erros.
         * Essa instrução apenas retorna se foi concluída ou não a instrução SQL, pois o erro poderá ser resgatado pela função
         * que chamou esse método através do método getErro().
         */
        if($this->StatusExecutarSQL == false) return false; else return true;
 
    }
    /**
     * Retorna o conjunto de tuplas que a consulta obteve em forma de array.
     * Usando esse método os outros métodos que usam o método fetch não serão executado, pois o cursor da variável estará setado para o final.
     * @return Array
     */
    protected function getObjectResultado() {
        $this->Linhas = $this->Estado->fetchObject();
        return $this->Linhas;
    }
    /**
     * Retorna o conjunto de tuplas que a consulta obteve em forma de array.
     * Usando esse método os outros métodos que usam o método fetch não serão executado, pois o cursor da variável estará setado para o final.
     * @return Array
     */
    protected function getArrayResultadoProcedure() {
        $this->Linhas = $this->StatusExecutarSQL->fetch(PDO::FETCH_OBJ);
        return $this->Linhas;
    }
    
    /**
     * Retorna o conjunto de tuplas que a consulta obteve em forma de array.
     * Usando esse método os outros métodos que usam o método fetch não serão executado, pois o cursor da variável estará setado para o final.
     * @return Array
     */
    protected function getArrayResultado() {
        $this->Linhas = $this->Estado->fetchAll(PDO::FETCH_NUM);
        return $this->Linhas;
    }
/**
 * Recebe o nome da tabela que será utilizado para a busca dos dados
 * @param type $Tabela
 */
    public function setTabela($Tabela){
        $this->TabelaSQL = $Tabela;
    }
    
}
