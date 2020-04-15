/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$.prototype.viewPopover = function(Cf){
    let Componente = this[0],
        Instpop = document.querySelector('#CxPover_'+ Componente.dataset.idn);
        if(Cf.Clear){
            let All = document.querySelectorAll('.viewpopovers');
            All.forEach(function(e,t,n){
                $(e).remove()
            })
                
            
        }
        if(Instpop) return false;
    var 
        Config = {
                    Position: "absolute", 
                    Top: 0, 
                    Left: 0,
                    CompAltura: Componente.offsetHeight,
                    CompLargura: Componente.offsetLeft,
                    eventClientX: event.clientX,
                    eventClientY: event.clientY,
                    eventOffsetX: event.offsetX,
                    eventOffsetY: event.offsetY,
                    CompOffsetHeight: Componente.offsetHeight,
                    CompOffsetLeft: Componente.offsetLeft,
                    CompOffsetTop: Componente.offsetTop,
                    CompOffsetWidth: Componente.offsetWidth,
                    backgroundColor: 'white',
                    boxshadow: '5px 4px 4px #4444441c'
                },
     CaixaPopover = "<div \n\
                            class='viewpopovers'\n\
                            id='CxPover_"+ Componente.dataset.idn +"' \n\
                            style='\n\
                                    position: {{Position}}; \n\
                                    top: {{Top}}px; \n\
                                    left: {{Left}}px;\n\
                                    transform: translate3d({{transX}}px, {{transY}}px, 0px);\n\
                                    z-index: 999999; \n\
                                    border: solid 1px #4444;\n\
                                    background-Color: {{backGround}};\n\
                                    box-shadow: {{boxShadow}};\n\
                                    padding: 9px;\n\
                                    border-radius: 5px;' >\n\
                        <div id='Titulo' style='\n\
                                padding: 6px;\n\
                                background-color: #eee8e8b8;\n\
                                position: relative;\n\
                                top: -9px;\n\
                                left: -9px;\n\
                                width: 108%;\n\
                                display: flex;\n\
                                border-radius: 4px;\n\
                                border-bottom: solid 1px #cdcdcd;\n\
                            '><div style='margin: auto;display: inline-block;\n\
                                width: 87%;'>{{Title}}\n\
                            </div>\n\
                            <div style='margin: auto;display: inline-block;\n\
                                width: 10%; cursor: pointer'><i class='material-icons close' id='Close_"+ Componente.dataset.idn +"'>highlight_off</i></div></div>\n\
                        <div>{{PopoverConteudo}}</div>\n\
                        <div>\n\
                            <i \n\
                                class='material-icons' \n\
                                style=' \n\
                                        font-size: 24px;\n\
                                        left: 43%;\n\
                                        position: absolute;\n\
                                        color: #cdcdcd'\n\
                            >\n\
                                keyboard_arrow_down\n\
                            </i>\n\
                        </div>\n\
                    </div>",
            Parametros = {Conteudo: "", Titulo: ""};
            Parametros = Cf;
            
    CaixaPopover = CaixaPopover.replace('{{Position}}',Config.Position)
    CaixaPopover = CaixaPopover.replace('{{Top}}',(Config.Top))
    CaixaPopover = CaixaPopover.replace('{{Left}}',Config.Left)
    CaixaPopover = CaixaPopover.replace('{{transX}}', (Config.eventClientX - Config.eventOffsetX + Config.CompLargura))
    CaixaPopover = CaixaPopover.replace('{{transY}}',(Config.eventClientY - Config.eventOffsetY + Config.CompAltura))
    CaixaPopover = CaixaPopover.replace('{{backGround}}',(Config.backgroundColor))
    CaixaPopover = CaixaPopover.replace('{{boxShadow}}',(Config.boxshadow))
    CaixaPopover = CaixaPopover.replace('{{Title}}',Parametros.Titulo)
    CaixaPopover = CaixaPopover.replace('{{PopoverConteudo}}',Parametros.Conteudo)


    $("body").append(CaixaPopover);
    var ObjetoPopover = document.querySelector("#CxPover_"+ Componente.dataset.idn);
    let 
        LarguraPopover = parseInt(ObjetoPopover.clientWidth / 2), 
        AlturaPopover = parseInt(ObjetoPopover.clientHeight)

        ObjetoPopover.style.transform = "translate3d("+ (Config.eventClientX - Config.eventOffsetX + Config.CompLargura - LarguraPopover + parseInt(Config.CompOffsetWidth/2)) + "px, " + (Config.eventClientY - Config.eventOffsetY + Config.CompAltura - AlturaPopover - 15) + "px, 0px)"
        
        $("#Close_" + Componente.dataset.idn).click(function(){
            $(ObjetoPopover).remove()
        })
};