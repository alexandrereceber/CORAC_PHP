/* 
 * Criado: 13/12/2018
 * 
 * Criar páginas estáticas online com componentes Just In Time.
 */


var addObjeto = function(){
    var OCriado = {ID: 0, ModoEdicao: 0}, Edicao = {ModoEdicao: false}
    var tags = {
                    DIV : "<div data-EditarPropriedades=true id='{{name}}' style='display: flex;border: solid 1px #deb887; width: {{OCWidth}}; height: {{OCHeight}}px; margin: auto;'></div>"
                }
    return {
        getTag: function(tag){
            var n = tag + "_" + parseInt(event.timeStamp * Math.random()), newTag = "";
            for(var t in tags){
                if(t == tag){
                    newTag = (tags[t]).replace('{{name}}', n)
                    OCriado.ID = n;
                    return {tagDescribe: newTag, nome: n};
                }
            }
            return false;
        },
        
        getIDOCriado(){
            return OCriado.ID
        },
        /**
         * Verifica se o objeto que esta sendo possicionado no objeto atual é válido ou não.
         * É utilizado pelas funções: 
         *                              Modo de edição, 
         *                              Modo Visualização, 
         *                              addFuncionalidades, 
         *                              setRenderizarCFI, 
         *                              addFerramentasInternas, s
         *                              etEventDroppableObjetoCriado
         * @param {type} ui
         * @returns {Boolean}
         */
        verifyObjeto(ui){
           let Cx = ui.id
           let tipo = ui.nodeName
           
           if(Cx == "CxPropriedadesWEBDesign") return true;
           if(Cx == "CxFerramentaWEBDesign") return true;
           if(tipo == "DIV") return false;
           
           return false;
        },
        
        getFuncoes(o){
            return o.dataset.action;
        },
        
        setModoEdicao(m){
            Edicao.ModoEdicao = m;
                        
        },
        getModoEdicao(){
            return Edicao.ModoEdicao;
        },
        /**
         * 
         * @param {type} idxIcone - índice do ícone na lista de ícone.
         * @param {type} t - Titulo
         * @param {type} m
         * @returns {undefined}
         */
        Mensagem(idxIcone, titulo, msg){
            let icn = [
                        {Icone: '<i class="material-icons" style="font-size:36px">error_outline</i>'}
                    ], 
                Conteudo = "";
        
            Conteudo = "<div><h3>{{Titulo}}</h3></div><div>{{Icone}} {{Conteudo}}</div>";
            
            Conteudo = Conteudo.replace('{{Titulo}}', titulo).replace('{{Icone}}', icn[idxIcone].Icone).replace('{{Conteudo}}', msg);
            
            bootbox.alert({
                message: Conteudo,
                backdrop: true
            });    
        }
    }
}()

