var Ws = null;

function webServicos(){
    Ws = new WebSocket ( "ws://192.168.15.10:9090/AcessoRemoto/" ,["fff","ddd","fff"]);
    Ws.onmessage = function(dados){
        var t = document.getElementById("ImgG");
        t.src = "data:image/png;base64,"  + dados.data;
    }
    
}

function enviardados(dados){
    Ws.send(dados.value)
}