<?php

/*
 * Classe que busca informações no agente desktop instalado e instanciano nos computadores
 */

/**
 * Descrição de CMD
 *
 * @author Alexandre José da Silva Marques
 */
class CMD {
    
    private $Comando = null;
    private $Servidor = null;
    private $Porta = null;
    private $Protocol = null;
    private $Folder = null;
    private $Key = null;
    /**
     * 
     * @param type $Srv -> Endereço IP ou nome dns para o agente autônomo
     * @param type $Protocolo -> Protocolo de comunicação com o agente que pode ser http ou https ou etc..
     * @param type $Pasta -> Endereço de URL para busca
     * @param type $CMD - > Comando que será executado no agente autônomo
     * @throws Exception
     */
    public function __construct($Srv, $porta ,$Protocolo = "http", $Pasta , $Chave = null) {
        if($Srv == null || $Srv == ""){
            throw new Exception("Não foi definido nenhum endereço de agente autônomo para estabelecer conexão.", 34000);
        }else{
            $this->Servidor = $Srv;
        }
        
        if($porta == null|| $porta == ""){
            throw new Exception("Não foi definido nenhuma porta para estabelecer conexão com o agente autônomo.", 34000);
        }else{
            $this->Porta = $porta;
        }
        
        if($Pasta == null|| $Pasta == ""){
            throw new Exception("Não foi encontrado nenhuma definição para uma pasta no servidor.", 34002);
        }else{
            $this->Folder = $Pasta;
        }
      
        if($Protocolo == null|| $Protocolo == ""){
            throw new Exception("Não foi encontrado nenhuma definição de protocolo para o agente autônomo.", 34002);
        }else{
            $this->Protocol = $Protocolo;
        }
        
        $this->Key = $sendChave;
        
    }
    
    private function EnviarPacote($Pacote) {
        
        $SubPacote = addslashes(json_encode($Pacote));
        
        $Pacote_Base = ["Pacote" => 1, "Remetente" => 0, "Conteudo" => $SubPacote];
        $postdata = stripcslashes(json_encode($Pacote_Base));

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context = stream_context_create($opts);
        $result =  (file_get_contents("$this->Protocol://$this->Servidor:$this->Porta/$this->Folder", false, $context));
        
        if($result == "") throw new Exception("O agente autônomo não respondeu!");
        
        $Pacote_Base = json_decode($result);
        
        $JSON_Result = json_decode($Pacote_Base->{'Conteudo'});
        return $JSON_Result;
    }
    public function Ping_AgenteAutonomo() {
        $Pacote_PingReplay = ["Pacote" => 1,"Validado" => false, "TempoInicio" => time()];
        return $this->EnviarPacote($Pacote_PingReplay);

    }
    
    public function Executar_CMD($CMD) {
                
        if($CMD == null|| $CMD == ""){
            throw new Exception("Não foi encontrado nenhum comando.", 34001);
        }else{
            $this->Comando = $CMD;
        }
        $Pacote_Comando = ["Pacote" => 3,"Comando" => false, "Resposta" => null, "Formato" => 1, "Chave" => $this->Key];
        return $this->EnviarPacote($Pacote_Comando);
    }
}
