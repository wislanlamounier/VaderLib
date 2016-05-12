<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Vader_Gerenciador_BaseGerenciador
{
  public $filename;
  public $filehash;
  private $filesize;
  public $Destination;
  public $Caminho;
  private $pastaraiz;
  public $pasta;
  public $permissaoAtual;
  public $CaminhoSemDominio;
  public $CaminhoComDominio;
  public $Type_Filter;
  protected $typeImagems = array("image/jpeg","image/png","application/octet-stream");

  public function __construct($pastaraiz, $pasta)
  {
    $this->pastaraiz = $pastaraiz;
    $this->pasta = $pasta;
    $this->validaFiles();
  }

  public function Upload_Mult_Files()
  {
    $Config = Zend_Registry::get('config');
    $upload = new Zend_File_Transfer_Adapter_Http();
    $files = $upload->getFileInfo();
    foreach($files as $file => $info)
    {
      if($upload->isValid($file))
      {

        $this->filename = $upload->getFileName($file, false);
        $this->filehash = md5(time() . microtime(true)) . rand(1, 10000) . "." . $this->getExtension($info['name']);
        $this->filesize = $upload->getFileSize();
        $this->Caminho = $this->pastaraiz . '/' . $this->pasta . '/';
        $upload->setDestination($this->Caminho)->setFilters(array("Rename" => $this->filehash));
        $this->Destination = $Config->host->domain . '/' . $this->pastaraiz . '/' . $this->pasta . '/' . $this->filehash;
        $this->CaminhoSemDominio = $this->pastaraiz . '/' . $this->pasta . '/' . $this->filehash;
        $this->setPermissao($this->CaminhoSemDominio, 0755);
        $upload->receive($file);

        return $this;
      }
    }
  }

  public function UploadPeloInput($Input)
  {
    $Config = Zend_Registry::get('config');
    $upload = new Zend_File_Transfer_Adapter_Http();
    $files = $upload->getFileInfo();
    foreach($files as $file => $info)
    {
      if($file == $Input)
      {
        if($upload->isValid($file))
        {
          $this->filename = $upload->getFileName($file, false);
          $this->filehash = md5(time() . microtime(true)) . rand(1, 10000) . "." . $this->getExtension($info['name']);
          $this->Caminho = $this->pastaraiz . '/' . $this->pasta . '/';
          $upload->setDestination($this->Caminho)->setFilters(array("Rename" => $this->filehash));
          $this->Destination = $Config->host->domain . '/' . $this->pastaraiz . '/' . $this->pasta . '/' . $this->filehash;
          $this->CaminhoSemDominio = $this->pastaraiz . '/' . $this->pasta . '/' . $this->filehash;
          $upload->receive($file);
          $this->setPermissao($this->CaminhoSemDominio, 0755);
          return $this;
        }
      }
    }
  }

  /**
   *
   * @param type $diretorio
   * @param type $permissao
   * A permissão precisa ser octal. ou seja 0777 por exemplo.
   */
  public function setPermissao($diretorio, $permissao)
  {
    try
    {
      if(!chmod($diretorio, $permissao))
      {
        throw new Exception('Erro ao tentar atribuir valor a esse arquivo');
      }
      else
      {
        $this->permissaoAtual = $permissao;
      }
    }
    catch (Exception $e)
    {
      throw new Exception($e);
    }
  }

  private function GetFileByName($NomeInput)
  {
    foreach($_FILES as $name => $infos)
    {
      if($name != $NomeInput)
        unset($_FILES[$name]);
    }
  }

  private function validaFiles()
  {
    foreach($_FILES as $name => $infos)
    {
      if(empty($infos['name']))
        unset($_FILES[$name]);
    }
  }

  public function getExtension($name)
  {
    $exts = @split("[/\\.]", $name);
    $n = count($exts) - 1;
    $exts = $exts[$n];
    return $exts;
  }

  public function CortarImg($urlImage, $Red = false)
  {
    if($Red == null)
    {
      $Red['size'] = 350;
      $Red['Hei'] = 300;
      $Red['Wid'] = 300;
    }
    try
    {
      $extension = $this->cropar($urlImage, $this->pastaraiz, $this->pasta, NULL, $Red);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
    if(!$extension)
    {
      unset($urlImage);
    }
  }

  public static function ExcluirImagemStatic($url)
  {
    $Config = Zend_Registry::get('config');
    $urlfoto = str_replace($Config->host->domain.'/', '', $url);
    $urlfoto = str_replace($Config->host->domain, '', $urlfoto);
    unlink($urlfoto);
  }

  public function ExcluirImagem($url)
  {
    if($url != Vader_Controller_BaseController::IMAGEM_PADRAO)
    {
      $Config = Zend_Registry::get('config');
      $urlfoto = str_replace($Config->host->domain.'/', '', $url);
      $urlfoto = str_replace($Config->host->domain, '', $urlfoto);
      unlink($urlfoto);
    }
  }

  public function retirarDomain($url)
  {
    $Config = Zend_Registry::get('config');
    $urlfoto = str_replace($Config->host->domain.'/', '', $url);
    $urlfoto = str_replace($Config->host->domain, '', $urlfoto);
    return $urlfoto;
  }

  public function UploadBYTEARRAY($data, $dir)
  {

    $config = Zend_Registry::get('config');
    $decode = base64_decode($data);
    $im = imagecreatefromstring($decode);

    if($im !== false)
    {
      $url = md5(time() . microtime(true)) . ".jpg";
      header('Content-Type: image/jpg');
      try
      {
        imagejpeg($im, $dir . "/" . $url);
        imagedestroy($im);
        $this->setPermissao($dir. "/" . $url, 0755);
        return $config->host->domain .$dir."/" . $url;
      }
      catch (Exception $e)
      {
        throw new Exception($e->getMessage());
      }
    }
    else
    {
      throw new Exception('Não existe imagem para esse usuario');
    }
  }

  public function FilterIMG($url, $destino, $type = IMG_FILTER_GRAYSCALE)
  {
    if(!empty($url))
    {
      $config = Zend_Registry::get('config');
      $this->Caminho = $this->retirarDomain($url);
      $this->typeImagems = $this->getExtension($url);
      $this->Destination = $destino . '/' . md5(time() . microtime(true)) . '.' . $this->typeImagems;
      $this->CaminhoComDominio = $config->host->domain . '/' . $this->Destination;
      $this->CaminhoSemDominio = $this->Destination;
      $this->Type_Filter = $type;

      if($this->typeImagems == 'jpg' || $this->typeImagems == 'jpeg')
        $this->createFromjpg();

      else if($this->typeImagems == 'png')
        $this->createFromPNG();

      else
        throw new Exception ('Não consiguimos reconhecer que imagem é esta'. $this->typeImagems);

      $this->setPermissao($this->CaminhoSemDominio, 0755);

      return $this->CaminhoComDominio;
    }
  }

  private function createFromjpg()
  {
    $im = imagecreatefromjpeg($this->Caminho);

    if($im && imagefilter($im, $this->Type_Filter))
    {
      imagejpeg($im, $this->Destination);
    }
    else
      throw new Exception('FILTER: Impossivel colocar filtro nesta imagem ...... ');

    imagedestroy($im);
  }

  public function cropar($name, $pasta1, $pasta, $xy = false, $resize = false)
  {
    $Config = Zend_Registry::get('config');
    $str = $name;
    // assume $str esteja em UTF-8
    $map = array(
        '/' => '',
        'http//' => '',
        $Config->host->domain => '',
        $pasta1.'/'.$pasta.'' =>'',
        'Usuarios' => '',
        'fotos' => '',
    );
    $foto = strtr($str, $map);
    include '../library/PhpImagizer-ver1.0/PhpImagizer.php';
    // Source file name
    $srcFileName = '' . $pasta1 . '/' . $pasta . '/' . $foto;
    try
    {
      $imagizer = new PhpImagizer($srcFileName);
      $imagizer->crop_Eu($xy['X'] ,$xy['Y'] ,$xy['Wid'],$xy['Hei']);

      if(substr_count($foto, ".PNG") > 0 || substr_count($foto, ".png") > 0)
      {
        $imagizer->saveImg('' . $pasta1 . '/' . $pasta . '/' . $foto . '');
      }
      else
      {
        $imagizer->saveImg('' . $pasta1 . '/' . $pasta . '/' . $foto . '');
      }
    }
    catch (PhpImagizerException $e)
    {
      throw new Exception('Erro' . $e->getMessage());
    }
    try
    {
      if(!empty($resize))
      {
        $imagizer->fitSize($resize['Size']);
        $imagizer->byHeight($resize['Hei']);
        $imagizer->byWidth($resize['Wid']);

        if(substr_count($foto, ".PNG") > 0 || substr_count($foto, ".png") > 0)
        {
          $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
        }
        else
        {
          $imagizer->saveImg(''.$pasta1.'/'.$pasta.'/'.$foto.'');
        }
      }

    }
    catch(PhpImagizerException $e)
    {
      throw new Exception('Erro'. $e->getMessage());
    }
    return $exts;
  }
  
  private function createFromPNG()
  {
    $im = imagecreatefrompng($this->Caminho);

    if($im && imagefilter($im, $this->Type_Filter))
    {
      imagepng($im, $this->Destination);
    }
    else
      throw new Exception('FILTER: Impossivel colocar filtro nesta imagem ...... ');

    imagedestroy($im);
  }

  function getFilename()
  {
    return $this->filename;
  }

  function getFilehash()
  {
    return $this->filehash;
  }

  function getFilesize()
  {
    return $this->filesize;
  }

  function getDestination()
  {
    return $this->Destination;
  }

  function getCaminho()
  {
    return $this->Caminho;
  }

  function getPastaraiz()
  {
    return $this->pastaraiz;
  }

  function getPasta()
  {
    return $this->pasta;
  }

  function getPermissaoAtual()
  {
    return $this->permissaoAtual;
  }

  function getCaminhoSemDominio()
  {
    return $this->CaminhoSemDominio;
  }

  function getTypeImagems()
  {
    return $this->typeImagems;
  }

  function setFilename($filename)
  {
    $this->filename = $filename;
  }

  function setFilehash($filehash)
  {
    $this->filehash = $filehash;
  }

  function setFilesize($filesize)
  {
    $this->filesize = $filesize;
  }

  function setDestination($Destination)
  {
    $this->Destination = $Destination;
  }

  function setCaminho($Caminho)
  {
    $this->Caminho = $Caminho;
  }

  function setPastaraiz($pastaraiz)
  {
    $this->pastaraiz = $pastaraiz;
  }

  function setPasta($pasta)
  {
    $this->pasta = $pasta;
  }

  function setPermissaoAtual($permissaoAtual)
  {
    $this->permissaoAtual = $permissaoAtual;
  }

  function setCaminhoSemDominio($CaminhoSemDominio)
  {
    $this->CaminhoSemDominio = $CaminhoSemDominio;
  }

  function setTypeImagems($typeImagems)
  {
    $this->typeImagems = $typeImagems;
  }

}
