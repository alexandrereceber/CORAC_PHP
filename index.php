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
        <link rel="stylesheet" href="/CORAC/Componentes/FolderFiles/PastasArquivos.css?q=24h">

        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" defer=""></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer=""></script>

        <script defer="" src="/CORAC/Componentes/FolderFiles/PastasEArquivos.js?q=57d4h" ></script>
   
        
    </head>
    <body>


        <button value="Teste" onclick="webServicos()">Conectar WebSocke</button>
        <input id="dadosenv" type="text"/><button onclick="enviardados(dadosenv)" value="envia">enviar</button>
        <div ><img id="ImgG" src="./Imagens/teste/win.png" /></div>
        <div id="tecla" ></div>
        
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
                  <div class="modal-footer status-footer">

                  </div>        
                  <!-- Modal footer -->
                  <div class="modal-footer">

                    <button type="button" class="btn  cancelar" data-dismiss="modal"></button><button type="button" class="btn  ok" data-dismiss="modal"></button>
                  </div>

                </div>
              </div>
            </div>
    </body>
</html>
