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

    public function Jobs($Tipo, &$ConjuntoDados) {
        
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

}

/**
 * 
 */
class Exemplo1 extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,
               "Field"          => "idMaquinas",
               "CodNome"        => "idMaquinas",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [true, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 1,
               "Field"          => "Maquina",
               "CodNome"        => "Máquina",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ]
        ];
    /**
     * Existem dois processo de verificação de privilégio:
     * 1º - Pela variável $Privilegio: private $Privilegios = [["Alexandre","Select/Delete/Update/Insert"],["Pedro","Select"]];
     * 2º - Tabela no banco de dados.
     * @var type 
     */
    private $Privilegios = [["Alexandre","Select///"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>true, "SaltoPagina"=> false, "Filtros"=>false, "BRefresh"=>false];

    /**
     * 
     * @return type
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function setNomeTabela() {
        $this->NomeTabela = "Maquinas";
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
    /**
     * Retorna a quantidade de linhas por página;
     * @return int
     */
    public function getLimite() {
        return 30;
    }
    /**
     * Apresenta uma coluna de numeração.
     * @return boolean
     */
    public function getMostrarContador() {
        return false;
    }
    /**
     * Cria uma coluna contendo um ícone atrelado a uma função definida.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = false;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
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
     * Usando tabela view retorna o nome da tabela real que recebera os dados brutos.
     */
    public function getNomeReal() {
        
    }
    /**
     * Informa que a tabela é uma view;
     */
    public function getVirtual() {
        
    }
    /**
     * Retorna um array informando que existe um valor padrão e o valor referente.
     * @param type $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        
        switch ($idx) {
            case 3:
                $ValorPadraoCampos[0] = [Exist=>true, Valor=>"sim", Readonly=> true];
                break;

            default:
                $ValorPadraoCampos[$idx] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;
        }
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a busca dos privilégios em uma tabela no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Realiza um filtro nos campos antes de receber qualquer tipo de dado.
     * @param type $idx
     */
    public function getFiltrosCampo() {
        
    }
    /**
     * Executa instruções de forma dinâmica antes de inserir ou atualizar os dados nas tabelas.
     * @param type $Tipo
     * @param type $ConjuntoDados
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Informa a quantidade de páginas por tabela.
     * @return int
     */
    public function getTotalPageVisible() {
        return 4;
    }
    /**
     * Utilizada para validar os dados antes de inserí-los, editá-los na tabela.
     * @param type $Dados
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class Exemplo2 extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,
               "Field"          => "idMaquinas",
               "CodNome"        => "idMaquinas",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [true, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 1,
               "Field"          => "Maquina",
               "CodNome"        => "Máquina",
               "TypeConteudo"   => ["text"],
               "Filter"         => true,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "MaquinaR", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 2,
               "Field"          => "Patrimonio",
               "CodNome"        => "Patrimônio",
               "TypeConteudo"   => ["text"],
               "Filter"         => true,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "patri", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ]
        ];
    /**
     * Existem dois processo de verificação de privilégio:
     * 1º - Pela variável $Privilegio: private $Privilegios = [["Alexandre","Select/Delete/Update/Insert"],["Pedro","Select"]];
     * 2º - Tabela no banco de dados.
     * @var type 
     */
    private $Privilegios = [["Alexandre","Select/Update/Insert/Delete"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];

    /**
     * Retorna um array contendo as configurações de visualização da paginação da tabela HTML.
     * Simples=>false - Exibe os detalhes de visualização dos registros
     * SaltoPagina=>true - Exibe uma caixa para inserir o número da página para qual deseja saltas.
     * Filtros=> true - exibe uma caixa para inserir a cadeira de caracteres que deseja buscar dentro de cada linha das colunas.
     * BRefresh=true - Exibe um botão para dar refresh nos dados da tabela HTML.
     * @return Array
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    /**
     * Define o nome da tabela que será utilizada.
     */
    public function setNomeTabela() {
        $this->NomeTabela = "Maquinas"; //__class__;
    }

    public function getCampos() {
        return $this->Campos;
    }
    /**
     * ["Nome Usuário","Privilegios"]
     * @return Array
     */
    public function getPrivilegios() {
        return $this->Privilegios;
    }
    /**
     * false - caso não quera que o título seja exibido.
     * string - Texto que será apresentado como título da tabela.
     * @return boolean
     */
    public function getTituloTabela() {
        return false;
    }
    /**
     * Retorna a quantidade de linhas por página;
     * Usar 0 faz ficar sem paginação.
     * @return int
     */
    public function getLimite() {
        return 10;
    }
    /**
     * Apresenta uma coluna de numeração crescente.
     * false - Não apresenta a coluna
     * true - apresenta uma coluna com ordem crescente.
     * @return boolean
     */
    public function getMostrarContador() {
        return true;
    }
    /**
     * Cria uma coluna contendo um ícone atrelado a uma função definida nas propriedades da instância de tabela.
     * [0]=> true - Índice representado pela variável $Habilitar - Define a visualização ou não de todas as colunas.
     * [1]=> Array - Define a configuração de cada coluna ícone que a tabela possue
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = true; //Configuração que define se será exibida ou não todas as colunas íncone da tabela.
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
                            "NomeBotao"=>"Localizar", 
                            "Icone" => "fa fa-search", 
                            "Func" => 0, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "busca",
                            "Visible"=>true
                        ],
                        [
                            "NomeColuna"=> "Íconess",
                            "NomeBotao"=>"Recuperar", 
                            "Icone" => "fa fa-bitbucket", 
                            "Func" => 1, 
                            "Tipo" => "Bootstrap", 
                            "tooltip"=> "Recupera",
                            "Visible"=>false
                        ]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * Usando tabela view retorna o nome da tabela real que recebera os dados brutos.
     */
    public function getNomeReal() {
        
    }
    /**
     * Informa que a tabela é uma view;
     */
    public function getVirtual() {
        
    }
    /**
     * Retorna um array informando que existe um valor padrão e o valor referente.
     * @param type $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        switch ($idx) {
            case 2:
                $ValorPadraoCampos[2] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;

            default:
                $ValorPadraoCampos[$idx] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;
        }
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a busca dos privilégios em uma tabela no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Realiza um filtro nos campos antes de receber qualquer tipo de dado.
     * $Campo[0]
     * $Campo[1]
     * Representa o operador AND nas construções do filtro.
     * 
        $Campo[0] = <b>[[1,"like","rf06104%"]]</b> - Cada subarray representa a operação OR da consulta. Exm: [[1,"like","rf06104%"], [2,"like","rf06104%"]] - entre o campo 1 e o campo 2 seré utilizado o operador OR.<br>
        $Campo[1] = <b>[[2,"like","259%"]]</b>;

     * @param type $idx
     */
    public function getFiltrosCampo() {
        //$Campo[0] = [[1,"like","rf06104%"]];
        //$Campo[1] = [[2,"like","259%"]];
        
        
        return $Campo;
    }
    /**
     * Executa instruções de forma dinâmica antes de inserir ou atualizar os dados nas tabelas.
     * @param type $Tipo
     * @param type $ConjuntoDados
     */
    public function Jobs($Tipo, &$ConjuntoDados) {

    }
    /**
     * Informa a quantidade de páginas por tabela.
     * @return int
     */
    public function getTotalPageVisible() {
        return 4;
    }
    /**
     * Utilizada para validar os dados antes de inserí-los, editá-los na tabela.
     * @param type $Dados
     */
    public function validarConteudoCampoRegex(&$Dados) {
        1==1;
    }

}

class Exemplo3 extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,
               "Field"          => "idObservacao",
               "CodNome"        => "idObservacao",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [true, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 1,
               "Field"          => "idMaquinas",
               "CodNome"        => "Nome Máquina",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => true,
                                        "Tabela"=> "maquinas",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> "Máquinas"
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => false,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"select",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "IDM", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 2,
               "Field"          => "Observacao",
               "CodNome"        => "Observação",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "OBSER", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 3,
               "Field"          => "Detalhes",
               "CodNome"        => "Detalhes",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "DET", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> false,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> false
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 4,
               "Field"          => "idHistorico",
               "CodNome"        => "Histórico",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => true,
                                        "Tabela"=> "historico",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 1,
                                        "NomeBotao"=> "História"
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => false,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"button",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "IDM", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 5,
               "Field"          => "NomeNovo",
               "CodNome"        => "Nome Novo",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "NNovo", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ]
        ];
    /**
     * Existem dois processo de verificação de privilégio:
     * 1º - Pela variável $Privilegio: private $Privilegios = [["Alexandre","Select/Delete/Update/Insert"],["Pedro","Select"]];
     * 2º - Tabela no banco de dados.
     * @var type 
     */
    private $Privilegios = [["Alexandre","Select/insert/update/"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>true, "SaltoPagina"=> false, "Filtros"=>false, "BRefresh"=>false];

    /**
     * 
     * @return type
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function setNomeTabela() {
        $this->NomeTabela = "omaquinas"; //|__CLASS__;
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
    /**
     * Retorna a quantidade de linhas por página;
     * @return int
     */
    public function getLimite() {
        return 30;
    }
    /**
     * Apresenta uma coluna de numeração.
     * @return boolean
     */
    public function getMostrarContador() {
        return false;
    }
    /**
     * Cria uma coluna contendo um ícone atrelado a uma função definida.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = false;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
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
     * Usando tabela view retorna o nome da tabela real que recebera os dados brutos.
     */
    public function getNomeReal() {
        return "observacao";
    }
    /**
     * Informa que a tabela é uma view;
     */
    public function getVirtual() {
        return true;
    }
    /**
     * Retorna um array informando que existe um valor padrão e o valor referente.
     * @param type $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        
        switch ($idx) {

            default:
                $ValorPadraoCampos[$idx] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;
        }
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a busca dos privilégios em uma tabela no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Realiza um filtro nos campos antes de receber qualquer tipo de dado.
     * @param type $idx
     */
    public function getFiltrosCampo() {
        
    }
    /**
     * Executa instruções de forma dinâmica antes de inserir ou atualizar os dados nas tabelas.
     * @param type $Tipo
     * @param type $ConjuntoDados
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Informa a quantidade de páginas por tabela.
     * @return int
     */
    public function getTotalPageVisible() {
        return 4;
    }
    /**
     * Utilizada para validar os dados antes de inserí-los, editá-los na tabela.
     * @param type $Dados
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class Exemplo4 extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,
               "Field"          => "idCards",
               "CodNome"        => "idCards",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [true, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 1,
               "Field"          => "Titulo",
               "CodNome"        => "Título",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => false,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "IDM", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 2,
               "Field"          => "Descricao",
               "CodNome"        => "Descrição",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "OBSER", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 3,
               "Field"          => "imagem",
               "CodNome"        => "Imagem",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "DET", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> false,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> false
                                    ],
               "OrdemBY"        => true
           ]
        ];
    /**
     * Existem dois processo de verificação de privilégio:
     * 1º - Pela variável $Privilegio: private $Privilegios = [["Alexandre","Select/Delete/Update/Insert"],["Pedro","Select"]];
     * 2º - Tabela no banco de dados.
     * @var type 
     */
    private $Privilegios = [["Alexandre","Select///"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> true, "Filtros"=>true, "BRefresh"=>true];

    /**
     * 
     * @return type
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function setNomeTabela() {
        $this->NomeTabela = "cards"; //|__CLASS__;
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
    /**
     * Retorna a quantidade de linhas por página;
     * @return int
     */
    public function getLimite() {
        return 30;
    }
    /**
     * Apresenta uma coluna de numeração.
     * @return boolean
     */
    public function getMostrarContador() {
        return false;
    }
    /**
     * Cria uma coluna contendo um ícone atrelado a uma função definida.
     * @return array
     */
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
                        ]
                    ];
        $ShowColumns[0] = $Habilitar;
        $ShowColumns[1] = $Icones;
        
        return $ShowColumns;
        
    }
    /**
     * Usando tabela view retorna o nome da tabela real que recebera os dados brutos.
     */
    public function getNomeReal() {
        return "";
    }
    /**
     * Informa que a tabela é uma view;
     */
    public function getVirtual() {
        return false;
    }
    /**
     * Retorna um array informando que existe um valor padrão e o valor referente.
     * @param type $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        
        switch ($idx) {

            default:
                $ValorPadraoCampos[$idx] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;
        }
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a busca dos privilégios em uma tabela no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Realiza um filtro nos campos antes de receber qualquer tipo de dado.
     * @param type $idx
     */
    public function getFiltrosCampo() {
        
    }
    /**
     * Executa instruções de forma dinâmica antes de inserir ou atualizar os dados nas tabelas.
     * @param type $Tipo
     * @param type $ConjuntoDados
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Informa a quantidade de páginas por tabela.
     * @return int
     */
    public function getTotalPageVisible() {
        return 4;
    }
    /**
     * Utilizada para validar os dados antes de inserí-los, editá-los na tabela.
     * @param type $Dados
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}

class Exemplo5 extends ModeloTabelas{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     * @var type 
     */
    private $Campos =  [
           
           [
               "Index"          => 0,
               "Field"          => "idpost",
               "CodNome"        => "idpost",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [true, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> false,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 1,
               "Field"          => "Imagem",
               "CodNome"        => "Imagem",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "IDM", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 2,
               "Field"          => "Titulo",
               "CodNome"        => "Título",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "OBSER", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 3,
               "Field"          => "Autor",
               "CodNome"        => "Autor",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 0,
                                        "NomeBotao"=> ""
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "DET", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> false,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> false
                                    ],
               "OrdemBY"        => true
           ], 
           [
               "Index"          => 4,
               "Field"          => "Descricao",
               "CodNome"        => "Descrição",
               "TypeConteudo"   => ["text"],
               "Filter"         => false,       
               "Key"            => [false, false],
               "ChvExt"         => [    
                                        "TExt" => false,
                                        "Tabela"=> "",
                                        "IdxCampoVinculado"=> 0, 
                                        "Funcao"=> 1,
                                        "NomeBotao"=> "História"
                                    ],
               "Mask"           => false,
               "Editar"         => false,
               "Visible"        => true,
               "Regex"          => [Exist=> false, Regx=> ""],
               "Formulario"     => [
                                        "Exibir"=> true,
                                        "Placeholder"=> "", 
                                        "TypeComponente"=>"inputbox",
                                        "TypeConteudo"=> ["text"],
                                        "Name" => "Desc", 
                                        "Patterns"=> "",
                                        "Titles" => "",
                                        "Required" => "",
                                        "width" => "50px",
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
                                        "autofocus"=> true,
                                        "checked"=>"",
                                        "dirname"=>"",
                                        "readonly"=>"",
                                        "EditorText"=> true
                                    ],
               "OrdemBY"        => true
           ]
        ];
    /**
     * Existem dois processo de verificação de privilégio:
     * 1º - Pela variável $Privilegio: private $Privilegios = [["Alexandre","Select/Delete/Update/Insert"],["Pedro","Select"]];
     * 2º - Tabela no banco de dados.
     * @var type 
     */
    private $Privilegios = [["Alexandre","Select///"],["Pedro","Select"]];
    private $TipoPaginacao = ["Simples"=>false, "SaltoPagina"=> false, "Filtros"=>true, "BRefresh"=>false];

    /**
     * 
     * @return type
     */
    public function ModoPaginacao() {
        return $this->TipoPaginacao;
    }
    
    public function setNomeTabela() {
        $this->NomeTabela = "post"; //|__CLASS__;
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
    /**
     * Retorna a quantidade de linhas por página;
     * @return int
     */
    public function getLimite() {
        return 30;
    }
    /**
     * Apresenta uma coluna de numeração.
     * @return boolean
     */
    public function getMostrarContador() {
        return false;
    }
    /**
     * Cria uma coluna contendo um ícone atrelado a uma função definida.
     * @return array
     */
    public function showColumnsIcones() {
        $Habilitar = false;
        $Icones = [
                        [
                            "NomeColuna"=> "<i class='fa fa-bluetooth' style='font-size:20px'></i>",
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
     * Usando tabela view retorna o nome da tabela real que recebera os dados brutos.
     */
    public function getNomeReal() {
        return "observacao";
    }
    /**
     * Informa que a tabela é uma view;
     */
    public function getVirtual() {
        return false;
    }
    /**
     * Retorna um array informando que existe um valor padrão e o valor referente.
     * @param type $idx
     * @return boolean
     */
    public function getValorPadrao($idx) {
        
        switch ($idx) {

            default:
                $ValorPadraoCampos[$idx] = [Exist=>false, Valor=>"sim", Readonly=> true];
                break;
        }
        
        return $ValorPadraoCampos[$idx];
    }
    /**
     * Habilita a busca dos privilégios em uma tabela no banco de dados.
     */
    public function getPrivBD() {
        
    }
    /**
     * Realiza um filtro nos campos antes de receber qualquer tipo de dado.
     * @param type $idx
     */
    public function getFiltrosCampo() {
        
    }
    /**
     * Executa instruções de forma dinâmica antes de inserir ou atualizar os dados nas tabelas.
     * @param type $Tipo
     * @param type $ConjuntoDados
     */
    public function Jobs($Tipo, &$ConjuntoDados) {
        
    }
    /**
     * Informa a quantidade de páginas por tabela.
     * @return int
     */
    public function getTotalPageVisible() {
        return 4;
    }
    /**
     * Utilizada para validar os dados antes de inserí-los, editá-los na tabela.
     * @param type $Dados
     */
    public function validarConteudoCampoRegex(&$Dados) {
        
    }

}


//--------------------------------------------------------------------
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
    public function getFiltrosCampo() {
        
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
    public function getFiltrosCampo() {
        
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
    public function getFiltrosCampo() {
        
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
               "Field"          => "HeadePWEB",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "HeadePWEB",
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
                                        "Name" => "HeadePWEB", 
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
               "Field"          => "CodigoHTML",
               /**
                * É o nome que será utilizado no sistema como label ou sejá o nome que será exibido dentro da página.
                * Muito utilizado na formação dos campos de insersão e edição HTML.
                */
               "CodNome"        => "CodigoHTML",
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
                                        "Name" => "CodigoHTML", 
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
    public function getFiltrosCampo() {
        
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
                        ["NomeColuna"=> "<i class='material-icons' style='font-size:19px'>pages</i>","NomeBotao"=>"Localizar", "Icone" => "far fa-file-word", "Func" => 0, "Tipo" => "Bootstrap", "tooltip"=> "Caregar página WEB", "Visible"=>true]
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
    public function getFiltrosCampo() {
        
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

class Teste extends ModeloProcedures{
    /**
     * Mapeia os campos da tabela - Muito importante caso se queira visualizar somente campo necessários
     */
    private $Saidas = "@Saida, @s2";
    private $Privilegios = [["CORAC","Select/Execute"]];
    private $StringSQL = null;
    
//
//    public function getArrayDados() {
//        $Preparacao = parent::query($this->StringSQL);
//        $Preparacao = parent::query("SELECT $this->Saidas");
//        return $Preparacao->fetch();
//    }

    public function Jobs($Tipo, &$ConjuntoDados, $Action, $Resultado) {
        
    }

    public function NormalizarFiltro($Func) {
        
    }

    public function getNomeReal() {
        return __CLASS__;
    }

    public function getPrivBD() {
        return false;
    }

    public function getPrivilegios() {
        return $this->Privilegios;
    }

    public function getVirtual() {
        return false;
    }

    public function setNomeProcedure() {
        $this->NomeProcedures = __CLASS__;
    }

    public function validarConteudoCampoRegex(&$Dados) {
        
    }

    public function getSaidas() {
        return $this->Saidas;
    }

}