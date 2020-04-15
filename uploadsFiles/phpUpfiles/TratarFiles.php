<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uploads
 *
 * @author 04953988612
 */
class uploadsImg {
    private $Destino = false;
    private $File;
    private $Sessao = false;
    private $Usuario = false;
    /**
     * Informa se o armazenamento da imagem será feita via arquivo ou blob ou qualquer outro. Sendo true será armazenado como arquivo, false será
     * armazenado como dado dentro da tabela no banco de dados.
     * @var bool 
     */
    private $Storeg = true;
    /**
     * Informa se o nome dos arquivos serão armazenados em tabela.
     * @var type 
     */
    private $Storeg_table = true;
    /**
     * Armazena o local de destino das imagens
     * @param string $p
     */
    public function PathDestino($p) {
        $this->Destino = $p;
    }
    
    /**
     * Armazena o objeto que representa o arquivo em um local temporário.
     * @param Object $File Representa a referência do arquivo que será movido ou tranformado em dados para o banco de dados
     * @param Object $Sessao Informa se o sistema esta operando com usuário logado ou não.
     * @param string $Usuario Caso o usuário esteje logado, o seu nome de usuário será utilizado como referência para todas as ações.
     * @param int $Store Forma de amazenamento da imagem. 1- A imagem será mantida em hd sob a forma de arquivo, 2- a imagens será armazena no banco de dados.
     */
    public function __construct(&$File, $Sessao = false, $Usuario = false) {
        $this->File = $File;
        $this->Sessao = $Sessao;
        $this->Usuario = $Usuario;
    }
    /**
     * O método verifica se existe ou não a pasta de destino e caso não existe cria-a.
     * @param objeto $SD Objeto que representa a existência ou não de sessão.
     * @return boolean true criada com sucesso ou já existe,false ocorreu algum problema na criação
     * @Obs.: Caso não se defina uma pasta de destino será utilizada a pasta local img. A sessão representa 
     * que existe um usuário logado e que todos os dados deverão ser separados pelos mesmos.
     */
    public function CriarDestinoImagem() {
        /**
         * Verifica se um destino foi definido, caso não tenha sido será utilizado a pasta local ./img
         */
        $Destino = $this->Destino == false ? "./img" : $this->Destino;
        $Destino = chdir($Destino);
        $Destino = getcwd();
        /**
         * Verifica a existência de sessão, caso haja o repositório será separado por sessão.
         */
        $Caminho = $Destino . ($this->Sessao == true ? ("/repositorio/" . $this->Usuario) : ("/repositorio"));
        
        $Exist = file_exists($Caminho); //Verifica se o caminho definido anteriormente já existe.
        
        if(!$Exist){
            mkdir($Caminho); //Não existindo o caminho será criada a pasta.
            $Exist = file_exists($Caminho);
            if($Exist){
                $this->Destino = $Caminho;
                return true;
            } else return false;
            
        }else{
            $this->Destino = $Caminho; //Existindo o caminho, a variável destino é atribuída com o mesmo.
        }
        return true;;
    }
    
    public function getRepositorio() {
        return ($this->Sessao == true ? ("/repositorio/" . $this->Usuario) : ("/repositorio"));
    }
    
    public function removeArquivo() {
        unlink($this->Destino);
    }
    
    public function get_Storeg() {
        return $this->Storeg;
    }

    public function get_Storeg_tabela() {
        return $this->Storeg_table;
    }
    
    public function moverImagens() {

        $Destino = $this->Destino . "//". $this->File["name"];
        $retorno = move_uploaded_file($this->File["tmp_name"], $Destino);

        $Inf[0] = $retorno;
        $Inf[1] = $this->File["name"];
        return $Inf;
        //$resize = new ResizeImage($Destino);
        
        /*if(!($resize->getTamanhoAlturaOriginal() < 300) || !($resize->getTamanhoLaguraOriginal() < 300)){
                $resize->resizeTo(300, 300);
                $resize->saveImage($Destino);
        }*/
        
    }
}

/**
 * Resize image class will allow you to resize an image
 *
 * Can resize to exact size
 * Max width size while keep aspect ratio
 * Max height size while keep aspect ratio
 * Automatic while keep aspect ratio
 */
class ResizeImage
{
	private $ext;
	private $image;
	private $newImage;
	private $origWidth;
	private $origHeight;
	private $resizeWidth;
	private $resizeHeight;

