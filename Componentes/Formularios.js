/* 
 * Date 11/07/2020
 * Cria formulários de preenchimento com base em uma base de dados
 */

class FormHTML extends JSController{
    
    constructor(Caminho){
        super(Caminho);
        this.DadosEnvio.sendPagina = 1;
        this.DadosEnvio.sendFiltros = [false, false, false];
    }

    set ChaveRegistro(Chv){
        
    }
   
}
