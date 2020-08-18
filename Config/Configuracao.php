<?php

/*
 * Classe que contém todas as variáveis de configuração do sistema de forma estática.
 * Ela contém informações sobre a conexão com a base de dados como usuário e senha, se haverá sessão, cálculo do tempo 
 * de processamento,  classe de conversão de nome das tabelas, operações e classe de tipos de usuários.
 */

/**
 * 
 */
class ConfigSystema {
    /**
     * Variável que armazena o tempo do início do processamento das informações.
     * @var int StartClock;
     * 
     * Variável que armazena o tempo final do processmanto.
     * @var int EndClock;
     */
    private static 
            $StartClock = [], 
            $EndClock = [],
            $vrf_Password = true, //Validar Senha no sistema
            $vrf_Habilitado = true, //Habilita a verificação de usuário esta habilitado no sistema.
            $vrf_Tentativas = true, //Habilita a verificação do número de tentativas de acesso antes que a senha seja bloqueada.
            $Tentativas = 5, //Informa o total de tentativas que serão aceitas antes de bloquear o usuário.
            $vrf_Dispositivo = false, // Verificar qual dispositivo o sistema esta logando
            $Dispositivos = [ //Tipos de dispositivos que são liberado no sistema, essa lista somente será utilizada, caso, 
                              //a variável $vrf_Dispositivo estive habilitada.
                                "pc",
                                "Movel",
                                "OutSystems"
                            ],
            $Email = true,
            $Mensagem = true;
    
    
    /**
     * Retorna o caminho da pasta "BancoDados" dentro da estrutura de diretório atual.
     * @return type caminho do diretório BancoDados
     * ex.: "P:\htdocs\CORAC\BancoDados"
     */
    public static function get_Path_Systema(){
        return dirname(__DIR__);
    }
    
    /**
     * Obtém o endereço URL do sistema atual.
     * @return string;
     */
    public static function getHttp_Systema(){
        $Servidor = "/CORAC/";
        return $Servidor;
    }
    
    /**
     * Informa ao sistema que tudo será baseado em perfil de usuário.
     * O sistema entrará no modo de Sessão para cada usuário logado.
     * @return boolean
     */
    public static function get_Sessao() {
        return true;
    }
    /**
     * atribui o tempo máximo de cada sessão sem modificações. Passado esse tempo será efetuado o logoff.
     * @return int
     */
    public static function get_TempoSessao() {
        return 60;
    }
    /**
     * Marca o início do processamento.
     */
    public static function getStartTimeTotal() {
        self::$StartClock[0] = round(microtime(true) * 1000);
        self::$StartClock[1] = date("H:i:s",time());
    }
    /**
     * Marca o fim do processamento.
     */
    public static function getEndTimeTotal(){
        self::$EndClock[0] = round(microtime(true) * 1000);
        self::$EndClock[1] = date("H:i:s",time());
    }
    /**
     * Calcula o tempo total gasto com o processamento.
     * @return string
     */
    public static function getTimeTotal() {
        $HTimes[0] = self::$StartClock[0];
        $HTimes[1] = self::$StartClock[1];
        $HTimes[2] = self::$EndClock[0];
        $HTimes[3] = self::$EndClock[1];
        $HTimes[4] = $HTimes[2] - $HTimes[0];
        $HTimes[5] = $HTimes[4] / 1000 . " Segundos <->$HTimes[4] MicroSegundos";
        return $HTimes;
    } 
    
    /**
     * Informa o local onde serão armazenados os arquivos que foram enviados pelo usuário via upload.
     * @param type $type
     * @return string
     */
    public static function getStoreFiles($type) {
        $Local["DestinoHD"] = self::get_Path_Systema() . "/Imagens";
        $Local["DestinoHTML"] = self::getHttp_Systema() . "/Imagens";
        
        return $Local[$type];
    }
    /**
     * Configura o sistema a validar obrigatoriamente usuário e senha no sistema. Caso seja false, o sistema irá validar
     * somente o nome do usuário sem necessidade de senha.
     * @return bool
     */
    public static function getValidarSenha(){
        return self::$vrf_Password;
    }
    /**
     * Cofigura o sistema a verificar se o usuário esta ou não habilitado, essa habilitação deverá ocorrer manualmente.
     * @return bool
     */
    public static function getValidarHabilitacao(){
        return self::$vrf_Habilitado;
    }
    /**
     * Retorna o total de tentativas de acesso ao sistema, antes do usuário ser bloqueado.
     * @return int
     */
    public static function  getTentativasTotal(){
        return self::$Tentativas;
    }

