<?php
/**
 * Possue algumas configurações, muito importantes, sobre o sistema. Exm.: Nome e senha da base de dados, nome do
 * banco de dados que será utilizado pelo sistema e outras configurações.
 */
include_once dirname(__DIR__) ."/../Config/Configuracao.php"; 

/**
 * Inclui o modelo abstrato de uma tabela no banco de dados.
 */
if(@!include_once ConfigSystema::get_Path_Systema() . '/BancoDados/TabelasBD/ModeloTabelas.php'){ 
    $ResultRequest["Erros"]["Modo"]        = "Include";
    $ResultRequest["Erros"][0]             = true;
    $ResultRequest["Erros"][1]             = 3588;
    $ResultRequest["Erros"][2]             = "O arquivo de configuração não foi encontrado. Controller";
    
    echo json_encode($ResultRequest);
    exit;
}; 



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Classe que será utilizada para todo o sistema que exija login.
 * Essa classe poderá ser alterada de maneira a se encaixar no modelo atual de login.
 *
 * @author 04953988612
 */
class login extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo dentro da tabela no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD.
                */
               "Field"          => "usuario",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "Usuário",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>""
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]   ,
            [
               "Index"          => 1,                                   //Ordem dos campos
               "Field"          => "senha",                       //Nome original do campo (String)
               "CodNome"        => "Senha",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 2,                                   //Ordem dos campos
               "Field"          => "tipousuario",                       //Nome original do campo (String)
               "CodNome"        => "TipoUsuario",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 3,                                   //Ordem dos campos
               "Field"          => "habilitado",                       //Nome original do campo (String)
               "CodNome"        => "Habilitado",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 4,                                   //Ordem dos campos
               "Field"          => "tentativa",                       //Nome original do campo (String)
               "CodNome"        => "Tentativas",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ]
        ];
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return true;
    }

    public function getNomeReal() {
        return "historico";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        //["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>true, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>true, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }

    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }

    public function Jobs($Tipo, &$ConjuntoDados) {
        switch ($Tipo) {
            case "InserirDados":


                break;

            default:
                break;
        }
    }

    public function getTotalPageVisible() {
        
    }

    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class historico extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,                               //Ordem dos campos
               "Field"          => "idHistorico",                    //Nome original do campo (String)
               "CodNome"        => "idHistorico",                    //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                        //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                              //Contém o filtro padrão para o campo
               "Filter"         => false,                           //Exibe ícone para realizar filtro por campo
               "ValorPadrao"    => "44",                            //(String) Contém um valor que é considerado padrão
               "Key"            => [true, false],                    //Chave primária (boolean)
               "ChvExt"         => ["TExt" => false,"Campo"=>""],              //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                            //Editável - (boolean)  
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 1,                               //Ordem dos campos
               "Field"          => "idMaquinas",                    //Nome original do campo (String)
               "CodNome"        => "idMaquinas",                    //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                       //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                              //Contém o filtro padrão para o campo. [["like","rf0654%"]]
               "Filter"         => false,                           //Exibe ícone para realizar filtro por campo
               "ValorPadrao"    => "44",                            //(String) Contém um valor que é considerado padrão
               "Key"            => [true, false],                    //Chave primária (boolean)
               "ChvExt"         => ["TExt" => false,"Campo"=>""],              //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                            //Editável - (boolean)  
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 2,                               //Ordem dos campos
               "Field"          => "NomeAnterior",                    //Nome original do campo (String)
               "CodNome"        => "NA",                            //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                       //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                              //Contém o filtro padrão para o campo
               "Filter"         => false,                           //Exibe ícone para realizar filtro por campo
               "ValorPadrao"    => "44",                            //(String) Contém um valor que é considerado padrão
               "Key"            => [false, false],                    //Chave primária (boolean) e se é visible na tabela
               "ChvExt"         => ["TExt" => false,"Campo"=>""],              //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => true,                            //Editável - (boolean)  (caso o campo seja visivel essa propriedade impede sua alteração)
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"textarea", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Anterior", 
                                        "Patterns"=> "", 
                                        "Titles" => "Este campo deve ser preenchido",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
            [
               "Index"          => 3,                               //Ordem dos campos
               "Field"          => "Destino",                    //Nome original do campo (String)
               "CodNome"        => "Destinos",                            //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                       //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                              //Contém o filtro padrão para o campo
               "Filter"         => true,                           //SEM UTLIZAÇÃO NO MOMENTO - Marca o campo se for capaz de realizar filtro.
               "ValorPadrao"    => "44",                            //(String) Contém um valor que é considerado padrão
               "Key"            => [false, false],                    //Chave primária (boolean) e se é visible na tabela
               "ChvExt"         => ["TExt" => false,"Campo"=>""],              //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => true,                            //Editável - (boolean)  (caso o campo seja visivel essa propriedade impede sua alteração)
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["email"], 
                                        "Name" => "Dest", 
                                        "Patterns"=> "", 
                                        "Titles" => "Este campo deve ser preenchido",
                                        "Required" => "",
                                        "width" => "50px",
                                        "height"=>"50px",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true                             //SEM UTILIZAÇÃO NO MOMENTO.
           ],
            [
               "Index"          => 4,                               //Ordem dos campos
               "Field"          => "",                              //Nome original do campo (String)
               "CodNome"        => "Destfdfdinos",                            //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                       //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                              //Contém o filtro padrão para o campo
               "Filter"         => true,                           //SEM UTLIZAÇÃO NO MOMENTO - Marca o campo se for capaz de realizar filtro.
               "ValorPadrao"    => "44",                            //(String) Contém um valor que é considerado padrão
               "Key"            => [false, false],                    //Chave primária (boolean) e se é visible na tabela
               "ChvExt"         => ["TExt" => false,"Campo"=>""],              //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => true,                            //Editável - (boolean)  (caso o campo seja visivel essa propriedade impede sua alteração)
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["email"], 
                                        "Name" => "Dest", 
                                        "Patterns"=> "", 
                                        "Titles" => "Este campo deve ser preenchido",
                                        "Required" => "",
                                        "width" => "50px",
                                        "height"=>"50px",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true,                             //SEM UTILIZAÇÃO NO MOMENTO.
               
           ]
        ];
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> false, "Filtros"=>true, "BRefresh"=>true];

    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 2;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        ["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }

    public function getNomeReal() {
        
    }

    public function getVirtual() {
        
    }

    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[4] = [Exist=>false, Valor=>"sim"];
        return $ValorPadraoCampos[$idx];
    }

    public function getPrivBD() {
        
    }

    public function getFiltrosCampo($idx) {
        
    }

    public function Jobs($Tipo, &$ConjuntoDados) {
        switch ($Tipo) {
            case "getArrayDados":
                    $ConjuntoDados[0][] = $_REQUEST["enviarChaves"];

                break;

            default:
                break;
        };
    }

    public function getTotalPageVisible() {
        return 8;
    }

    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class rhist extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,                                   //Ordem dos campos
               "Field"          => "idHistorico",                       //Nome original do campo (String)
               "CodNome"        => "idHistorico",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               //"Filtro"         => [],                                  //Contém o filtro padrão para o campo
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [true, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
           [
               "Index"          => 1,                                   //Ordem dos campos
               "Field"          => "idMaquinas",                        //Nome original do campo (String)
               "CodNome"        => "Máquina",                           //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               //"Filtro"         => [],                                  //Contém o filtro padrão para o campo
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [true, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => true,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 2, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,                //Quando utilizar terá que ser button ou select
                                        "Placeholder"=> "", 
                                        "readonly"=>true ,              //Utilizado para desabilitar campo no formulário - uso chave estrangeira.
                                        "TypeComponente"=>"button", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Máquina", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
           [
               "Index"          => 2,                                   //Ordem dos campos
               "Field"          => "NomeNovo",                          //Nome original do campo (String)
               "CodNome"        => "Novo",                              //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                            //Tipo de conteudo exibido na tabela HTML
               "Filtro"         => [],                                  //Contém o filtro padrão para o campo
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                      //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> "//"],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Nome Novo", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>true
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
           [
               "Index"          => 3,                               //Ordem dos campos
               "Field"          => "NomeAnterior",                    //Nome original do campo (String)
               "CodNome"        => "Maquinas",                    //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                        //Tipo de conteudo exibido na tabela HTML
               //"Filtro"         => [],                              //Contém o filtro padrão para o campo
               "Filter"         => false,                           //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                    //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                           // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                            //Editável - (boolean)  
               "Visible"        => true,                            //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> "/^9.*/"],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Nome Anterior", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                           //Informa se o campo fará parte do formulários
               "OrdemBY"        => false
           ]        
        ];
    private $Privilegios = [["Alexandre","Update"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return true;
    }

    public function getNomeReal() {
        return "historico";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 5;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='material-icons'>bluetooth</i>",
                            "NomeBotao"=>"Localizar", 
                            "Icone" => "fa fa-search", 
                            "Func" => 0, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca"
                        ]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>true, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>true, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Informa que a dados para verificação do privilégio ocorrerá através do BD
     * @return boolean
     */
    public function getPrivBD() {
        return true;
    }
    /**
     * Busca, através do index, o filtro para aquele campo. O método é executado para cada campo na tabela.
     * Obs.: Como o filtro é executado para cada campo, os métodos para cada campo serão executadas mesmo que o
     * index não seja o correspondente ao campo, por isso, tomar cuidado para não criar métodos que gastam muito processamento,
     * pois ai, para cada campo, será executado o método que consome muito processamento.
     * @param int $idx
     * @return array
     */
    public function getFiltrosCampo($idx) {
        //$Campo[3] = [["like","%12321"]];
        
        return $Campo[$idx];
    }

    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }

    public function getTotalPageVisible() {
        return 5;
    }

    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class bancoimagem extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,                                   //Ordem dos campos
               "Field"          => "idImagem",                       //Nome original do campo (String)
               "CodNome"        => "ID",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [true, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
           [
               "Index"          => 1,                                   //Ordem dos campos
               "Field"          => "path",                        //Nome original do campo (String)
               "CodNome"        => "Destino",                           //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 2, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,                //Quando utilizar terá que ser button ou select
                                        "Placeholder"=> "", 
                                        "readonly"=>false ,              //Utilizado para desabilitar campo no formulário - uso chave estrangeira.
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Destino", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>true,
                                        "checked"=>"",
                                        "dirname"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ]      ,
           [
               "Index"          => 2,                                   //Ordem dos campos
               "Field"          => "Titulo",                        //Nome original do campo (String)
               "CodNome"        => "Título",                           //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 2, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,                //Quando utilizar terá que ser button ou select
                                        "Placeholder"=> "", 
                                        "readonly"=>false ,              //Utilizado para desabilitar campo no formulário - uso chave estrangeira.
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["number"], 
                                        "Name" => "titulo", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>2,
                                        "size"=>"",
                                        "min"=>3,
                                        "max"=>100,
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ] ,
           [
               "Index"          => 3,                                   //Ordem dos campos
               "Field"          => "descricao",                        //Nome original do campo (String)
               "CodNome"        => "Descrição",                           //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 2, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,                //Quando utilizar terá que ser button ou select
                                        "Placeholder"=> "", 
                                        "readonly"=>false ,              //Utilizado para desabilitar campo no formulário - uso chave estrangeira.
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "descricao", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ]
        ];
    private $Privilegios = [["Alexandre","Select/Update/Insert/Delete"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return false;
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                            "NomeBotao"=>"Localizar", 
                            "Icone" => "fa fa-search", 
                            "Func" => 0, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca"
                        ],
[
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                            "NomeBotao"=>"Localizar2", 
                            "Icone" => "fa fa-android", 
                            "Func" => 1, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca"
                        ]            
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * É obrigatório a criação, para todos os campos, do valor padrão. Lembrando que se o campo não terá valores padrões
     * será necessário a troca para false dos campos respectivos.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false,  Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false , Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false , Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false,  Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a verificação dos privilégios dos usuários nas tabelas através do banco de dados.
     * Obs.: Uma tabela criada especificamente para essa finalidade deverá estar contida na base de dados
     * e devidamente preenchida com os privilégios.
     * @return boolean
     */
    public function getPrivBD() {
        return false;
    }
    /**
     * Busca, através do index, o filtro para aquele campo. O método é executado para cada campo na tabela.
     * Obs.: Como o filtro é executado para cada campo, os métodos para cada campo serão executadas mesmo que o
     * index não seja o correspondente ao campo, por isso, tomar cuidado para não criar métodos que gastam muito processamento,
     * pois ai, para cada campo, será executado o método que consome muito processamento.
     * @param int $idx
     * @return array
     */
    public function getFiltrosCampo($idx) {
        //$Campo[3] = [["like","%12321"]];
        
        return $Campo[$idx];
    }
    /**
     * Funções anônimas são funções que não estão predefinidas, por isso, são de grande valia.
     * @param int $Tipo O nome da função que a chamou.
     * @param Array $ConjuntoDados Conjunto de dados, sob parâmetro de referência, que serão utilizados dentro da função.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
        switch ($Tipo) {
            case "ExcluirDadosTabela":
                
                return true;
                break;
            
            case "getArrayDados":
                //$ConjuntoDados[0][2] = "3";
                break;
            default:
                break;
        }
    }

    public function getTotalPageVisible() {
        return 5;
    }

    public function validarConteudoCampoRegex(&$Dados) {
        foreach ($Dados as $key => $value) {
            
            switch ($value["name"]) {
                case "Destino":
                    /*$Valido = preg_match_all("/dsd/", $value["value"]);
                    if(!$Valido){
                        throw new Exception("Valor do campo: ". $value["name"] . " não é válido!");
                    }*/

                    break;

                default:
                    break;
            }
            
        }
        
    }

}

