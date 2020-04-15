
class ReceberEnviar extends JSController{
    constructor(objetoRecipiente, ModoCaixaUpload, CaminhoEnvio, Tabela){
        super (CaminhoEnvio);
        this.TipoConteudo = false;
        this.ProcessarDados = false;
        
        var obj = objetoRecipiente || false,
           Modo = ModoCaixaUpload || false;
        
        if(!obj) {bootbox.alert("Objeto recipiente necessário"); return false};
        if(!Modo) {bootbox.alert("Tipo de caixa de upload está faltando!"); return false};
        if(!CaminhoEnvio) {bootbox.alert("URL para upload é necessário."); return false};
        
        /**
         * Objeto que receberá o componente.
         */
        this.objRecipient   = objetoRecipiente;
        /**
         * Modo de visualização do componente dragdrop, select file
         */
        this.Modo           = ModoCaixaUpload;
        /**
         * Caminho do controlador que receberá os arquivos
         */
        this.pathEnvio      = CaminhoEnvio;
        /**
         * Nome da tabela no banco de dados que armazenará as imagens
         */
        this.sendTabelas = Tabela || false;
        /**
         * Variável que armazena os arquivos que serão enviados para o servidor
         */
        this.conteudoFl     = [];
        /**
         * Representa o objeto instanciado, é usado para passar o objeto para funções fora do escopo da instância atual.
         */
        this.Instancia = this;
        this.ImagemAtual = 0;
        this.Total = 0;
        /**
         * Caminho onde se localiza a imagem que fica aparecendo ao passar o mouse em cima do componente.
         */
        this.URLUploads = "./uploadsFiles/";
        
        this.Forms = new FormData();

        this.FrameWork = "bootstrap"; //Informa com qual framework o componente mostrará os dados.
        /**
         * Variável que define se a visualização das imagens será simples ou avança
         */
        this.TipoView = 2; //1 - Simples, 2 - Eterna
        /**
         * Cria a caixa visual do componente
         */
        this.CriarCaixaEnvio();
        
    }
    allowTamanho(IMG){
        let t = IMG.size;
        if(t > 2097152) return true; return false;
    }
    
    allowTipo(IMG){
        let Tipo = IMG.type;
        return /image/.test(Tipo);
    }
    loadImagens(n, tOriginal, Titulo){
        var T = (document.querySelector("#img_prev_titulo"))
        T.innerHTML =  "Nº " + n + " - " + Titulo;
        (document.querySelector("#preview_Width_Real")).src = tOriginal;
    }
    
    avancoImagem(){
        var nimg = this.ImagemAtual;
        if((nimg + 1) > this.Total) return false;
        
        for(var i in this.conteudoFl){
            if(this.conteudoFl[i][0] == nimg){
                let px = parseInt(i) + 1;
                try {
                    this.ImagemAtual = this.conteudoFl[px][0];
                } catch (e) {
                    
                }
                break;
            }
        }
        
        var img = document.querySelector("[data-number-Prev='"+ (this.ImagemAtual) +"']");
        this.loadImagens((this.ImagemAtual + 1), img.src, img.name)
        //this.ImagemAtual++;
    }
    
