<?php

/*
 * Controla todas as informações sobre sessão.
 */
interface Dencry {
    public function Encriptar();
    public function DEcriptar();
}

/**
 * Classe que trata da sessão de cada usuário.
 * @author 04953988612 - Alexandre José da Silva Marques
 */
class SessaoDados{
    
    private $Dados_Sessao = null, $Chaves = NULL;
    
    public function __construct() {
        
    }
    private function validarChave($chv){
        if(!isset($chv)) throw new Exception("Você não está autenticado, favor entrar em contato com o administrador.",5000);
    }
    
    public function setChaves($chv) {
        $this->validarChave($chv);
        $this->Chaves = json_decode($this->DEcriptar($chv));
    }
    
    public function startSessao() {
        
        session_save_path(__DIR__ . "/Sessoes");
        
        if($CheckFolder = file_exists(__DIR__ . "/Sessoes") == false){
            throw new Exception("A pasta de sessões não foi encontrada, favor entrar em contato com o administrador.",5001);
        }
        
        @session_id($this->getID());
        if(@session_start()){
            /**
             * Transforma em um objeto o conteúdo da variável $_session ID.
             */
            $this->Dados_Sessao = json_decode($_SESSION[$this->getID()]);
            
            if($this->Dados_Sessao == null) return false;
            
            return true;
        }else{
            return false;
        }
    }
    public function getUsernameChave() {
        return $this->Chaves->Username;
    }

    public function getPasswordChave() {
        return $this->Chaves->Password;
    }
    
    public function getUsernameSession() {
        return $this->Dados_Sessao->Username;
    }

    public function getPasswordSession() {
        return $this->Dados_Sessao->Password;
    }

    public function getTimeSession() {
        return $this->Dados_Sessao->Tempo;
    }
    
    public function getTimeChave() {
        return $this->Chaves->Tempo;
    }
    
    public function getID() {
        return $this->Chaves->ID;
    }

    public function DestruirSessao() {
        @session_destroy();
    }
    public function Commitar() {
        session_commit();
    }

    public function DEcriptar($chv) {
        return base64_decode($chv);
    }

    public function Encriptar() {
        
    }
    /**
     * Verifica se a sessão criada no servidor tem o mesmo usuário e senha da chave enviada.
     * @return boolean
     */
    public function Validar_UserName() {
        
        if($this->getUsernameChave() === $this->getUsernameSession() && $this->getPasswordSession() === $this->getPasswordChave()){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Verifica se a sessão criada tem a mesma chave de tempo que a da sessão criada no servidor.
     * @return boolean
     */
    public function ValidarTime() {
        if($this->getTimeChave() == $this->getTimeSession()){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Verifica se a sessão do usuário esta dentro do tempo configurado na classe ConfigSystema.
     * @return boolean
     */
    public function ValidarTempoSessao() {
        $TTotal = $this->getTimeSession() + (60 * ConfigSystema::get_TempoSessao());
        $TAtual = time();
        
        if( time() < $TTotal ){
            return true;
        }else{
            return false;
        }
    }

}
