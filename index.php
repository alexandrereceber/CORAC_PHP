<?php  

echo '<script>var Chave = "eyJVc2VybmFtZSI6IjA0OTUzOTg4NjEyIiwiUGFzc3dvcmQiOiJjZGI1NTkwMTYyM2VkYjkxMDliZGQzZTk4MGVhNDA1NCIsIlRlbXBvIjoxNTQwODk5MjQ0LCJJRCI6IjNhZmNkMTZjMmJlZWY3ZjlmN2M3MGE3MGM2ZDM2ZDY5In0="</script>'

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
        <link rel="stylesheet" href="./uploadsFiles/css/prettyPhoto.css?344"> 
        <link rel="stylesheet" href="./uploadsFiles/css/uploadsCSS.css?443"> 
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" defer=""></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer=""></script>

        <script src="./Scripts/CKEditor/ckeditor.js" ></script>
        
        <script  src="Scripts/bootbox/bootbox.js?5a" defer="defer"></script>
        <script  src="Scripts/jsControlador/jsConstroller.js?ddss3" defer="defer"></script>     
        <script  src="Componentes/jsControladorPWeb.js?d5ssd63" defer="defer"></script>     
        
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
<div id="toolbar-container"></div>
<div id="editor"></div>
<div id="dados" onload=""></div>
    </body>
</html>