var ObjetoSelecionado = function() {
    var Objeto = {select: null, selectIdn: -1}
    return {
       setObjeto(o){
           Objeto.select = o;
           Objeto.selectIdn = o.dataset.idn || -1;
       },
       getObjetoSelecionado(){
           return Objeto.select;
       },
       getObjetoIDSelecionado(){
           return Objeto.selectIdn;
       },
       clearObjetoSelecionado(){
           Objeto.select = null;
           Objeto.selectIdn = -1;           
       },
       ExcluirObjetoSelecionado(o){
           o.offsetParent.parentNode.remove();
            this.setRenderizarCFI();

       },
       /**
        * Se o retorno for false os objetos não são parentes.
        * @param {type} Obj1 - Filho
        * @param {type} Obj2 - Pai
        * @returns {Boolean}
        */
        verifyHierarquia(Obj1, Obj2){
           
            var EFilho = function(f, p){
                if(p.nodeName == "BODY") return false;
                
                let parents = (f == p);
                if(!parents){
                    if(p.parentNode != null){
                        return EFilho(f, p.parentNode);
                    }else{
                        return false;
                    }
                }else{
                    return true;
                }
           };
           if(Obj1.offsetParent.parentNode == Obj2) return true;
           
           return EFilho(Obj1.offsetParent.parentNode, Obj2)

       }
       ,
       setRenderizarCFI(){
           
           if(!addObjeto.getModoEdicao()) return false;
           
           let positionTop = 0, positionLeft = 0, heightBarraProperty = 32, widthProperty = 73;

           
           console.log("body > renderizando")
            var AllObjeto = document.querySelectorAll('[id=barraPropriedades]');

            for(var obj of AllObjeto.entries()){
                if(addObjeto.verifyObjeto(obj[1])) continue;
           
                positionTop = (obj[1].parentNode).offsetTop - heightBarraProperty ;
                positionLeft = (obj[1].parentNode).offsetLeft + (obj[1].parentNode).clientWidth - widthProperty;
           
                $(obj[1]).css("top",positionTop);
                $(obj[1]).css("left",positionLeft)
            }           
       },
       
       addFerramentasInternas(){
            var AllObjeto = document.querySelectorAll('[data-editarpropriedades=true]');
            if(AllObjeto.length == 0){
                addObjeto.Mensagem(0,"Modo edição","Nenhuma página carregada ou nenhum objeto para edição foi encontrado.");
                return false;
            }

            for(var obj of AllObjeto.entries()){
                if(addObjeto.verifyObjeto(obj[1])) continue;
                $(obj[1]).addClass("SobreObjeto");
                this.criarBarraFerramentaInterna(obj[1]);
            }

       },clearObjetosEdition(Obj){
           
            for(var obj of Obj.entries()){
                for( var p in obj[1].children){
                    if(obj[1].children[p].id == "barraPropriedades"){
                        obj[1].children[p].remove();
                    }
                }
            }
            $("#CxPropriedadesWEBDesign").remove()
           
       },
       
       criarBarraFerramentaInterna(o){
           let positionTop = 0, positionLeft = 0, heightBarraProperty = 32, widthProperty = 73;
           positionTop = o.offsetTop - heightBarraProperty;
           positionLeft = o.offsetLeft + o.clientWidth - widthProperty;
           
           for(var Verify of o.childNodes.entries()){
               if(Verify[1].id == "barraPropriedades") return false;
           }
           $(o).append("\
                                        <div \n\
                                            id='barraPropriedades' \n\
                                            style='position: absolute; \n\
                                                top: "+ positionTop +"px; \n\
                                                left: "+ positionLeft +"px; \n\
                                                border: solid 1px #989595; \n\
                                                width: "+ widthProperty +";\n\
                                                height: "+ heightBarraProperty +"; \n\
                                                background-color: #cccbcd;\n\
                                                display: flex; \n\
                                                border-radius: 3px;'\n\
                                            <div \n\
                                                style='width: 100%;\n\
                                                    display: flex;'>\n\
                                                <span \n\
                                                    style='margin: auto;'>\n\
                                                    <i data-action='MoverObjeto' data-subtipo='' id='' onclick='CaixaFerramenta.hMoveObjeto(this)' class='material-icons buttonPropriedades MoveObjeto'>add_location</i>\n\
                                                </span>\n\
                                                <span \n\
                                                    style='margin: auto;'>\n\
                                                    <i data-action='PropriedadesObjeto' data-subtipo='' id='getPropriedades' onclick='CaixaFerramenta.CriarCaixaPropriedades(this)' class='material-icons buttonPropriedades'>toc</i>\n\
                                                </span>\n\
                                                <span \n\
                                                    style='margin: auto;'>\n\
                                                    <i data-action='ExcluirObjeto' data-subtipo='' id='ExcluirObjeto' onclick='ObjetoSelecionado.ExcluirObjetoSelecionado(this)' class='material-icons buttonPropriedades '>clear</i>\n\
                                                </span>\n\
                                            </div>\n\
                                        </div>");
            $(".MoveObjeto").draggable({//Move objetos entre os divs
                                            helper: "clone",
                                            opacity: 0.5,
                                            scroll: false,
                                            start:  function(){
                                            console.log("ol")
                                        }
                                        })
       },
       setEventDroppableObjetoCriado(o){
           for(var obj in o.children){
               let tmp = o.children[obj]
               if(tmp.id == addObjeto.getIDOCriado()){
                    $(o.children[obj]).droppable({
                       over: function( event, ui ){
                           try{
                                let parents = ObjetoSelecionado.verifyHierarquia(ui.draggable[0]/*Filho*/, this /*Pai*/)
                                
                                if(parents) {
                                    return false;
                                }
                                if(addObjeto.verifyObjeto(ui.draggable[0])) return false;
                                
                                let Funcao = addObjeto.getFuncoes(ui.draggable[0]);
                                
                                switch (Funcao) {
                                    case "InserirObjetoNovo":
                                        var o = document.getElementById("NovoObjeto");
                                        if(o != null) o.remove();

                                        $(this).append("<div data-EditarPropriedades=true data-action='NovoObjeto' class='NEW' id='NovoObjeto'></div>")
                                        
                                    break;

                                   case "MoverObjeto":
                                       let y = ui.draggable[0].offsetParent.parentNode
                                       let p = this
                                       if(ui.draggable[0].offsetParent.parentNode == this) return true;
                                       if(ui.draggable[0].offsetParent.parentNode != this){
                                            var o = document.getElementById("NovoObjeto");
                                            if(o != null) o.remove();

                                            $(this).append("<div data-EditarPropriedades=true data-action='NovoObjeto' class='NEW' id='NovoObjeto'></div>")
                                           
                                       }
                                        
                                    break;
                                    
                                   default:
                                       
                                       break;
                               }

                           }catch(e){
                               console.log(e)
                           }
                       },
                       drop:function(event, ui){
                           try{
                                let parents = ObjetoSelecionado.verifyHierarquia(ui.draggable[0]/*Filho*/, this /*Pai*/)
                                
                               if(parents) {
                                    return false
                               }
                               
                                
                                if(addObjeto.verifyObjeto(ui.draggable[0])) return false;
                                
                                let Funcao = addObjeto.getFuncoes(ui.draggable[0]);
                                
                                switch (Funcao) {
                                    case "InserirObjetoNovo": //Inserindo um novo objeto dentro do objeto DIV.
                                        var o = document.getElementById("NovoObjeto");
                                        if(o.parentNode == this){
                                            o.remove();
                                            var t = addObjeto.getTag(this.nodeName), obj;
                                            if(!t) return false;
                                            obj = (t.tagDescribe).replace('{{OCHeight}}', parseInt(this.offsetHeight / 2))
                                            obj = (obj).replace('{{OCWidth}}', "100%")

                                            let ob = $(this).append(obj)
                                            ObjetoSelecionado.setRenderizarCFI();
                                            ObjetoSelecionado.addFerramentasInternas();
                                            ObjetoSelecionado.setEventDroppableObjetoCriado(ob[0])
                                        }
                                        
                                        break;
                                    
                                   case "MoverObjeto": //Movendo entre outros objetos.

                                       if(ui.draggable[0].offsetParent.parentNode == this) return true;
                                       if(ui.draggable[0].offsetParent.parentNode != this){
                                            var o = document.getElementById("NovoObjeto");
                                            if(o != null) o.remove();
                                            
                                            let obterInstanciaObjNovo = ui.draggable[0].offsetParent.parentNode;
                                            
                                            $(this).append(obterInstanciaObjNovo)
                                            ObjetoSelecionado.setRenderizarCFI();

                                       }
                                        
                                        break;
                                        
                                    default:
                                        
                                        break;
                                }
                               
                           }catch(e){
                                console.log(e)
                           }

                       },
                       out:function( event, ui ){
                           try{
                                if(addObjeto.verifyObjeto(ui.draggable[0])) return false;

                                var o = document.getElementById("NovoObjeto");
                                if(o != null) o.remove();
                               
                           }catch(e){
                                console.log(e);
                               
                           }

                       }
                    });
                    return false;
               }
           }
           
       }
    };
            
}()