    retroImagem(){
        var nimg = this.ImagemAtual;
        if((nimg - 1) < 0) return false;
        
        for(var i in this.conteudoFl){
            if(this.conteudoFl[i][0] == nimg){
                let px = parseInt(i) - 1;
                try {
                    this.ImagemAtual = this.conteudoFl[px][0];
                } catch (e) {
                    
                }

                break;
            }
        }
        
        var img = document.querySelector("[data-number-Prev='"+ (this.ImagemAtual) +"']");
        this.loadImagens((this.ImagemAtual + 1), img.src, img.name)
    }
    exibirImagem_tamanho_real(n, tOriginal){
        
        for(var i in this.conteudoFl){
            if(this.conteudoFl[i][0] == n){
                this.ImagemAtual = n;
                var Titulo = this.conteudoFl[i][1].name;
            }
        }
        
        var Scroll = window.scrollY;
        if(this.TipoView ==1){
            $("body").append('<div \n\
                                    class="" \n\
                                    id="myLoader" \n\
                                    style="z-index: 999999; top:'+ Scroll +'px;background-color: #000000;text-align: -webkit-center;position: absolute;left: 0px;width: 100%;height: 100%;"><div style="display: table-cell;vertical-align: middle;height: 50vw;"> \n\
                                    <div id="avancoIMG"><i class="fa fa-angle-double-right" style="font-size:24px"></i></div><div id="retroIMG"><i class="fa fa-angle-double-left" style="font-size:24px"></i></div>\n\
                                    <div style="height: 40vw;display: table-cell;vertical-align: middle;">\n\
                                        \n\
                                        <div id="TituloPreviewImage" style="text-align: right">\n\
                                            <div id="img_prev_titulo" style="display: inline-block;width: 92%;color: white;font-size: larger;font-weight: bolder;">'+ Titulo +'</div>\n\
                                            <div style="display: inline-block;width: 47px;">\n\
                                                <i class="fa fa-window-close-o" style="color: white;font-size:24px; cursor: pointer"></i>\n\
                                            </div>\n\
                                    </div>\n\
                                        <img id="preview_Width_Real" style="width: 50%;">\n\
                                    </div>\n\
                                </div>\n\
                            </div>').addClass("modal-open");
        
            $(".fa-window-close-o").unbind();
            $(".fa-window-close-o").click(function(){
                $("#myLoader").remove();
                //$("body").removeClass('modal-open');
            });
            $("#retroIMG").unbind();
            $("#avancoIMG").unbind();
            
            var objeto = this.Instancia
            $("#avancoIMG").click(function(){
                objeto.avancoImagem();
            })
            $("#retroIMG").click(function(){
                objeto.retroImagem();
            })
            
            this.loadImagens(n + 1, tOriginal, Titulo)            
        }else{
            
            $("body").append('<div \n\
                                    class="" \n\
                                    id="myLoader" \n\
                                    style="z-index: 999999; top:'+ Scroll +'px;background-color: #000000c4;text-align: -webkit-center;position: absolute;left: 0px;width: 100%;height: 100%;"><div style="display: table-cell;vertical-align: middle;height: 50vw;"> \n\
                                    <div id="avancoIMG"><i class="fa fa-angle-double-right" style="font-size:24px"></i></div><div id="retroIMG"><i class="fa fa-angle-double-left" style="font-size:24px"></i></div>\n\
                                    <div style="height: 40vw;display: table-cell;vertical-align: middle;">\n\
                                        <div class="pp_pic_holder pp_default" style="z-index: 999999;opacity: 0;top: 52.5px;left: 307px;display: block;width: 738px;">'+
                                            '<div id="img_prev_titulo" class="ppt" style="opacity: 1;display: block;width: 100%;"></div>'+
                                                '<div class="pp_top">'+
                                                    '<div class="pp_left"></div>'+
                                                    '<div class="pp_middle"></div>'+
                                                    '<div class="pp_right"></div>'+
                                                '</div>'+
                                                '<div class="pp_content_container">'+
                                                                    '<div class="pp_left">'+
                                                                    '<div class="pp_right">'+
                                                                            '<div class="pp_content" style="height: 516px;width: 99%;">'+
                                                                                    '<div class="pp_loaderIcon" style="display: none;"></div>'+
                                                                                    '<div class="pp_fade" style="display: block;">'+
                                                                                            '<a href="#" class="pp_expand" title="Expand the image" style="display: none;">Expand</a>'+
                                                                                            '<div class="pp_hoverContainer" style="height: 480px; width: 720px; display: none;">'+
                                                                                                    '<a class="pp_next" href="#">next</a>'+
                                                                                                    '<a class="pp_previous" href="#">previous</a>'+
                                                                                            '</div>'+
                                                                                            '<div id="pp_full_res" style="width: 100%;position: relative;"><img id="preview_Width_Real" src="../Imagens/repositorio/IMG_1518.JPG" style="height: 480px;width: 100%;position: relative;right: 0px;left: 0px;border-radius: 12px;"></div> '+
                                                                                            '<div class="pp_details" style="width: 100%;">'+
                                                                                                    '<div class="pp_nav" style="display: none;"><a href="#" class="pp_play">Play</a>'+
                                                                                                            '<a href="#" class="pp_arrow_previous">Previous</a> '+
                                                                                                            '<p class="currentTextHolder">1/1</p>'+
                                                                                                            '<a href="#" class="pp_arrow_next">Next</a>'+
                                                                                                    '</div>'+
                                                                                                    '<p class="pp_description" style="display: none;"></p>'+
                                                                                                    '<div class="pp_social"></div>'+
                                                                                                    '<a class="pp_close" href="#">Close</a>'+
                                                                                            '</div>'+
                                                                                    '</div>'+
                                                                            '</div>'+
                                                                    '</div>'+
                                                                    '</div>'+
                                                            '</div>'+
                                                            '<div class="pp_bottom">'+
                                                                    '<div class="pp_left"></div>'+
                                                                    '<div class="pp_middle"></div> '+
                                                                    '<div class="pp_right"></div>'+
                                                            '</div>'+
                                                    '</div>'+
                                                '</div>\n\
                                            </div>\n\
                            </div>').addClass("modal-open");
            $(".pp_pic_holder").animate({opacity:1},1000)
            $(".pp_close").unbind();
            $(".pp_close").click(function(){
                $("#myLoader").fadeOut(function(){
                    $("#myLoader").remove();
                })
            }); 
            $("#retroIMG").unbind();
            $("#avancoIMG").unbind();
            
            var objeto = this.Instancia
            $("#avancoIMG").click(function(){
                if(objeto.ImagemAtual == objeto.Total){
                    $("#pp_full_res").animate({left: '50px'}, 100)
                    $("#pp_full_res").animate({left:'-50px'}, 100)
                    $("#pp_full_res").animate({left:'50px'}, 100)
                    $("#pp_full_res").animate({left:'-50px'}, 100)
                    $("#pp_full_res").animate({left:'0px'}, 100)
                    return false;
                }else 
                $("#pp_full_res").animate({left: '700px', opacity: 0}, function(){
                    $(this).css("left", '-1000px');
                    $(this).animate({left: '0px', opacity: 1})
                })
                objeto.avancoImagem();
            })
            $("#retroIMG").click(function(){
                if(objeto.ImagemAtual == 0){
                    $("#pp_full_res").animate({left: '50px'}, 100)
                    $("#pp_full_res").animate({left:'-50px'}, 100)
                    $("#pp_full_res").animate({left:'50px'}, 100)
                    $("#pp_full_res").animate({left:'-50px'}, 100)
                    $("#pp_full_res").animate({left:'0px'}, 100)
                    return false;
                }else 
                $("#pp_full_res").animate({left: '-700px', opacity: 0}, function(){
                    $(this).css("left", '1000px');
                    $(this).animate({left: '0px', opacity: 1})
                })
                objeto.retroImagem();

            })
            this.loadImagens(n + 1, tOriginal, Titulo)
        }

    }
    
    
    
