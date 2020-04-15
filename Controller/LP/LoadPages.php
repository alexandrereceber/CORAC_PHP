<?php
/**
 * @author Alexandre José da Silva Marques
 * @Criado: 12/01/2019
 * @filesource
 * 
 */

/**
 * ESQUEMA DAS TABELAS PARA USO DESSA FUNCIONALIDADE
 * CRIADO: 17/08/2019
 * MODIFICADO:

 * ESQUEMA 0 - PAGINAWEB - Modificação
 * 
 * CREATE TABLE `paginaweb` (
 `idPWEB` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave Primária',
 `URLPagina` varchar(200) NOT NULL COMMENT 'Nome de identificação da pagina WEB',
 `CodigoHTML` longtext NOT NULL COMMENT 'Código HTML da página',
 `Status` tinyint(1) NOT NULL,
 `dtCriado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
 `dtModificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`idPWEB`),
 KEY `URLPagina` (`URLPagina`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8
 */

/**
 * ESQUEMA DAS TABELAS PARA USO DESSA FUNCIONALIDADE
 * CRIADO: 14/01/2019
 * MODIFICADO:

 * ESQUEMA 1 - PAGINAWEB
 *
 * CREATE TABLE `paginaweb` (
 `idPWEB` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Chave Primária',
 `URLPagina` varchar(200) NOT NULL COMMENT 'Nome de identificação da pagina WEB',
 `PWTitulo` varchar(100) NOT NULL COMMENT 'Título da página WEB',
 `PWStyle` text NOT NULL COMMENT 'Style da página',
 `PWScript` text NOT NULL COMMENT 'Scripts que serão executados na página',
 `PWIMG` varchar(200) NOT NULL COMMENT 'Imagem que será apresentada na guia da página',
 `PWBMS` text NOT NULL COMMENT 'Linguagem de marcação responsável pela barra de menu superior',
 `PWBLE` text NOT NULL COMMENT 'Linguagem de marcação responsável pela barra lateral esquerda',
 `PWBLD` text NOT NULL COMMENT 'Linguagem de marcação responsável pela barra lateral direita',
 `PWBST` text NOT NULL COMMENT 'Linguagem de marcação responsável pela barra de status',
 `PWCNT` text NOT NULL COMMENT 'Linguagem de marcação responsável pela barra de conteúdo central',
 `Status` enum('Ativar','Desativar') NOT NULL,
 `dtCriado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
 `dtModificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`idPWEB`),
 KEY `URLPagina` (`URLPagina`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8


 * ESQUEMA DAS TABELAS PARA USO DESSA FUNCIONALIDADE
 * CRIADO: 14/01/2019
 * MODIFICADO:

 * 
 *  
 * ESQUEMA 2 - pwcabecalhopadrao

 *CREATE TABLE `pwcabecalhopadrao` (
 `idTPD` int(11) NOT NULL AUTO_INCREMENT,
 `chExtPWEB` int(11) NOT NULL,
 `TPD` text NOT NULL,
 `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `dtModificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`idTPD`),
 KEY `chExtPWEB` (`chExtPWEB`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


 * ESQUEMA DAS TABELAS PARA USO DESSA FUNCIONALIDADE
 * CRIADO: 14/01/2019
 * MODIFICADO:


 * ESQUEMA - 3 - pwebdiv

 *CREATE TABLE `pwebdiv` (
 `idPWEBDIV` int(11) NOT NULL AUTO_INCREMENT,
 `chExtPWEB` int(11) NOT NULL,
 `BTY` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra de Style da página',
 `BSC` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Scripts',
 `BMS` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra de Menu Superior',
 `BLE` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra Lateral Esquerda',
 `BLD` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra Lateral Direita',
 `BST` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra de Status',
 `BCT` enum('Sim','Não') NOT NULL DEFAULT 'Sim' COMMENT 'Barra de conteúdo central',
 `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `dtModificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`idPWEBDIV`),
 KEY `chExtPWEB` (`chExtPWEB`),
 CONSTRAINT `chvPWEBDIV` FOREIGN KEY (`chExtPWEB`) REFERENCES `paginaweb` (`idPWEB`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8


 * ESQUEMA DAS TABELAS PARA USO DESSA FUNCIONALIDADE
 * CRIADO: 14/01/2019
 * MODIFICADO:


 *CREATE TABLE `pwebpriv` (
 `idPWBPRIV` int(11) NOT NULL AUTO_INCREMENT,
 `chExtPWEB` int(11) NOT NULL,
 `chExtUser` int(11) NOT NULL,
 `Privilegio` enum('Visualizar','Editar') NOT NULL,
 `dtCriado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `dtModificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`idPWBPRIV`),
 KEY `chExtUser` (`chExtUser`),
 KEY `chExtPWEB` (`chExtPWEB`),
 CONSTRAINT `chvPWEBLogin` FOREIGN KEY (`chExtUser`) REFERENCES `login` (`idLogin`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

 */