class FOCJustInTime extends JSController{
    constructor(BD){
        super(BD);
        this.WebBaseDados = BD;
        this.CriarCaixaFerramenta();
    }
    
    hMoveObjeto(o){

    }
    
    getObjetosEditar(v){
        var AllObjeto = document.querySelectorAll('[data-editarpropriedades='+ v +']');
        if(AllObjeto.length == 0){
            return false;
        }
        return AllObjeto;
    }
    setTrocarModo(Obj){
        
        for(var obj of Obj.entries()){
            (obj[1]).dataset.editarpropriedades = addObjeto.getModoEdicao();
        }
        
        return Obj;
    }
    
    setExibirOcultarBotoes(Display){
        var AllObjeto = document.querySelectorAll('[data-subtipo="ModoEdicao"]');
        for(var obj of AllObjeto.entries()){
            (obj[1]).style.display = Display;
        }        
    }
    
    addFuncionalidades(){
        //var PWJanela = this;
        var Obj = this.getObjetosEditar(addObjeto.getModoEdicao());
        if(Obj == false){
            addObjeto.Mensagem(0,"Modo edição","Nenhuma página carregada ou nenhum objeto para edição foi encontrado.");
            return false;
        }
        
        if(addObjeto.getModoEdicao() == false){
            addObjeto.setModoEdicao(true)
            let 
                i   = '<div><i class="material-icons" style="font-size:18px">visibility</i></div>',
                str = 'Modo de visualização'    ;
            arguments[0][0].innerHTML = i;
            arguments[0][0].title = str;
            this.setExibirOcultarBotoes('');
            
        }else{
            addObjeto.setModoEdicao(false)
            let i = '<div><i class="material-icons" style="font-size:18px">mode_edit</i></div>',
                str = 'Modo de edição'    ;
            arguments[0][0].innerHTML = i;
            arguments[0][0].title = str;
            this.setExibirOcultarBotoes('none')
            ObjetoSelecionado.clearObjetosEdition(Obj);
            this.setTrocarModo(Obj);
            return false;
        }
        
        var AllObjeto = this.setTrocarModo(Obj);
        
        for(var obj of AllObjeto.entries()){
            if(addObjeto.verifyObjeto(obj[1])) continue;
            $(obj[1]).addClass("SobreObjeto");
            ObjetoSelecionado.criarBarraFerramentaInterna(obj[1]);
        }
        
        $(AllObjeto).on("mouseover", function(){
                //console.log("Sobre o objeto que recebeu o evento ao clicar no botão da caixa de ferramenta");
        }).on("mouseout",function(){
                //console.log("Saída do objeto que recebeu o evento ao clicar no botão da caixa de ferramenta");
        }).droppable({
                       over: function( event, ui ){
                           try{
                                
                               if(addObjeto.verifyObjeto(ui.draggable[0])) return false;
                               let parents = ObjetoSelecionado.verifyHierarquia(ui.draggable[0]/*Filho*/, this /*Pai*/)
                                
                               if(parents) {
                                   return false;
                               }
                                
                                let Funcao = addObjeto.getFuncoes(ui.draggable[0]);
                                
                                switch (Funcao) {
                                    case "InserirObjetoNovo":
                                        var o = document.getElementById("NovoObjeto");
                                        if(o != null) o.remove();

                                        $(this).append("<div data-EditarPropriedades=true data-action='NovoObjeto' class='NEW' id='NovoObjeto'></div>")
                                        
                                    break;

                                   case "MoverObjeto":
                                       let y = ui.draggable[0].offsetParent.parentNode
                                       let p = this
                                       if(ui.draggable[0].offsetParent.parentNode == this) return true;
                                       if(ui.draggable[0].offsetParent.parentNode != this){
                                            var o = document.getElementById("NovoObjeto");
                                            if(o != null) o.remove();

                                            $(this).append("<div data-EditarPropriedades=true data-action='NovoObjeto' class='NEW' id='NovoObjeto'></div>")
                                           
                                       }
                                        
                                    break;
                                    
                                   default:
                                       
                                       break;
                               }

                           }catch(e){
                               console.log(e)
                           }
                       },
                       drop:function(event, ui){
                           try{
                                
                                if(addObjeto.verifyObjeto(ui.draggable[0])) return false;
                                let parents = ObjetoSelecionado.verifyHierarquia(ui.draggable[0]/*Filho*/, this /*Pai*/)
                                
                                if(parents) {
                                     return false
                                }

                                let Funcao = addObjeto.getFuncoes(ui.draggable[0]);
                                
                                switch (Funcao) {
                                    case "InserirObjetoNovo": //Inserindo um novo objeto dentro do objeto DIV.
                                        var o = document.getElementById("NovoObjeto");
                                        if(o.parentNode == this){
                                            o.remove();
                                            var t = addObjeto.getTag(this.nodeName), obj;
                                            if(!t) return false;
                                            obj = (t.tagDescribe).replace('{{OCHeight}}', parseInt(this.offsetHeight / 2))
                                            obj = (obj).replace('{{OCWidth}}', "100%")

                                            let ob = $(this).append(obj)
                                            ObjetoSelecionado.setRenderizarCFI();
                                            ObjetoSelecionado.addFerramentasInternas();
                                            ObjetoSelecionado.setEventDroppableObjetoCriado(ob[0])
                                        }
                                        
                                        break;
                                    
                                   case "MoverObjeto": //Movendo entre outros objetos.

                                       if(ui.draggable[0].offsetParent.parentNode == this) return true;
                                       if(ui.draggable[0].offsetParent.parentNode != this){
                                            var o = document.getElementById("NovoObjeto");
                                            if(o != null) o.remove();
                                            
                                            let obterInstanciaObjNovo = ui.draggable[0].offsetParent.parentNode;
                                            
                                            $(this).append(obterInstanciaObjNovo)
                                            ObjetoSelecionado.setRenderizarCFI();

                                       }
                                        
                                        break;
                                        
                                    default:
                                        
                                        break;
                                }
                               
                           }catch(e){
                                console.log(e)
                           }

                       },
                       out:function( event, ui ){
                           try{
                                if(addObjeto.verifyObjeto(ui.draggable[0])) return false;

                                var o = document.getElementById("NovoObjeto");
                                if(o != null) o.remove();
                               
                           }catch(e){
                                console.log(e);
                               
                           }

                       }
                    });
                            
                        
    }
    