    async carregarImagens(file, idx_prevView, objeto){
        new Promise(function(resolve, reject){
                
                var lerFiles = new FileReader();
                lerFiles.onprogress = function(e){
                    
                        let percentual = parseInt(parseFloat(e.loaded / e.total) * 100);
                        let imgProgress = document.querySelector("#progress_img_" + idx_prevView);
                        imgProgress.attributes[4].value = percentual
                        imgProgress.style.width = percentual + "%"
                        console.log(percentual);
                    
                };
                lerFiles.onload = function(e){
                    let imagem = new Image(), Caminho;
                    imagem.className = "ig_prev";
                    imagem.dataset.numberPrev = idx_prevView;
                    imagem.name = file.name
                    Caminho = this.result;
                    imagem.src = Caminho;
                    imagem.style.cursor = "pointer";
                    
                    imagem.onclick = function(){
                        objeto.exibirImagem_tamanho_real(idx_prevView, Caminho);
                    }                    
                    $("#img_prev_" + idx_prevView).html("<div id='N_img_prev'><div style='display: inline-block;margin-right: 10px;'>Nº "+ (idx_prevView + 1) +"</div><div style='display: inline-block;font-size: smaller; cursor: pointer'><i data-number='"+ idx_prevView + "' class='fa fa-times MatarFoto' aria-hidden='true'></i></div></div>");
                    $("#img_prev_" + idx_prevView).append(imagem);

                    $(".MatarFoto").unbind();
                    $(".MatarFoto").click(function(e){
                        var index = e.currentTarget.dataset.number,
                            img = document.querySelector("[data-cprevimg='CPrev_"+ index +"']");
                            for(var i in objeto.conteudoFl){
                                if(objeto.conteudoFl[i][0] == index){
                                    objeto.conteudoFl.splice(i, 1)
                                    $(img).remove();
                                }
                            }                            

                    });                        

                    
                    
                    resolve();
                };
                lerFiles.onerror = function(){
                    reject();
                };
                
                lerFiles.readAsDataURL(file);
                
            })        
    }
    
