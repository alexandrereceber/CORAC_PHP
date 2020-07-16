var op = $.ajax({
                        cache: false,
                        url: "http://192.168.15.10/CORAC/md5.php",
                        type: "POST",
                        async: true,
                        enctype: "multipart/form-data",
                        contentType: this.TipoConteudo,
                        beforeSend: function(Antes){

                        },
                        complete: function(Completo){ //Método é chamado automaticamento pelo objeto ajax.

                        },
                        data: "fdfd",
                        success: function(Resultado, status, xhr){
                            alert(9);
                        },
                        error: function(xhr,status,error){
                            errors(E(xhr, status, error));
                        }
            });