    /**
     * Adicionar botões à caixa de ferramentas
     * @returns {void}
     */
    addBotoes(){
        var PWJanela = this;
        
        var bts = [
                    
                    [
                        "ModoEdicao",
                        "<i class=\"material-icons\" style=\"font-size:18px\">mode_edit</i>",
                        function(){
                            
                            PWJanela.addFuncionalidades(arguments);
                        },
                        "google",
                        true,
                        "Modo de edição",
                        false,
                        "Edicao",
                        "Action"
                    ],
                    [
                        "DIV",
                        "<i class=\"material-icons\" style=\"font-size:18px\">aspect_ratio</i>",
                        function(){},
                        "google",
                        'none',
                        "Objeto DIV",
                        true,
                        "ModoEdicao",
                        "InserirObjetoNovo"
                    ]
                ];
                
        bts.forEach(function(i,v,p){
            if(i[4]==false) return false;
            if(i[3] == "google"){ //Ícones Google
                $("#CxBotoesFerramenta").append("<div data-toggle='BFTips' data-tipo='"+i[0]+"' data-subtipo='"+i[7]+"' data-action='"+i[8]+"'  title='"+i[5]+"' class='CxBtoes' id='bt_"+ i[0] +"' style='display: "+ i[4] +"'><div>"+ i[1] +"</div></div>");
                $("#bt_"+ i[0]).click(function(){
                    i[2](this);
                })
            }
            if(i[6]){
                $("#bt_"+ i[0]).draggable({
                                            helper: "clone",
                                            opacity: 0.5,
                                            scroll: false
                                        });
            }            


        });
        //$('[data-toggle="BFTips"]').tooltip();
    }
    closePropriedades(){
        let Prop = document.getElementById("CxPropriedadesWEBDesign");
        Prop.remove()
    }
    