    async verificarArquivos(fl){
        this.conteudoFl = [];
        var objeto = this, Count = 0;
  
        if(this.Modo == 2 || this.Modo == 4){
            
        }
        $(".preview_fts").html("");
        $("#prev_status").html("");
        $("#prev_Botoes").html("<center><div><button id='EnviarFls' class='btn btn-primary'>Uploads</button></div><div id='Progress_Uploads_files'></div></center>");
        $("#prev_Botoes").unbind();
        $("#EnviarFls").click(async function(){
            let progress = '<div class="progress " style="margin-top: 5px;">'+
                                '<div id="progress_Uploads" class="progress-bar" role="progressbar" style="background-color: red;width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>'+
                            '</div>';   
                    
            objeto.Config.Load = false;
            objeto.Config.Tipo = "UploadFiles";
            objeto.Config.Enable = true;
            objeto.Config.Componente = "#progress_Uploads";
            
            
            for(var i in objeto.conteudoFl){
                objeto.Forms.append("Imagens" + i, objeto.conteudoFl[i][1], objeto.conteudoFl[i][1].name);
            }
            /**
             * Envia o tipo de operação que o controlador deverá buscar.
             */
            objeto.Forms.append("sendModoOperacao","0319b3d5ecffc67e6cdb9a41bddedff7");
            
            if(objeto.sendTabelas){
                objeto.Forms.append("sendTabelas",objeto.sendTabelas);
            }

            objeto.DadosEnvio = objeto.Forms;
            
            $("#Progress_Uploads_files").html(progress);
            
            let saida = await objeto.Atualizar();
            objeto.DadosEnvio = null;
            objeto.conteudoFl = null
            
            $("#Progress_Uploads_files").html("");
            
                if(saida[0] == true){
                if(saida[1] == 35200){
                    bootbox.alert("<h3>"+ saida[2] +"</h3>")
                }else{
                    bootbox.alert("<h3>"+ saida[2] +"</h3>")
                }
            }else{
                bootbox.alert("<h3>Imagens enviada com sucesso.</h3>")
            }
        });
        
        for (var i = 0, file; file = fl.files[i]; i++) {
            let Tipo = this.allowTipo(file),
                Tamanho = this.allowTamanho(file);
            if(false){
                //bootbox.alert("<h3>Arquivo: "+ file.name +" <br> Tamanho: "+ parseInt(file.size / (1024*1024)) + "MB <br> <span style='color: blue'>Permitido 2MB</span> <br> Tipo: "+ file.type +" <br> <span style='color: blue'>Tipos de arquivos válidos (jpeg/png/gif)</span>.</h3>");
                if(Tamanho)
                    $("#prev_status").append("<br><b>Nome</b>: " + file.name + " <b>Tamanho</b>: <span style='color: red'>" + parseInt(file.size / (1024*1024)) +"MB</span> => permitido 2MB")
                
                if(!Tipo)
                    $("#prev_status").append("<br><b>Nome</b>: " + file.name + " <b>Tipo</b>: <span style='color: red'>" + file.type +"</span> => válidos (jpeg/png/gif)")
                
                continue;
            }
            this.conteudoFl[i] = [];
            this.conteudoFl[i][0] = i;
            this.conteudoFl[i][1] = file;
            this.Total = i;
            
            if(this.Modo == 2 || this.Modo == 4){
                let progress = '<div class="progress">'+
                                    '<div id="progress_img_'+ i +'" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>'+
                                '</div>'; 

                $(".preview_fts").append("<div id='CIMG' data-CPrevImg='CPrev_"+ i +"'>\n\
                                                <div id='img_prev_"+ i +"' class='img_prev' title='"+ file.name +"'>"+ progress +"</div>\n\
                                         </div>");

                await this.carregarImagens(file, i, objeto);
                
            }

        }

    }    