    /**
     * Cofigura o sistema a verificar se o número de tentativas foram excedidas, essa habilitação deverá ocorrer manualmente.
     * @return bool
     */
    public static function getValidarTentativas(){
        return self::$vrf_Tentativas;
    }
    /**
     * Configura o sistema a verificar o tipo de dispositivo que esta requisitando os pedidos.
     * @return bool
     */
    public static function getValidarDispositivo(){
        return self::$vrf_Dispositivo;
    }
    /**
     * Lista dos dispostivos autorizados a usar o sistema.
     * @param Array $Disp
     * @return boolean
     */
    public static function getDispositivos($Disp) {
        foreach (self::$Dispositivos as $Chv => $Valor) {
            if($Valor === $Disp){
                return true;
            }
        }
        return false;
    }
    /**
     * Cofigura o sistema, após o cadastro do usuário, a enviá-lo um email de confirmação.
     * Isso se a opção $vrf_Habilitado estiver habilitada, caso contrário, não será enviado email de confirmação.
     * @return boolean
     */
    public static function getEnviarEmail(){
        return self::$Email;
    }
    /**
     * Configura o sistema a enviar uma mensagem de confirmação ao usuário . Não esta implementado ainda.
     * @return boolena
     */
    public static function getEnviarMensagem(){
        return self::$Mensagem;
    }
}

/**
 * Classe referentes ao acesso ao banco de dados
 *
 * @author Alexandre
 */
class AcessoBancoDados {
    private static $EngineSQL = "mysql"; //Banco de dados MYSQL|PostgreSQL|ORACLE
    private static $Host = "localhost";
    private static $NomeBancoDados = "corac";
    private static $Usuario = "root";
    private static $Senha = "Al$#2810";
    private static $UTF = "utf8";

    /**
     * Obtém o nome do banco de dados que será utilizado dentro do sistema.
     * @return string
     */
    public static function get_BaseDados() {
        return self::$NomeBancoDados;
    }
    
    /**
     * Retorna a string de conexão que será utilizada pelo PDO.
     * @return string
     */
    public static function get_string_conexao(){
        return self::$EngineSQL . ":host=" . self::$Host . ";dbname=" . self::$NomeBancoDados . ";charset=" . self::$UTF ;
    }
    
    public static function get_Usuario(){
        return self::$Usuario;
    }
    
    public static function get_Senha(){
        return self::$Senha;
    }
}

class TabelaBancoDadosMD5{
    /**
     * Contém o nome das tabela e se possuem sessão ou não para visualizá-las.
     * @var array Nome das tabela mapeadas no sistema 
     */
    private static $Tabelas = [
                                ["bb22afd6fd3058670dbdf0bcc064ddde",["computadores", true]],
                                ["e78169c2553f6f5abe6e35fe042b792a",["vagentesautonomos", false]],
                                ["df6f026ac09d686436e9c5333c32503f",["TipoEquipamentos_VCplusplus", false]],
                                ["334644edbd3aecbe746b32f4f2e8e5fb",["computadores", false]],
                                ["5ca5579ec4bd2e5ca5d9608be68ae733",["scriptsbdcorac", true]],

                            ];
    
    /**
     * Converte a string MD5 para o nome real da tabela.
     * @param type $Tabela
     * @return boolean | Nome da tabela em array
     */
    public static function getMD5ForTabela($Tabela) {
        foreach (self::$Tabelas as $Chv => $Valor) {
            if($Valor[0] === $Tabela){
                return $Valor[1][0];
            }
        }
        return false;
    }
    
    /**
     * Através do nome da tabela obtém-se seu respectivo hash.
     * @param string $Tabela
     * @return boolean
     */
    public static function getTabelaForMD5($Tabela) {
        
        foreach (self::$Tabelas[0] as $Chv => $Vlr) {
            if($Vlr == $Tabela){
                return $Chv;
            }
        }
        
        return false;
        
    }
    
    /**
     * Verifica se a tabela poderá ser visualizada sem um sessão definida.
     * @param string $Tabela
     * @return boolean
     */
    public static function getTabelaSessao($Tabela) {
        /**
         * Caso a tabela não esteja no array retorne true e existindo no arry retorna o valor de true ou false.
         */
        foreach (self::$Tabelas as $Chv => $Valor) {
            if($Valor[0] === $Tabela){
                return $Valor[1][1];
            }
        }
        return true;
    }
}

class ProcedureBancoDadosMD5{
    /**
     * Contém o nome das tabela e se possuem sessão ou não para visualizá-las.
     * @var array Nome das tabela mapeadas no sistema 
     */
    private static $Procedures = [
                                ["bb22afd6fd3058670dbdf0bcc064ddde",["Teste", false]],
                                ["3a7cbd417dde3e4e828381014333f9bd",["Contagem", false]]

                            ];
    
