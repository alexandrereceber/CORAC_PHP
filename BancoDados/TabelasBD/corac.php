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
    $ResultRequest["Erros"][1]             = 7000;
    $ResultRequest["Erros"][2]             = "O arquivo de configuração não foi encontrado.";
    
    echo json_encode($ResultRequest);
    exit;
}; 

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
                                        "Name" => "username", 
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
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
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
                                        "Name" => "password", 
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
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
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
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
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
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
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
                                        "Name" => "Tentativa", 
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
           ] ,
            [
               "Index"          => 5,                                   //Ordem dos campos
               "Field"          => "idLogin",                       //Nome original do campo (String)
               "CodNome"        => "ID",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["texto"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
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
                                        "Name" => "password", 
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
    //private $Privilegios = [["CORAC","Select/Insert/Update/Delete"]];
    private $Privilegios = [["CORAC","Select/Insert/Update/Delete"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return false;
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
        return "USUÁRIOS CADASTRADOS NO SISTEMA";
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
    public function getFiltrosCampo() {
        
    }

    public function Jobs($Tipo, &$ConjuntoDados, $Action, $Resultado) {
        
    }

    public function getTotalPageVisible() {
        
    }

    public function validarConteudoCampoRegex(&$Dados) {
        foreach ($Dados as $key => $value) {
            $Valido = preg_match("/script|<script>|!|;/i", $Dados[$key]["value"]);
            if($Valido){ 
                $Campo = $Dados[$key]["name"];
                throw new PDOException("O conteúdo do campo: $Campo contém valores inválidos!", 10001);
            }

        }
    }

    public function NormalizarFiltro($Tipo) {
        
    }

}

class Computadores extends ModeloTabelas{
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
               "Field"          => "idEquipamentos",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "idEquipamentos",
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
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
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
               "Field"          => "idTipo",                       //Nome original do campo (String)
               "CodNome"        => "Tipo",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => true,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "tipoequipamentos",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "Tipo",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>["idTipo","Nome"]
                                    ], 
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => false,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"select", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Tipo", 
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
               "OrdemBY"        => false
           ],
            [
               "Index"          => 2,                                   //Ordem dos campos
               "Field"          => "Tipo",                       //Nome original do campo (String)
               "CodNome"        => "Tipo",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
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
               "Field"          => "Nome",                       //Nome original do campo (String)
               "CodNome"        => "Nome",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Habilita a visualização da caixa popv para filtro e classificação
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
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Nome", 
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
               "Field"          => "Ligada",                       //Nome original do campo (String)
               "CodNome"        => "Ligada",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"select", 
                                        "TypeConteudo"=> ["","Ligada","Desligada"], 
                                        "Name" => "Ligada", 
                                        "Patterns"=> "", 
                                        "Titles" => "",
                                        "Required" => true,
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
               "OrdemBY"        => false
           ] 
        ];
    //private $Privilegios = [["CORAC","Select/Insert/Update/Delete"]];
    private $Privilegios = [["CORAC","Select/Insert/Update/Delete"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return true;
    }

    public function getNomeReal() {
        return "equipamentos";
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
        return false;
    }

    public function getLimite() {
        return 30;
    }

    public function getMostrarContador() {
        return true;
    }

    public function showColumnsIcones() {
        $Habilitar = false;
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
    public function getFiltrosCampo() {
        
    }

    public function Jobs($Tipo, &$ConjuntoDados, $Action, $Resultado) {
        switch ($Tipo){
            case "InserirDadosTabela":
                if($Action == "BeforeInsert"){
                    $this->beginTransaction();
                }
                if($Action == "AfterInsert"){
                    if($Resultado){
                        $lastID_Insert = $this->GetUltimoID();
                        $t = $this->GetLinhasAtingidas();  
                        $this->commit();

                    }else{
                        $this->rollBack();
                    }

                }
                
                break;
            default :
                
                break;
        }
    }

    public function getTotalPageVisible() {
        
    }

    public function validarConteudoCampoRegex(&$Dados) {

    }

    public function NormalizarFiltro($Tipo) {
        
    }

}

class vagentesautonomos extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Campos =  [
                       
            [
               "Index"          => 0,                                   //Ordem dos campos
               "Field"          => "idEquipamento",                       //Nome original do campo (String)
               "CodNome"        => "idEquipamento",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [true, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[]
                                    ], 
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => false,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
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
                                        "dirname"=>"",
                                        "readonly"=>""
                                    ],                                  //Informa se o campo fará parte do formulários
               "OrdemBY"        => false
           ],
            [
               "Index"          => 1,                                   //Ordem dos campos
               "Field"          => "Nome",                       //Nome original do campo (String)
               "CodNome"        => "Nome",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => true,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
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
               "Field"          => "Registro",                       //Nome original do campo (String)
               "CodNome"        => "Registro",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "Registro", 
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
               "OrdemBY"        => false
           ] ,
            [
               "Index"          => 3,                                   //Ordem dos campos
               "Field"          => "Status",                       //Nome original do campo (String)
               "CodNome"        => "Status",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"select", 
                                        "TypeConteudo"=> ["","Ativado","Desativado"], 
                                        "Name" => "Status", 
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
               "OrdemBY"        => false
           ],
            [
               "Index"          => 4,                                   //Ordem dos campos
               "Field"          => "dtCriado",                       //Nome original do campo (String)
               "CodNome"        => "Data",                       //Codnome do campo, o que será visualizado pelo usuário (String)
               "TypeConteudo"   => ["text"],                           //Tipo de conteudo exibido na tabela HTML
               "Filter"         => false,                               //Habilita a visualização da caixa popv para filtro e classificação
               "Key"            => [false, false],                       //Chave primária (boolean)
               "ChvExt"         => [        
                                        "TExt" => false,                 //Indica que existe chave extrangeira
                                        "Tabela"=> "",  //nome da tabela extrangeira
                                        /**
                                         * Informa o índice do campo que será utilizado para recuperar o valor que será enviado para armazenamento
                                         * na chave extrangeira. 
                                         */
                                        "IdxCampoVinculado"=> 0,
                                        /*
                                         * Campo que desempenha uma função muito importante em relação às chaves extrangeiras.
                                         * Caso esteja com seu valor false, significa que os dados da tabela extrangeira serão
                                         * resgatadas por uma função interna a classe ModeloTabelas.php e disponibilizado´s em um variável interna de
                                         * Nome: DadosTblExt.
                                         * Caso sejá informado um número inteiro, será utilizada uma função pré-definada no componente tabelas.js.
                                         */
                                        "Funcao"=> false,                   
                                        "NomeBotao"=> "",            //texto do botão que será visualizado na página
                                        /**
                                         * Informa o nome real dos campos da tabela extrangeira que serão recuperados para envio
                                         * à tabela html.
                                         */
                                        "CamposTblExtrangeira"=>[""]
                                    ],
               "Mask"           => false,                               // Máscara (String) Contém a máscara que será utilizada pelo campo
               "Editar"         => false,                               //Editável - (boolean)  
               "Visible"        => true,                                //Mostrar na tabela HTML (boolean)
               "Regex"          => [Exist=> false, Regx=> ""],                               //Regex que será utilizada.
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox", 
                                        "TypeConteudo"=> ["text"], 
                                        "Name" => "dtCriado", 
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
               "OrdemBY"        => false
           ]
        ];
    //private $Privilegios = [["CORAC","Select/Insert/Update/Delete"]];
    private $Privilegios = [["CORAC","Select//Update/Delete"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];
    
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function getVirtual() {
        return true;
    }

    public function getNomeReal() {
        return "agentesautonomos";
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
        return false;
    }

    public function getLimite() {
        return 30;
    }

    public function getMostrarContador() {
        return false;
    }

    public function showColumnsIcones() {
        $Habilitar = false;
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
    public function getFiltrosCampo() {
        
    }

    public function Jobs($Tipo, &$ConjuntoDados, $Action, $Resultado) {
        
    }

    public function getTotalPageVisible() {
        
    }

    public function validarConteudoCampoRegex(&$Dados) {

    }

    public function NormalizarFiltro($Tipo) {
        
    }

}