    setPropriedade(O){
        ObjetoSelecionado.getObjetoSelecionado().style[O.dataset.property] = O.value;
        let render = ["width","top","left", "right"];
        for(var i in render){
            if(render[i] == O.dataset.property){
                ObjetoSelecionado.setRenderizarCFI();
                return true;
            }
        }
    }
    
    getProperty(){
        var PWJanela = this;
        let  
        OBj = ObjetoSelecionado.getObjetoSelecionado(), //Objeto selecionado
        DPVisible = {clientHeight:{tipo: "text"}}, //Definições Propriedades Visible
        SPVisible = {backgroundColor:{tipo: "text"}, width:{tipo: "TEXT"}}, //Style Propriedades Visible
        InputsHTML = "",
        HTMLProp = function(F, Value, type){
            let Campo = ""
            Campo = '<div class="form-group">'+
                        '<label for="usr"><b>'+ F +':</b> </label>'+
                        '<input type="'+ type.tipo +'" class="InputProperty" style="width: 100%" data-property="'+ F +'" class="form-control" id="usr" value="'+ Value +'">'+
                    '</div>';

            return Campo;
        }

        //____________________________________________________________________________

        for(let f in OBj){
            let elem = DPVisible.hasOwnProperty(f);
            if(elem) {
               InputsHTML += HTMLProp(f, OBj[f], DPVisible[f]);
            }
        }

        $("#DefinicoesConteudo").html(InputsHTML);
        InputsHTML = "";
        //____________________________________________________________________________


        for(let f in (OBj).style){
            let elem = SPVisible.hasOwnProperty(f);
            if(elem) {
               InputsHTML += HTMLProp(f, OBj.style[f], SPVisible[f]);
            }
        }

        $("#StyleConteudo").html(InputsHTML);
        //$(".InputProperty").unbind();
        $(".InputProperty").on('keyup', function(){
        PWJanela.setPropriedade(this)
        });
    }
    /**
     * Cria a caixa de propriedades
     * @returns {void}
     */
    CriarCaixaPropriedades(obj){
        try{
            //console.log("criando Caixa de Propriedades")
            let o = obj.parentNode.parentNode.parentNode;
            let node = o.nodeName;
            ObjetoSelecionado.setObjeto(o);
            let Exit = document.getElementById("CxPropriedadesWEBDesign");
            if( Exit == null){
                let TabOptions = function(){
                    return '<div class="container">'+
                                '<h4>Propriedades:</h4>'+
                                '<br>'+
                                  '<ul class="nav nav-tabs" role="tablist">'+
                                  '<li class="nav-item">'+
                                    '<a class="nav-link active" data-toggle="tab" href="#Definicoes">Definições</a>'+
                                  '</li>'+
                                  '<li class="nav-item">'+
                                    '<a class="nav-link" data-toggle="tab" href="#Stylo">Estilo</a>'+
                                  '</li>'+
                                  '<li class="nav-item">'+
                                    '<a class="nav-link" data-toggle="tab" href="#Functions">Funções</a>'+
                                  '</li>'+
                                '</ul>'+
                              '  <div class="tab-content">'+
                                  '<div id="Definicoes" class="container tab-pane active"><br>'+
                                    '<div id="DefinicoesConteudo"></div>'+
                                  '</div>'+
                                  '<div id="Stylo" class="container tab-pane fade"><br>'+
                                    '<div id="StyleConteudo"></div>'+
                                  '</div>'+
                                  '<div id="Functions" class="container tab-pane fade"><br>'+
                                    '<div id="Funcoes">'+
                                        '<button class="btn btn-primary vDisplay" style="width: 100%;">Localizar</button>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                              '</div>';
                  }
                      
                let CxF = document.createElement("div");
                
                CxF.id = "CxPropriedadesWEBDesign";
                CxF.className = "CxPropriedadesWEB"
                CxF.style.top = event.currentTarget.offsetParent.parentNode.offsetTop - 300
                CxF.style.left = event.currentTarget.offsetParent.parentNode.offsetLeft

                CxF.innerHTML = "<div id='CxPInterna'>\n\
                                        <div id='BTCxPropriedades'>Caixa de Propriedades</div>\n\
                                        <div id='CxBotoesPropriedades'>"+ TabOptions() +"</div>\n\
                                        <div style='position: relative;top: -37px;left: -1;width: 100%;'><button button='' type='button' class='btn btn-primary AtualizarDados' style='width: 101%;' onclick='CaixaFerramenta.closePropriedades()'>Close</button></div>\n\
                                </div>"
                document.activeElement.appendChild(CxF);
                $("#BTCxPropriedades").css("cursor","all-scroll");

                $("#BTCxPropriedades").on("mousedown", function(){
                    $("#CxPropriedadesWEBDesign").draggable();
                });
                $("#BTCxPropriedades").on("mouseup", function(){
                    $("#CxPropriedadesWEBDesign").draggable("destroy");
                });
                
                $(".vDisplay").click(function(){
                    $(ObjetoSelecionado.getObjetoSelecionado()).fadeOut().fadeIn()
                })
                
                this.getProperty();    
                                
            }else{
                this.getProperty();    
            }
            

        }catch(e){
            console.log(e)
        }
        
        
    }
    