class post extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,                                   //Ordem dos campos
               "Field"          => "idpost",                       //Nome original do campo (String)
               "CodNome"        => "ID",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [true, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> ""
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>"",
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ],
           [
               "Index"          => 1,                                   //Ordem dos campos
               "Field"          => "post",                        //Nome original do campo (String)
               "CodNome"        => "Destino",                           //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Exibe ícone para realizar filtro por campo
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 2, 
                                        "Funcao"=> 0, 
                                        "NomeBotao"=> "Selecionar"
                                    ],   //Chave estrangeira
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,                //Quando utilizar terá que ser button ou select
                                        "Placeholder"=> "", 
                                        "readonly"=>false ,              //Utilizado para desabilitar campo no formulário - uso chave estrangeira.
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Destino", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "",
                                        "height"=>"",
                                        "step"=>"",
                                        "size"=>"",
                                        "min"=>"",
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        "autofocus"=>true,
                                        "checked"=>"",
                                        "dirname"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => true
           ]                                  //Informa se o campo fará parte do formulários
               

        ];
    private $Privilegios = [["Alexandre","Select/Update/Insert/"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return false;
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                            "NomeBotao"=>"Localizar", 
                            "Icone" => "fa fa-search", 
                            "Func" => 0, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca"
                        ],
[
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                            "NomeBotao"=>"Localizar2", 
                            "Icone" => "fa fa-android", 
                            "Func" => 1, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca"
                        ]            
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * É obrigatório a criação, para todos os campos, do valor padrão. Lembrando que se o campo não terá valores padrões
     * será necessário a troca para false dos campos respectivos.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false,  Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false , Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false , Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false,  Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a verificação dos privilégios dos usuários nas tabelas através do banco de dados.
     * Obs.: Uma tabela criada especificamente para essa finalidade deverá estar contida na base de dados
     * e devidamente preenchida com os privilégios.
     * @return boolean
     */
    public function getPrivBD() {
        return false;
    }
    /**
     * Busca, através do index, o filtro para aquele campo. O método é executado para cada campo na tabela.
     * Obs.: Como o filtro é executado para cada campo, os métodos para cada campo serão executadas mesmo que o
     * index não seja o correspondente ao campo, por isso, tomar cuidado para não criar métodos que gastam muito processamento,
     * pois ai, para cada campo, será executado o método que consome muito processamento.
     * @param int $idx
     * @return array
     */
    public function getFiltrosCampo($idx) {
         
        return $Campo[$idx];
    }
    /**
     * Funções anônimas são funções que não estão predefinidas, por isso, são de grande valia.
     * @param int $Tipo O nome da função que a chamou.
     * @param Array $ConjuntoDados Conjunto de dados, sob parâmetro de referência, que serão utilizados dentro da função.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
        switch ($Tipo) {
            case "ExcluirDadosTabela":
                
                return true;
                break;
            
            case "getArrayDados":
                //$ConjuntoDados[0][2] = "3";
                break;
            default:
                break;
        }
    }

    public function getTotalPageVisible() {
        return 5;
    }

    public function validarConteudoCampoRegex(&$Dados) {
        foreach ($Dados as $key => $value) {
            
            switch ($value["name"]) {
                case "Destino":
                    /*$Valido = preg_match_all("/dsd/", $value["value"]);
                    if(!$Valido){
                        throw new Exception("Valor do campo: ". $value["name"] . " não é válido!");
                    }*/

                    break;

                default:
                    break;
            }
            
        }
        
    }

}