	/**
	 * Class constructor requires to send through the image filename
	 *
	 * @param string $filename - Filename of the image you want to resize
	 */
	public function __construct( $filename )
	{
		if(file_exists($filename))
		{
			$this->setImage( $filename );
		} else {
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		}
	}
        
        public function getTamanhoLaguraOriginal() {
            return $this->origWidth;
        }

        public function getTamanhoAlturaOriginal() {
            return $this->origHeight;
        }
        
	/**
	 * Set the image variable by using image create
	 *
	 * @param string $filename - The image filename
	 */
	private function setImage( $filename )
	{
		$size = getimagesize($filename);
		$this->ext = $size['mime'];

		switch($this->ext)
	    {
	    	// Image is a JPG
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// create a jpeg extension
	            $this->image = imagecreatefromjpeg($filename);
	            break;

	        // Image is a GIF
	        case 'image/gif':
	            $this->image = @imagecreatefromgif($filename);
	            break;

	        // Image is a PNG
	        case 'image/png':
	            $this->image = @imagecreatefrompng($filename);
	            break;

	        default:
     	            $this->image = @imagecreatefrompng($filename);
	            //throw new Exception("File is not an image, please use another file type.", 1);
	    }

	    $this->origWidth = imagesx($this->image);
	    $this->origHeight = imagesy($this->image);
	}

	/**
	 * Save the image as the image type the original image was
	 *
	 * @param  String[type] $savePath     - The path to store the new image
	 * @param  string $imageQuality 	  - The qulaity level of image to create
	 *
	 * @return Saves the image
	 */
	public function saveImage($savePath, $imageQuality="100", $download = false)
	{
	    switch($this->ext)
	    {
	        case 'image/jpg':
	        case 'image/jpeg':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_JPG) {
	                imagejpeg($this->newImage, $savePath, $imageQuality);
	            }
	            break;

	        case 'image/gif':
	        	// Check PHP supports this file type
	            if (imagetypes() & IMG_GIF) {
	                imagegif($this->newImage, $savePath);
	            }
	            break;

	        case 'image/png':
	            $invertScaleQuality = 9 - round(($imageQuality/100) * 9);

	            // Check PHP supports this file type
	            if (imagetypes() & IMG_PNG) {
	                imagepng($this->newImage, $savePath, $invertScaleQuality);
	            }
	            break;
	    }

	    if($download)
	    {
	    	header('Content-Description: File Transfer');
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment; filename= ".$savePath."");
			readfile($savePath);
	    }

	    imagedestroy($this->newImage);
	}

	/**
	 * Resize the image to these set dimensions
	 *
	 * @param  int $width        	- Max width of the image
	 * @param  int $height       	- Max height of the image
	 * @param  string $resizeOption - Scale option for the image
	 *
	 * @return Save new image
	 */
	public function resizeTo( $width, $height, $resizeOption = 'default' )
	{
		switch(strtolower($resizeOption))
		{
			case 'exact':
				$this->resizeWidth = $width;
				$this->resizeHeight = $height;
			break;

			case 'maxwidth':
				$this->resizeWidth  = $width;
				$this->resizeHeight = $this->resizeHeightByWidth($width);
			break;

			case 'maxheight':
				$this->resizeWidth  = $this->resizeWidthByHeight($height);
				$this->resizeHeight = $height;
			break;

			default:
				if($this->origWidth > $width || $this->origHeight > $height)
				{
					if ( $this->origWidth > $this->origHeight ) {
				    	 $this->resizeHeight = $this->resizeHeightByWidth($width);
			  			 $this->resizeWidth  = $width;
					} else if( $this->origWidth < $this->origHeight ) {
						$this->resizeWidth  = $this->resizeWidthByHeight($height);
						$this->resizeHeight = $height;
					}  else {
						$this->resizeWidth = $width;
						$this->resizeHeight = $height;	
					}
				} else {
		            $this->resizeWidth = $width;
		            $this->resizeHeight = $height;
		        }
			break;
		}

		$this->newImage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
    	imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
	}

	/**
	 * Get the resized height from the width keeping the aspect ratio
	 *
	 * @param  int $width - Max image width
	 *
	 * @return Height keeping aspect ratio
	 */
	private function resizeHeightByWidth($width)
	{
		return floor(($this->origHeight/$this->origWidth)*$width);
	}

	/**
	 * Get the resized width from the height keeping the aspect ratio
	 *
	 * @param  int $height - Max image height
	 *
	 * @return Width keeping aspect ratio
	 */
	private function resizeWidthByHeight($height)
	{
		return floor(($this->origWidth/$this->origHeight)*$height);
	}
}