    CriarCaixaFerramenta(){
        try{
            let CxF = document.createElement("div");

            CxF.id = "CxFerramentaWEBDesign";
            CxF.className = "CxFerramentaWEB"

            CxF.innerHTML = "<div id='CxFInterna'>\n\
                                    <div id='BTCxFerramenta'>Caixa de Ferramenta</div>\n\
                                    <div id='CxBotoesFerramenta'></div>\n\
                                    <div style='\n\
                                            position: relative;\n\
                                            top: -37px;\n\
                                            left: -1;\n\
                                            width: 100%;\n\
                                            z-index: 9999999999'>\n\
                                        <button button='' type='button' class='btn btn-primary AtualizarDados' style='width: 101%;'>Atualizar</button>\n\
                                    </div>\n\
                            </div>"
            document.activeElement.appendChild(CxF);
            $("#BTCxFerramenta").css("cursor","all-scroll");

            $(".AtualizarDados").click(async function(){
               //var Formularios = document.getElementById("EditarPWEB");
               await CPaginaWEBAtualizar.EnviarFormularioEditar();
            });

            $("#BTCxFerramenta").on("mousedown", function(){
                $("#CxFerramentaWEBDesign").draggable();
            });
            $("#BTCxFerramenta").on("mouseup", function(){
                $("#CxFerramentaWEBDesign").draggable("destroy");
            });
            this.addBotoes();            
        }catch(e){
            console.log(e)
        }

    }
    