class pwcabecalhopadrao extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "idTPD",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idTPD",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [true, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 1,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "chExtPWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "chExtPWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]
        ];
    
    /**
     * Contém os privilégios de cada usuário para acesso à tabela.
     * @var array 
     */
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    /**
     * Contém a configuração da exibição do componente tabela html
     * @var array 
     */
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    /**
     * Informa ao sistema as configurações para visualização do componente tableHTML
     * @return array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return "";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }
    /**
     * Habilita a visualização da coluna numeração na tabela HTML
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna com ícones e com extensão para funções personalizadas para cada ícone.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        //["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Retorna true ou false para usar uma tabela de privilégio no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }
    /**
     * 
     * @param CallFunction  $Tipo Qual método que chamou esse job, pode ser um select, insert, delete ou update.
     * @param Array         $ConjuntoDados Conjunto de dados que serão tratador.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Retorna o total de páginas que serão visualizadas de uma vez.
     */
    public function getTotalPageVisible() {
        
    }
    /**
     * Valida, antes de ser iserido no banco de dados, o conteúdo de cada campo.
     * @param array $Dados Conjunto de campos e valores que serão validados antes de entrarem no banco de dados.
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class pwebpriv extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "idPWEBDIV",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idPWEBDIV",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [true, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 1,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "chExtPWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "chExtPWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]
        ];
    
    /**
     * Contém os privilégios de cada usuário para acesso à tabela.
     * @var array 
     */
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    /**
     * Contém a configuração da exibição do componente tabela html
     * @var array 
     */
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    /**
     * Informa ao sistema as configurações para visualização do componente tableHTML
     * @return array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return "";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }
    /**
     * Habilita a visualização da coluna numeração na tabela HTML
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna com ícones e com extensão para funções personalizadas para cada ícone.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        //["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Retorna true ou false para usar uma tabela de privilégio no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }
    /**
     * 
     * @param CallFunction  $Tipo Qual método que chamou esse job, pode ser um select, insert, delete ou update.
     * @param Array         $ConjuntoDados Conjunto de dados que serão tratador.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Retorna o total de páginas que serão visualizadas de uma vez.
     */
    public function getTotalPageVisible() {
        
    }
    /**
     * Valida, antes de ser iserido no banco de dados, o conteúdo de cada campo.
     * @param array $Dados Conjunto de campos e valores que serão validados antes de entrarem no banco de dados.
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class pwebdiv extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "idPWEBDIV",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idPWEBDIV",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [true, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 1,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "chExtPWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "chExtPWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 2,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BTY",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BTY",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 3,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BSC",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BSC",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 4,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BMS",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BMS",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 5,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BLE",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BLE",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 6,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BLD",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BLD",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 7,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BST",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BST",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 8,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "BCT",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "BCT",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]
        ];
    
    /**
     * Contém os privilégios de cada usuário para acesso à tabela.
     * @var array 
     */
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    /**
     * Contém a configuração da exibição do componente tabela html
     * @var array 
     */
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    /**
     * Informa ao sistema as configurações para visualização do componente tableHTML
     * @return array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return "";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }
    /**
     * Habilita a visualização da coluna numeração na tabela HTML
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna com ícones e com extensão para funções personalizadas para cada ícone.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        //["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Retorna true ou false para usar uma tabela de privilégio no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }
    /**
     * 
     * @param CallFunction  $Tipo Qual método que chamou esse job, pode ser um select, insert, delete ou update.
     * @param Array         $ConjuntoDados Conjunto de dados que serão tratador.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Retorna o total de páginas que serão visualizadas de uma vez.
     */
    public function getTotalPageVisible() {
        
    }
    /**
     * Valida, antes de ser iserido no banco de dados, o conteúdo de cada campo.
     * @param array $Dados Conjunto de campos e valores que serão validados antes de entrarem no banco de dados.
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class paginaweb extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "idPWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idPWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [true, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 1,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "URLPagina",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PaginaWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 2,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWTitulo",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWTitulo",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 3,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWStyle",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWStyle",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 4,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWScript",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWScript",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"textarea",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWHead", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 5,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWIMG",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWIMG",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 6,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWBMS",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWBMS",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWBMS", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 7,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWBLD",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWBLD",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWBLD", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 8,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWBLE",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWBLE",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWBLE", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 9,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWBST",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWBST",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWBST", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 10,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "PWCNT",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PWCNT",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"textarea",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PWCNT", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 11,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "Status",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "Status",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"textarea",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]
        ];
    
    /**
     * Contém os privilégios de cada usuário para acesso à tabela.
     * @var array 
     */
    private $Privilegios = [["Alexandre","Select/Insert/Update/Delete"],["Pedro","Select"]];
    /**
     * Contém a configuração da exibição do componente tabela html
     * @var array 
     */
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    /**
     * Informa ao sistema as configurações para visualização do componente tableHTML
     * @return array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return "";
    }

    public function setNomeTabela() {
        $this->NomeTabela = __CLASS__ ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "MÁQUINAS NO DOMÍNIO";
    }

    public function getLimite() {
        return 30;
    }
    /**
     * Habilita a visualização da coluna numeração na tabela HTML
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna com ícones e com extensão para funções personalizadas para cada ícone.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        //["NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>","NomeBotao"=>"Localizar", "Icone" => "fa fa-search", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "busca"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[3] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[4] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[5] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[6] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[7] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[8] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[9] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[10] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[11] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Retorna true ou false para usar uma tabela de privilégio no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }
    /**
     * 
     * @param CallFunction  $Tipo Qual método que chamou esse job, pode ser um select, insert, delete ou update.
     * @param Array         $ConjuntoDados Conjunto de dados que serão tratador.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Retorna o total de páginas que serão visualizadas de uma vez.
     */
    public function getTotalPageVisible() {
        
    }
    /**
     * Valida, antes de ser iserido no banco de dados, o conteúdo de cada campo.
     * @param array $Dados Conjunto de campos e valores que serão validados antes de entrarem no banco de dados.
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class paginawebeditar extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
           
            [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 0,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "idPWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idPWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => [],       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [true, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> false,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ],
        [
              /**
               * Esse índice é utilizado em todo o sistema, através dele o sistema pode buscar o nome, real do campo,
               * e outras informações.
               */
               "Index"          => 1,
               /**
                * Nome real do campo, dentro da tabela, no banco de dados. É utilizado pelo sistema para criar as intruções
                * SQL de CRUD, mas se seu valor for em branco o sistema irá tratá-lo como um campo virtual, podendo ser
                * utilizado os métodos jobs e outros para gerar conteúdo para o cliente navegador.
                */
               "Field"          => "URLPagina",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "PaginaWEB",
                /**
                 * Tipo de conteúdo e de campo que será utilizado para edição ou visualização dentro dos componentes
                 * Js na página WEB via HTML. Atualmente está mapeado o text e imagem no componente tableHTML. Mas os componentes poderão
                 * ser implementados com qualquer tipo, desde que cada um trate-os.
                 */
               "TypeConteudo"   => ["text"],
                /**
                 * Habilita ou não o uso de filtro pelo campo. [true|false]
                 */
               "Filter"         => true,       
                /**
                 * Informa ao sistema que o campo atual é uma chave primária e se ela será exibida ou não ao usuário.
                 */
               "Key"            => [false, false],
                /**
                 * Informa ao sistema que esse campo possue uma chave extrangeira vinculada.
                 */
               "ChvExt"         => [    
                                        /**
                                         * TExt - Tabela Extrangeira
                                         * Informa ao sistema que o campo atual possue uma tabela extrangeira.
                                         */
                                        "TExt" => false,
                                        /**
                                         * Nome da tabela extrangeira.
                                         */
                                        "Tabela"=> "",
                                        /**
                                         * Índice do campo da tabela extrangeira que está vinculado à este campo.
                                         */
                                        "IdxCampoVinculado"=> 0, 
                                        /**
                                         * Índice da função que representa esta relação.
                                         */
                                        "Funcao"=> 0,
                                        /**
                                         * Nome do botão que será exibido na tabela HTML.
                                         */
                                        "NomeBotao"=> ""
                                    ],
                /**
                 * Campo com funções ainda não definidos.
                 */
               "Mask"           => false,
                /**
                 * Informa ao sistema se o campo será editável ou não.
                 */
               "Editar"         => false,
                /**
                 * Informa se o campo será visível na tabela HTML.
                 */
               "Visible"        => true,
                /**
                 * Campo com utilização futura. Apesar do regexr ser implementado via método dentro de cada class.
                 */
               "Regex"          => [Exist=> false, Regx=> ""],
                /**
                 * Subarray - informa se o campo será atualizável
                 */
               "Formulario"     => [
                                        /**
                                         * Informa ao sistema que o campo será atualizável.
                                         */
                                        "Exibir"=> true,
                                        /**
                                         * Texto explicativo que ficará dentro do campo input type text
                                         */
                                        "Placeholder"=> "", 
                                        /**
                                         * Tipo de componente que será visualizado no formulário. inputbox, select
                                         */
                                        "TypeComponente"=>"inputbox",
                                        /**
                                         * Usado conjuntamente com o campo anterior.
                                         */
                                        "TypeConteudo"=> ["text"],
                                        /**
                                         * Nome do campo que será exportado para o controller, esse campo deverá ter o nome diferente do nome
                                         * original por motivo de segurança
                                         */
                                        "Name" => "PaginaW", 
                                        /**
                                         * Regex do campo input text
                                         */
                                        "Patterns"=> "",
                                        /**
                                         * Informação que será exibida quando o cursor fixa em cima do componente.
                                         */
                                        "Titles" => "",
                                        /**
                                         * Campo terá preenchimento obrigatório.
                                         */
                                        "Required" => "",
                                        /**
                                         * Tamanho do campo
                                         */
                                        "width" => "50px",
                                        "height"=>"",
                                        /**
                                         * Salto dos números na caixa do tipo number
                                         */
                                        "step"=>"",
                                        /**
                                         * 
                                         */
                                        "size"=>"",
                                        /**
                                         * Número mínimo dentro da caixa do tipo number
                                         */
                                        "min"=>"",
                                        /**
                                         * Número máximo dentro da caixa do tipo number
                                         */
                                        "max"=>"",
                                        "maxlength"=>"",
                                        "form"=>"",
                                        "formaction"=>"",
                                        "formenctype"=>"",
                                        "formmethod"=>"",
                                        "formnovalidate"=>"",
                                        "formtarget"=>"",
                                        "align"=>"",
                                        "alt"=>"",
                                        "autocomplete"=>"",
                                        /**
                                         * Autofocus
                                         */
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        /**
                                         * Campo será somente leitura
                                         */
                                        "readonly"=>"",
                                        /**
                                         * Utiliza o editor de texto web via js
                                         */
                                        "EditorText"=> true
                                    ],
               /**
                * Informa ao sistema que o campo deverá, via tabela html, a opção de ordernar o campo.
                */
               "OrdemBY"        => true
           ]
        ];
    
    /**
     * Contém os privilégios de cada usuário para acesso à tabela.
     * @var array 
     */
    private $Privilegios = [["Alexandre","Select/"],["Pedro","Select"]];
    /**
     * Contém a configuração da exibição do componente tabela html
     * @var array 
     */
    private $TipoPaginacao = ["Simples"=>true, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    /**
     * Informa ao sistema as configurações para visualização do componente tableHTML
     * @return array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
    }

    public function getNomeReal() {
        return "";
    }

    public function setNomeTabela() {
        $this->NomeTabela = "paginaweb" ;
    }

    public function getCampos() {
        return $this->Campos;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getTituloTabela() {
        return "EDITAR PÁGINAS WEB";
    }

    public function getLimite() {
        return 30;
    }
    /**
     * Habilita a visualização da coluna numeração na tabela HTML
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna com ícones e com extensão para funções personalizadas para cada ícone.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true;
        $Icones = [
                        ["NomeColuna"=> "<i class='material-icons' style='font-size:19px'>pages</i>","NomeBotao"=>"Localizar", "Icone" => "far fa-file-word", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "Caregar página WEB"]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * A idéia do método é possibilitar o retorno de valor padrão baseado em qualquer outro método.
     * @param int $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        $ValorPadraoCampos[0] = [Exist=>false, Valor=>"sim"];
        $ValorPadraoCampos[1] = [Exist=>false, Valor=>"sim"];
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Retorna true ou false para usar uma tabela de privilégio no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Método muito importante para o sistema. 
     * Através deste método, podemos criar os filtros padrões de cada campo.
     * O método foi criado com o intuito de se poder criar qualquer tipo de filtro padrão.
     * Ex.: $Filtro[0] = ["like","%fd%"]
     */
    public function getFiltrosCampo($idx) {
        
    }
    /**
     * 
     * @param CallFunction  $Tipo Qual método que chamou esse job, pode ser um select, insert, delete ou update.
     * @param Array         $ConjuntoDados Conjunto de dados que serão tratador.
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Retorna o total de páginas que serão visualizadas de uma vez.
     */
    public function getTotalPageVisible() {
        return 5;
    }
    /**
     * Valida, antes de ser iserido no banco de dados, o conteúdo de cada campo.
     * @param array $Dados Conjunto de campos e valores que serão validados antes de entrarem no banco de dados.
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}