    /**
     * Converte a string MD5 para o nome real da tabela.
     * @param type $Tabela
     * @return boolean | Nome da tabela em array
     */
    public static function getMD5ForProcedures($Procedure) {
        foreach (self::$Procedures as $Chv => $Valor) {
            if($Valor[0] === $Procedure){
                return $Valor[1][0];
            }
        }
        return false;
    }
    
    /**
     * Através do nome da tabela obtém-se seu respectivo hash.
     * @param string $Tabela
     * @return boolean
     */
    public static function getProcedureForMD5($Procedure) {
        
        foreach (self::$Procedures[0] as $Chv => $Vlr) {
            if($Vlr == $Procedure){
                return $Chv;
            }
        }
        
        return false;
        
    }
    
    /**
     * Verifica se a tabela poderá ser visualizada sem um sessão definida.
     * @param string $Tabela
     * @return boolean
     */
    public static function getProcedureSessao($Procedure) {
        /**
         * Caso a tabela não esteja no array retorne true e existindo no arry retorna o valor de true ou false.
         */
        foreach (self::$Procedures as $Chv => $Valor) {
            if($Valor[0] === $Procedure){
                return $Valor[1][1];
            }
        }
        return true;
    }
}

class OperacaoTable{
    private static $Operacao = [
                                ["ab58b01839a6d92154c615db22ea4b8f","Select"],
                                ["5a59ffc82a16fc2b17daa935c1aed3e9","Inserir"],
                                ["1570ef32c1a283e79add799228203571","Delete"],
                                ["1b24931707c03902dad1ae4b42266fd6","Update"],
                                ["2a2dc21af693c43131fe9dfd23277bd6","LoadPage"],
                                ["0319b3d5ecffc67e6cdb9a41bddedff7","UploadsFiles"],
                            ];
    
    /**
     * Busca o nome da operação referente ao MD5 enviado pelo cliente.
     * @param type $OP
     * @return boolean | Operação
     */
    public static function getMD5ForOperacao($OP) {
        foreach (self::$Operacao as $Chv => $Valor) {
            if($Valor[0] === $OP){
                return $Valor[1];
            }
        }
        return false;
    }
    
    /**
     * Retorna o MD5 de uma determinada operação.
     * @param string $OP
     * @return boolean
     */
    public static function getOperacaroForMD5($OP) {
        
        foreach (self::$Operacao[0] as $Chv => $Vlr) {
            if($Vlr == $OP){
                return $Chv;
            }
        }
        
        return false;
        
    }
}

/**
 * Classe utilizada em páginas dos tipo de usuários.
 */
class AmbienteCall {
    private static $TypeUser = NULL, $CallPage = NULL, $Call = false;
    
    public static function setTypeUser($type) {
        self::$TypeUser = $type;
    }
    
    public static function getTypeUser() {
        return self::$TypeUser;
    }
    
    public static function setPageCall($page) {
        self::$CallPage = $page;
    }

    public static function getPageCall() {
        return self::$CallPage;
    }
    
    public static function setCall($call) {
        self::$Call = $call;
    }

    public static function getCall() {
        return self::$Call;
    }
    
    
}

/**
 * Classe utilizada para enviar comandos e receber o resultaado.
 */
class ConfigPowershell {
    private static $Protocolo = "http", $Servidor = "192.168.15.250", $Porta = 8081, $Pasta = "CORAC/SYNCPCT/";
    
    public static function getProtocolo() {
        return self::$Protocolo;
    }
    /**
     * Retorna o nome do computador servidor, que roda o desktop CORAC, para enviar os comandos.
     * @return string
     */
    public static function getServidor() {
        return self::$Servidor;
    }

    public static function setServidor($Server) {
        
        self::$Servidor = gethostbyname($Server);
    }
    public static function getPasta() {
        return self::$Pasta;
    }
    
    public static function getPorta() {
        return self::$Porta;
    } 
}

/**
 * Classe utilizada para enviar comandos e receber o resultaado.
 */
class ConfigAcessoRemoto_Config {
    private static $Protocolo = "http", $Servidor = "192.168.15.250", $Porta = 8082, $Pasta = "CORAC/AA_AcessoRemoto_SYN/";
    
    public static function getProtocolo() {
        return self::$Protocolo;
    }
    /**
     * Retorna o nome do computador servidor, que roda o desktop CORAC, para enviar os comandos.
     * @return string
     */
    public static function getServidor() {
        return self::$Servidor;
    }

    public static function setServidor($Server) {
        
        self::$Servidor = gethostbyname($Server);
    }
    public static function getPasta() {
        return self::$Pasta;
    }
    
    public static function getPorta() {
        return self::$Porta;
    } 
}