    modo1And2(Modelo){
        let Obj = this

        
        let CaixaDIV =  '<div>\n\
                                <div id="CUp" class="CaixaUploads" ondragover="return false" >'+
                                    '<div class="CaixaUploadInterna" >\n\
                                        <i class="fa fa-upload icoUp" ></i>\n\
                                    </div>'+
                                    '<img class="setaManuscrita" src="'+ this.URLUploads +'img/seta.png">\n\
                                </div>'+(this.Modo == 2 ? '<div class="preview_fts"></div>' : '' )+
                                '<div id="prev_Botoes" style="width: 63vw;top: 5px;position: relative;"></div>'+
                                '<div id="prev_status"></div>'+
                            '</div>';
            $(this.objRecipient).html(CaixaDIV);
            $("#CUp").on("drop", function(e){
                e.stopPropagation();
                e.preventDefault();
                Obj.verificarArquivos(e.originalEvent.dataTransfer);
                
            }).on("dragover", 
            
                function(e){
                    $(e.currentTarget).css("background","#ff000040").css("border","solid 4px #ff00003b").css("border-style","dashed")
                }).on("mouseover", 
                function(e){
                    $(".setaManuscrita").fadeIn('slow')
            }).on("mouseout", 
                function(e){
                    $(".setaManuscrita").fadeOut('slow')
            }).on("dragleave",
                function(e){
                    $(e.currentTarget).css("background","white").css("border","solid 0px #ff00003b").css("border-style","dashed")
            }).on("dragend", 
            function(e){
                debugger;
            });
    }
    
    Modo3And4(Modo){
        let Obj = this;
        
        let CaixaDIV =  '<div class="input-group mb-3">'+
                            '<div class="input-group-prepend">'+
                              '<div class="input-group-prepend">'+
                                '<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Arquivos</button>'+
                                '<div class="dropdown-menu" id="ObterNamFiles">'+
                                  '<div role="separator" class="dropdown-divider"></div>'+
                                '</div>'+
                              '</div>'+
                            '</div>'+
                            '<div class="custom-file">'+
                                '<input type="file" class="custom-file-input" id="SelecFiles" multiple="" >'+
                                '<label class="custom-file-label" for="inputGroupFile01">Selecionar arquivos</label>'+
                            '</div>'
                         +(this.Modo == 4 ? '<div class="preview_fts input-group" ></div>' : '' )+
                                '<div class="input-group" id="prev_Botoes" style="display: table-cell;text-align: center;top:3px"></div>'+
                                '<div class="input-group" id="prev_status"" ></div>'+'</div>';
        $(this.objRecipient).html(CaixaDIV); 
        
        $("#SelecFiles").on("change", function(e){
            var Arquivos = e.target.files
            $("#ObterNamFiles").html("")
            for(var i=0; i < Arquivos.length; i++){
                $("#ObterNamFiles").append('<a class="dropdown-item" href="#">'+Arquivos[i].name+'</a>');
            }
            Obj.verificarArquivos(e.target);            
                                              

        })
        
    }
    
    CriarCaixaEnvio(){
        /**
         * Modo de visualização mais simples
         */
        if(this.Modo == 1 || this.Modo == 2){
            this.modo1And2(this.FrameWork);
        }else if(this.Modo == 3 || this.Modo == 4){
            this.Modo3And4(this.FrameWork);
        }

    }
}

/**
 * @param {string} Recipiente Local onde o grafico do componente será disposto.
 * @param {int} Qual tipo de componente será visualizado 1, 2, 3
 * @param {string} Caminho do controlador 
 * @param {string} Tabela, no banco de dados, onde será armazenado as imagens
 * @type ReceberEnviar
 */
var InstanciarUpload = new ReceberEnviar("#uploadzz",3,"http://10.56.32.78:8080/CORAC/Controlador/", "a868a1388d958fb560eb17f2d71cbb9e");
