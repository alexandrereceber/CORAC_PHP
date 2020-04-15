<?php
session_cache_expire(600);

if(!@include_once ConfigSystema::get_Path_Systema() . '/uploadsFiles/phpUpfiles/TratarFiles.php'){
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3300;
    $ResultRequest["Erros"][2]             = "Error include. uploadsFiles";

    echo json_encode($ResultRequest); 
    exit;
}
try{
    /**
     * Verifica se existe uma sessão ativa ou não
     */
    $Session = ConfigSystema::get_Sessao();
    /**
     * Caso a sessão esteja ativada, será buscado o nome de usuário logado no sistema para gravações em 
     * pastas separadas.
     */
    $User = $Session == true ? $SD->getUsernameChave() : false ;
    /**
     * Busca o caminho onde serão armazenado os arquivos.
     */
    $StoreImagens = ConfigSystema::getStoreFiles("DestinoHD");
    
    $Count = 0;
    foreach ($_FILES as $key => $value) {
        
        $upFiles = new uploadsImg($value, $Session, $User);
        /**
         * Verifica a forma de armazenamento da imagem. Retorno true storeg(HD), false BD.
         */
        if($upFiles->get_Storeg()){
            $upFiles->PathDestino($StoreImagens); //Seta o caminho da imagem.
            $Cm = $upFiles->CriarDestinoImagem(); //Cria a pasta onde armazenará as imagens
            
            if($Cm){
                $Saida = $upFiles->moverImagens(); //Move os arquivos da pasta temporária para a pasta permanente.
                if($Saida[0]){
                    $CaminhoHTML = $Saida[1];
                    if(!$upFiles->get_Storeg_tabela()) continue;
                    /**
                     * Verifica se o array $Saida já vem com dados.
                     */
                    if(!is_array($Dados)){
                        $Dados = [["name"=>"Destino", "value"=>"$CaminhoHTML"]];  
                    }else{
                        /**
                         * Existindo um array, que provavelmente será de outros campos, será acrescentado um outro array.
                         */
                        $Dados[0][1] = ["name"=>"Destino", "value"=>"$CaminhoHTML"];  
                    }
        
                    if(empty($Tabela)) throw new Exception("Nenhuma tabela foi definida, favor entrar em contato com o administrador.");

                    /**
                     * Cria um objeto da classe ModeloTabela.php mapeada.
                     */
                    $InserirDados = new $Tabela();
                    /**
                     * Se a sessão for anônima deverá ser devinido um usuario e privilégios de acesso na tabela através
                     * da variável privilegios em cada classe que representa a tabela.
                     */
                    $InserirDados->setUsuario("Alexandre");
                    $Result = $InserirDados->InserirDadosTabela($Dados);
                    $Dados = NULL;
                    
                    if(!$Result){
                        $Remove = $upFiles->removeArquivo(); //Caso a inserção dos dados tenha falhado o arquivo será removido.
                        if(!$Remove){
                            $FilesErros[$Count][0] = $Saida[1];
                            $FilesErros[$Count][1] = $InserirDados->getErros();
                            $Count++;
                        }
                    }
    
                }else{
                    throw new Exception("Não foi possível mover a imagem, motivo desconhecido. Favor entrar em contato com o administrador. Local: BaixarFiles", 3306);
                }
            }else{
                throw new Exception("Não foi possível criar a pasta de destino no servidor, motivo desconhecido. Favor entrar em contato com o administrador. Local: BaixarFiles", 3305);
            }  
            
        }else{
            
        }
        
    }

    
} catch (Exception $ex) {
        $ResultRequest["Erros"]["Modo"]        = "S";
        $ResultRequest["Erros"][0]             = true;
        $ResultRequest["Erros"][1]             = $ex->getCode();
        $ResultRequest["Erros"][2]             = $ex->getMessage();

        echo json_encode($ResultRequest); 
        exit;
}

$ResultRequest["Modo"]           = "S";
$ResultRequest["Erros"]          = false;
$ResultRequest["Falhas"][0]      = count($FilesErros) > 0 ? true : false;
$ResultRequest["Falhas"][0]      = $FilesErros;



echo json_encode($ResultRequest); 

?>