/*
 * Classe que representa o carregamento do código HTML da página.
 */

/**
 * Descrição da CLPaginasWEB(Classe Página WEB)
 * Carrega, através do banco de dados, o código dos site HTML.
 *
 * @author Alexandre José da Silva Marques
 * @date 17/08/2019
 */

class LoadPages{

        private $CarregarTabela = null;
        private $Cabecalhos = null;
        private $CamposPWEB = null;
        private $PageEncontrada = false;
        private $PaginaAtivada = false;
        private $DIVsPWEB = null;
        private $Privilegios = null;
        private $idPWEB = null;
        private $TempoTabelaPaginaWEB = 0, 
                $TempoTabelaDIVs = 0, 
                $TempoTabelaCabecalhos = 0, 
                $TempoTabelaPriv = 0;
        /**
         * Busca a página de internet requisitada na URL
         * @param type $Cmp
         * @param type $Sd
         */
        function __construct($Cmp, $Sd) {

            $FiltroPW[0] = false;
            $FiltroPW[1][0][0] = $Cmp;
            $FiltroPW[1][0][1] = "=";
            $FiltroPW[1][0][2] = $Sd;
            $FiltroPW[1][0][3] = 2;

            $TmpInicial = round(microtime(true) * 1000);

            $this->CarregarTabela = new paginaweb();
            $this->CarregarTabela->setUsuario("Alexandre");
            $this->CarregarTabela->setFiltros($FiltroPW);
            $this->CarregarTabela->Select();
            $this->PageEncontrada = $this->CarregarTabela->getInfoPaginacao()["TotalLinhas"] == 0 ? false: true;

            $this->CamposPWEB = $this->CarregarTabela->getArrayDados();
            $this->idPWEB = $this->CamposPWEB[0][0];
            $this->PaginaAtivada = $this->CamposPWEB[0][4] == 0 ? false : true;
            
            $TmpFinal = round(microtime(true) * 1000);
            $this->TempoTabelaPaginaWEB = ($TmpFinal - $TmpInicial) / 1000 . " Segundos <->". ($TmpFinal - $TmpInicial). " MicroSegundos"; 

            $this->CarregarTabela = null;
        }

        private function getPrivPWEB() {
            $FiltroPWEBPRIV[0] = false;
            $FiltroPWEBPRIV[1][0][0] = 1;
            $FiltroPWEBPRIV[1][0][1] = "=";
            $FiltroPWEBPRIV[1][0][2] = $this->idPWEB;
            $FiltroPWEBPRIV[1][0][3] = 2;

            $TmpInicial = round(microtime(true) * 1000);

            $this->CarregarTabela = new pwebpriv();
            $this->CarregarTabela->setUsuario("Alexandre");
            $this->CarregarTabela->setFiltros($FiltroPWEBPRIV);
            $this->CarregarTabela->Select();
            $this->Privilegios = $this->CarregarTabela->getArrayDados();

            $TmpFinal = round(microtime(true) * 1000);
            $this->TempoTabelaPriv = ($TmpFinal - $TmpInicial) / 1000 . " Segundos <->". ($TmpFinal - $TmpInicial). " MicroSegundos"; 

            $this->CarregarTabela = null;
        }

        public function getPaginaExist(){
            return $this->PageEncontrada;
        }

        public function getPaginaAtiva() {
            return $this->PaginaAtivada;
        }
        
        public function getCodigoHTML(){
            return $this->CamposPWEB[0][3];
        }
        
        public function getCodigoHead(){
            return $this->CamposPWEB[0][2];
        }

        public function getTotalByte() {
           return strlen($this->getCodigoHTML());
        }
        public function getIDPWEB() {
            return $this->idPWEB;
        }
}