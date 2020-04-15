<?php
/**
 * Criado: 29/09/2018
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes à banco de dados.
 * @Autor 04953988612
 */
if(@!include_once "../../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi Cabeçaalho. Cabeçalho Geral";
    
    echo json_encode($ResultRequest);
    exit;
};

AmbienteCall::setCall(true);
AmbienteCall::setPageCall("Gerente.php");
AmbienteCall::setTypeUser("Gerente");

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/TBL/Cabecalho_Tabelas.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
};

echo "<script>var Chave='$sendChave'</script>"
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="CSS/Componentes/TabelaHTML.css?d">

         <link rel="stylesheet" href="Scripts/mdl/material.min.css">
        <script src="Scripts/mdl/material.min.js" defer=""></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
        <link rel="stylesheet" href="./uploadsFiles/css/prettyPhoto.css?34s4"> 
        <link rel="stylesheet" href="./uploadsFiles/css/uploadsCSS.css?443"> 
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

        <script  src="Scripts/bootbox/bootbox.js?5a" defer="defer"></script>
        <script  src="Scripts/jsControlador/jsConstroller.js?dsa3sssd" defer="defer"></script>     
        <script  src="Componentes/Componentes.js?sassdsF" defer="defer"></script>  
        <script  src="./uploadsFiles/js/tratarFiles.js?3sssfa3" defer="dfer"></script> 
        <script  src="./index.js?4asds" defer="defer"></script>  
        
    </head>
    <body>


<!-- The Modal -->
  <div class="modal fade" id="myJanelas">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Título</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn  cancelar" data-dismiss="modal"></button><button type="button" class="btn  ok" data-dismiss="modal"></button>
        </div>
        
      </div>
    </div>
  </div>
<div id="dados" onload=""></div>
</body>
</html>
