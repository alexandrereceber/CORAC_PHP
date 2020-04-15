class ViewImage{
    
    constructor(clss){
        this.images = document.querySelectorAll(clss);
        this.imgAtual = null;
    }
    
    primeiraImagem(objeto){
        return objeto.currentTarget.attributes.src.nodeValue;
    }
    
    next(){
        let img = []
        for(var i = 0; i < this.images.length ; i++){
            if(this.imgAtual == this.images[i]){
                img[0] = i == (this.images.length - 1) ? true : false;
                img[1] = this.images[i+1];
                this.imgAtual = i == (this.images.length - 1) ? this.imgAtual :this.images[i+1];
                return img;
            }
        }
    }
    
    prev(){
        let img = []
        for(var i = 0; i < this.images.length ; i++){
            if(this.imgAtual == this.images[i]){
                img[0] = i == 0 ? true : false;
                img[1] = this.images[i-1];
                this.imgAtual = i == 0 ? this.imgAtual :this.images[i-1];
                return img;
            }
        }
    }
    
    showSlides(e){
        
        var Scroll = window.scrollY;
        
        $("body").append('<div '+
                            'class=""'+
                            'id="myViews"'+
                            'style="z-index: 11; top:'+ Scroll + ';background-color: #000000c4;text-align: -webkit-center;position: absolute;left: 0px;width: 100%;height: 100%;"><div style="display: table-cell;vertical-align: middle;height: 50vw;"> '+
                            '<div id="avancoIMG"><i class="fa fa-angle-double-right" style="font-size:24px"></i></div><div id="retroIMG"><i class="fa fa-angle-double-left" style="font-size:24px"></i></div>'+
                            '<div style="height: 40vw;display: table-cell;vertical-align: middle;">'+
                                '<div class="pp_pic_holder pp_default" style="z-index: 999999;opacity: 0;top: 52.5px;left: 307px;display: block;width: 738px;">'+
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
                                        '</div>'+
                                    '</div>'+
                            '</div>').addClass("modal-open");
                    
        $("#preview_Width_Real").attr("src", this.primeiraImagem(e));
        
        $(".pp_pic_holder").animate({opacity:1},1000) 
            $(".pp_close").unbind().click(function(){
                $("#myViews").fadeOut(function(){
                    $("#myViews").remove();
                    $("body").removeClass('modal-open');

                })
            }); 
        var Objeto = this;
        this.imgAtual = e.currentTarget;
        
        $("#retroIMG").unbind().click(function(e){
            
            let i = Objeto.prev();
            if(i[0]){
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
                    $("#preview_Width_Real").attr("src", i[1].src);
                })

        });
        $("#avancoIMG").unbind().click(function(e){
            
            let i = Objeto.next();
            if(i[0]){
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
                    $("#preview_Width_Real").attr("src", i[1].src);
                })

        });
    }
}

