/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var Padrao = function(){
    return{
        getHostServer: function(){
            return "192.168.15.10"
        }
    }
}()
function CriarMensagemUser(Nome, Mensagem, Hora){
    $(".chat-list").append('<li class="chat-item">'+
                                    '<div class="chat-content">'+
                                        '<h6 class="font-medium">'+ Nome +'</h6>'+
                                        '<div class="chat-img"><img src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/chat_user.png" alt="Usuário"></div>'+
                                        '<div class="box bg-light-info">'+ Mensagem +'</div>'+
                                    '</div>'+
                                    '<div class="chat-time">'+ Hora +'</div>'+
                                '</li>');
}
                        
function CriarMensagemSuporte(Nome, Mensagem, Hora){
        $(".chat-list").append('<li class="odd chat-item">'+
                                        '<div class="chat-content">'+
                                            '<h6 class="font-medium">'+ Nome +'</h6>'+
                                            '<div class="box bg-light-inverse">'+ Mensagem +'</div>'+
                                        '</div>'+
                                        '<div class="chat-img chat-Img-Left"><img src="http://'+ Padrao.getHostServer() +'/CORAC/Imagens/Chat/chat_Suporte.png" alt="user"></div>'+
                                        '<div class="chat-time">'+ Hora +'</div>'+
                                    '</li>'); 
}