    showJanela(Janela){
            this.CustomJanelaModal(Janela);        
    }
    
/**
     * Seta os valores para a criação de uma janela bootstrap.
     * @param {object} o
     * @returns {void}
     */
    CustomJanelaModal(o){
        var Componentes = o; /*{
                                    Janela: {Nome: "myJanelas", Tipo: false, Tamanho: "300px"},
                                    Header: {Title: "Excluir", CorTexto: "", backgroundcolor: "#5cb85c"}, 
                                    Body: {Conteudo: Mensagem}, 
                                    Footer: {
                                                Cancelar: {Nome: "nao", Visible: "none", Funcao: function(){}}, 
                                                Aceitar: {Nome: "Close", Visible: "block", Funcao: function(){}}
                                            }
                                };

                        };*/
        
        if(Componentes.Janela.Tipo != false){
            $(".modal-dialog").removeClass("modal-sm").removeClass("modal-lg");
            $(".modal-dialog").addClass(Componentes.Janela.Tipo);
            $(".modal-dialog").css("width","inherit");
        }

        if(Componentes.Janela.Tamanho  != false){
            $(".modal-dialog").css("width",Componentes.Janela.Tamanho);
            $(".modal-dialog").css("max-width","100%");
        }
        
        $(".modal-header").css("background-color", Componentes.Header.backgroundcolor);
        $(".modal-title").html(Componentes.Header.Title);
        $(".modal-title").css("color", Componentes.Header.CorTexto);
        $(".modal-body").html(Componentes.Body.Conteudo);
        
        $(".cancelar").css("display", Componentes.Footer.Cancelar.Visible);
        $(".cancelar").html(Componentes.Footer.Cancelar.Nome);
        $(".cancelar").unbind();
        $(".cancelar").click(Componentes.Footer.Cancelar.Funcao);
        $(".cancelar").addClass(Componentes.Footer.Cancelar.classe);
        
        $(".ok").css("display", Componentes.Footer.Aceitar.Visible);
        $(".ok").html(Componentes.Footer.Aceitar.Nome);
        $(".ok").unbind();
        $(".ok").click(Componentes.Footer.Aceitar.Funcao);
        $(".ok").addClass(Componentes.Footer.Aceitar.classe);
        
        $("#" + Componentes.Janela.Nome).modal();
        
    }
    show(){
        alert(9)
    }
    


};

var CaixaFerramenta = new FOCJustInTime();

document.addEventListener("keydown", moverObjetosInternos, true);

function moverObjetosInternos(){
    if(addObjeto.getModoEdicao() && event.ctrlKey && (event.keyCode == 38)){ //Para cima
        let O = ObjetoSelecionado.getObjetoSelecionado();
        if(O){
            let ant = O.previousElementSibling
            if(!ant) return false;
            ant.before(O);
            ObjetoSelecionado.setRenderizarCFI();
        }
        console.log(event)
        
    }else if(addObjeto.getModoEdicao() && event.ctrlKey && (event.keyCode == 40)){//Para baixo
        let O = ObjetoSelecionado.getObjetoSelecionado();
        if(O){
            let ant = O.nextElementSibling
            if(!ant) return false;
            ant.after(O);
            ObjetoSelecionado.setRenderizarCFI();
        }
        
        console.log(event)
        
    }

}
