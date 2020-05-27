<?php

/*
 * Classe que busca informações no agente desktop instalado e instanciano nos computadores
 */

/**
 * Descrição de CMD
 *
 * @author Alexandre José da Silva Marques
 */
class Connect_AA {
    
    private $Comando = null;
    private $Requisicao = null;
    private $Servidor = null;
    private $Porta = null;
    private $Protocol = null;
    private $Folder = null;
    private $Key = null;
    const WEBSOCKET = "ws://";

    /**
     * 
     * @param type $Srv -> Endereço IP ou nome dns para o agente autônomo
     * @param type $Protocolo -> Protocolo de comunicação com o agente que pode ser http ou https ou etc..
     * @param type $Pasta -> Endereço de URL para busca
     * @param type $CMD - > Comando que será executado no agente autônomo
     * @throws Exception
     */
    public function __construct($Srv, $porta ,$Protocolo = "http", $Pasta, $Chave = null) {
        if($Srv == null || $Srv == ""){
            throw new Exception("Não foi definido nenhum endereço de agente autônomo para estabelecer conexão.", 34000);
        }else{
            $this->Servidor = $Srv;
        }
        
        if($porta == null|| $porta == ""){
            throw new Exception("Não foi definido nenhuma porta para estabelecer conexão com o agente autônomo.", 34001);
        }else{
            $this->Porta = $porta;
        }
        
        if($Pasta == null|| $Pasta == ""){
            throw new Exception("Não foi encontrado nenhuma definição para uma pasta no servidor.", 34002);
        }else{
            $this->Folder = $Pasta;
        }
      
        if($Protocolo == null|| $Protocolo == ""){
            throw new Exception("Não foi encontrado nenhuma definição de protocolo para o agente autônomo.", 34003);
        }else{
            $this->Protocol = $Protocolo;
        }
        
        $this->Key = $Chave;
        
    }
    
    private function EnviarPacote($Pacote) {
        
        $SubPacote = addslashes(json_encode($Pacote));
        
        $Pacote_Base = ["Pacote" => $Pacote["Pacote"], "Remetente" => 0, "Conteudo" => $SubPacote];
        $postdata = stripcslashes(json_encode($Pacote_Base));

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 1200
            )
        );

        $context = stream_context_create($opts);
        $Resultado_CORAC_Desktop =  (file_get_contents("$this->Protocol://$this->Servidor:$this->Porta/$this->Folder", false, $context));
        
        if($Resultado_CORAC_Desktop == "" || $Resultado_CORAC_Desktop == false) throw new Exception("O agente autônomo não respondeu!", 34304);
        
        /**
         * Remover a conversão para json -> $Pacote_Base->{'Conteudo'}
         */
        $Pacote_Base = json_decode($Resultado_CORAC_Desktop);
        $Resultado_CORAC_Desktop = json_decode($Pacote_Base->{'Conteudo'}); //Remove o pacote base

        if($Resultado_CORAC_Desktop->{"Pacote"} == 8) {
            $Mensagem = $Resultado_CORAC_Desktop->{"Mensagem"};
            throw new Exception($Mensagem, 34305);
        }
        return $Resultado_CORAC_Desktop->{"Resposta"};
    }
    
    /**
     * Envia um pedido de confirmação para saber se a unidade autônoma esta ativa.
     * @return type
     */
    public function Ping_AgenteAutonomo() {
        $Pacote_PingReplay = ["Pacote" => 1,"Validado" => false, "TempoInicio" => time()];
        return $this->EnviarPacote($Pacote_PingReplay);

    }
    /**
     * Envia um comando para o agente.
     * @param type $CMD
     * @return type
     * @throws Exception
     */
    public function Executar_CMD($CMD) {
                
        if($CMD == null|| $CMD == ""){
            throw new Exception("Não foi encontrado nenhum comando.", 34001);
        }else{
            $this->Comando = $CMD;
        }
        
        /**
         * Pacote: Tipo de pacote que será entregue ao agente autônomo.
         * Comando: Comando em powershell ou personalizado, dentro do CORAC desktop, que será executado.
         * Resposta: Campo que conterá a resposta do AA.
         * Formato: O formato de saída na resposta. Ex: json, xml, http e outros.
         * Chave: Identificador do usuário que está logado, o AA chegará se o usuário esta validado, bloqueado ou outro status.
         */
        $Pacote_Comando = ["Pacote" => 3,"Comando" => $this->Comando, "Resposta" => null, "Formato" => 1, "Chave" => $this->Key];
        $Pacote_Recebido_CORAC_Desk = $this->EnviarPacote($Pacote_Comando);

        $Normalizar = $this->Normalizar_Executar_CMD($this->Comando, $Pacote_Recebido_CORAC_Desk);
        
        return $Normalizar;
    }
    
    /**
     * Método que, caso precise, modifica o conteúdo da resposta do AA antes de entregá-lo à página requisitante.
     * @param type $CMD
     * @param type $Dados
     * @return type
     */
    protected function Normalizar_Executar_CMD($CMD, &$Dados){
        $CMD = preg_split("/ /", $CMD)[0];
        
        switch ($Dados) {
            case "":


                break;

            default:
                break;
        }
        
        return $Dados;
    }
        protected function Normalizar_AcessoRemoto($Requisicao, &$Dados){
            $Dados = json_decode($Dados);
            $Dados->AA_ServerCORAC = "ws://$this->Servidor:$this->Porta/CORAC/AcessoRemoto/";
            $Dados = json_encode($Dados);

        return $Dados;
    }
        public function AcessoRemoto($Requisicao) {
                
        if($Requisicao == null|| $Requisicao == ""){
            throw new Exception("Não foi encontrado nenhum pedido de acesso.", 34001);
        }else{
            $this->Requisicao = $Requisicao;
        }
        
        /**
         * Pacote: Tipo de pacote que será entregue ao agente autônomo.
         * Comando: Comando em powershell ou personalizado, dentro do CORAC desktop, que será executado.
         * Resposta: Campo que conterá a resposta do AA.
         * Formato: O formato de saída na resposta. Ex: json, xml, http e outros.
         * Chave: Identificador do usuário que está logado, o AA chegará se o usuário esta validado, bloqueado ou outro status.
         */
        $Pacote_AcessoRemoto = ["Pacote" => 12,"Tipo" => $this->Requisicao, "Resposta" => null, "Formato" => 1, "Mecanismo" => 0 ,"Chave" => $this->Key];
        $Pacote_Recebido_CORAC_Desk = $this->EnviarPacote($Pacote_AcessoRemoto);
        
        $Normalizar = $this->Normalizar_AcessoRemoto($this->Requisicao, $Pacote_Recebido_CORAC_Desk);
        
        return $Normalizar;
    }
}
