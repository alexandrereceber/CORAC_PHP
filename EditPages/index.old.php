<?php  

/**
 * Criado: 29/09/2018
 * Modificado: 
 */
/**
 * Recebe todas as requisições referentes à banco de dados.
 * @Autor 04953988612
 */
if(@!include_once "../Config/Configuracao.php"){ //Include que contém configurações padrões do sistema.
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 40001;
    $ResultRequest["Erros"][2]             = "O arquivo de cabecalho não foi Cabeçaalho. Cabeçalho Geral";
    
    echo json_encode($ResultRequest);
    exit;
};

AmbienteCall::setCall(true);
AmbienteCall::setPageCall("Gerente.php");
AmbienteCall::setTypeUser("Gerente");

if(@!include_once ConfigSystema::get_Path_Systema() .  "/Controller/SegurityPages/SecurityPgs.php"){ //Include que contém configurações padrões do sistema.
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
        <title>Editar Site</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./CSS/Componentes/TabelaHTML.css">

        <link rel="stylesheet" href="./CSS/LoadPage/LoadPageCSS.css?s=<?php echo time() ?>"">
        <link rel="stylesheet" href="./CSS/CxFerramentaWEB/CxFerramentaWD.css?s=<?php echo time() ?>">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        
        
        
        <script  src="./Scripts/bootbox/bootbox.js?5a" defer="defer"></script>
        <script  src="./Scripts/jsControlador/jsConstroller.js?s=<?php echo time() ?>" defer="defer"></script>     
        <script  src="./Componentes/viewPopover.js?s=<?php echo time() ?>" defer=""></script>
        <script  src="./Componentes/Tabelas.js?s=<?php echo time() ?>" defer="defer"></script>     
        <script  src="./Componentes/jsControladorPWebEdit.js?s=<?php echo time() ?>" defer="defer"></script>     
        <script  src="./Componentes/OCJustInTime.js?s=<?php echo time() ?>" defer="defer"></script>     
        
    </head>
    <body onresize="ObjetoSelecionado.setRenderizarCFI()">
        <div  class="Barra-Menu-Superior S-EMPTY-Barra-Menu-Superior" id='Barra-Menu-Superior'><i class="material-icons" style="font-size: 56px;margin: auto;color: #a2c9e459;">info_outline</i></div>
        <div class="Pagina-Central" id='Pagina-Central'>
            <div class="BLE S-EMPTY-BLE" id='BLE'><i class="material-icons" style="font-size: 56px;margin: auto;color: #a2c9e459;">info_outline</i></div>
            <div class="BCD S-EMPTY-BCD" id='BCD'><i class="material-icons" style="font-size: 56px;margin: auto;color: #a2c9e459;">info_outline</i></div>
            <div class="BLD S-EMPTY-BLD" id='BLD'><i class="material-icons" style="font-size: 56px;margin: auto;color: #a2c9e459;">info_outline</i></div>
        </div>
        <div class="Barra-Status S-EMPTY-BLE-Barra-Status" id='Barra-Status' onmouseup=""><i class="material-icons" style="font-size: 56px;margin: auto;color: #a2c9e459;">info_outline</i></div>
    </body>
    
    
    
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

</html>
