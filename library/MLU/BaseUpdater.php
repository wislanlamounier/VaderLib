<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MLU_BaseUpdater
{

  protected $host;
  protected $login;
  protected $senha;
  
  protected $local_dir;
  protected $server_dir;
  protected $passive_mode;
  protected $caminhoLib;
  protected $caminhoTMP;

  protected $versaoDesejada;
  protected $versaoAtual;
  protected $ext = 'MLU';
  protected $caminhoVersao = 'library/Vader/version.json';

  /**
   * Você precisa passar o Host login e senha do seu servidor onde ficará alocado as bibliotecas para fazer a verificacao
   * @param type $host = host name
   * @param type $login = login ftp
   * @param type $senha = senha ftp
   */
  public function __construct($host, $login, $senha, $passive_mode = true)
  {
    $this->setHost($host);
    $this->setLogin($login);
    $this->setSenha($senha);
    $this->setPassive_mode($passive_mode);
    $this->setCaminhoLib();
  }

  public function update($local_dir, $server_dir, $version)
  {
    $this->setVersaoDesejada($version);
    $this->setLocal_dir($local_dir);
    $this->setServer_dir($server_dir);
    
    if($this->validar() == false)
    {
      $this->getNewVersion();
    }
  }

  private function validar()
  {
    $arquivo = $this->caminhoVersao;
    $info = file_get_contents($arquivo);
    $json = json_decode($info);
    if($this->versaoDesejada != $json->version)
    {
      $this->setVersaoAtual($json->version);
      $this->getNewVersion();
      $this->atualizarVersao();
      return false;
    }
    else
      return true;
  }
  
  private function getNewVersion()
  {
    $conn_id = ftp_connect($this->host);
    $login_result = ftp_login($conn_id, $this->login, $this->senha);
    if($login_result)
    {
      ftp_pasv($conn_id, TRUE);
      ftp_chdir($conn_id, $this->server_dir);
      $this->validaArquivo($conn_id);
      
      $this->delTree('tmpMLU');
      mkdir('tmpMLU',0777);
      ftp_get($conn_id, 'tmpMLU/'.$this->versaoDesejada.'.'.$this->ext, $this->versaoDesejada.'.zip', FTP_BINARY);
      $this->setCaminhoTMP('tmpMLU/'.$this->versaoDesejada.'.'.$this->ext);
      ftp_close($conn_id);
    }
    else
      throw new Exception('Impossivel conectar com os servidores');
  }
  
  private function validaArquivo($coon_id)
  {
    $lista = ftp_nlist($coon_id, '');
    $resposta = array_search($this->versaoDesejada.'.zip', $lista);
    $respotaLocal = file_exists($this->local_dir);
    if($resposta === false || $respotaLocal === false)
      throw new Exception('A versão: '.$this->versaoDesejada.' não foi encontrada');
  }
  
  public static function delTree($dir)
  {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach($files as $file)
    {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }
  
  private function atualizarVersao()
  {
    $respotaLocal = file_exists('tmpMLU/'.$this->versaoDesejada.'.'.$this->ext);
    if($respotaLocal !== false)
    {
      $this->extrairbiblioteca();
    }
  }
  
  private function extrairbiblioteca()
  {
    $z = new ZipArchive();
    $abriu = $z->open($this->caminhoTMP);
    if($abriu === true)
    {
      $z->extractTo($this->local_dir);
      $z->close();
    }
    else
      throw new Exception ('Erro ao extrair o: '.$this->caminhoTMP.' para '.$this->local_dir.' ');
  }

  //<editor-fold defaultstate="collapsed" desc="get and sets">
  function getLocal_dir()
  {
    return $this->local_dir;
  }

  function getServer_dir()
  {
    return $this->server_dir;
  }

  function getPassive_mode()
  {
    return $this->passive_mode;
  }

  function setLocal_dir($local_dir)
  {
    $this->local_dir = $local_dir;
  }

  function setServer_dir($server_dir)
  {
    $this->server_dir = $server_dir;
  }

  function setPassive_mode($passive_mode)
  {
    $this->passive_mode = $passive_mode;
  }

  function getHost()
  {
    return $this->host;
  }

  function getLogin()
  {
    return $this->login;
  }

  function getSenha()
  {
    return $this->senha;
  }

  function setHost($host)
  {
    $this->host = $host;
  }

  function setLogin($login)
  {
    $this->login = $login;
  }

  function setSenha($senha)
  {
    $this->senha = $senha;
  }

  function getVersaoAtual()
  {
    return $this->versaoAtual;
  }

  function setVersaoAtual($versaoAtual)
  {
    $this->versaoAtual = $versaoAtual;
  }
  function getVersaoDesejada()
  {
    return $this->versaoDesejada;
  }

  function setVersaoDesejada($versaoDesejada)
  {
    $this->versaoDesejada = $versaoDesejada;
  }
  
  function getCaminhoLib()
  {
    return $this->caminhoLib;
  }

  function setCaminhoLib()
  {
    $caminhoLib = __DIR__;
    $this->caminhoLib = $caminhoLib;
  }
  
  function getCaminhoTMP()
  {
    return $this->caminhoTMP;
  }

  function setCaminhoTMP($caminhoTMP)
  {
    $this->caminhoTMP = $caminhoTMP;
  }
  
  function getExt()
  {
    return $this->ext;
  }

  function getCaminhoVersao()
  {
    return $this->caminhoVersao;
  }

  function setExt($ext)
  {
    $this->ext = $ext;
  }

  function setCaminhoVersao($caminhoVersao)
  {
    $this->caminhoVersao = $caminhoVersao;
  }
  //</editor-fold>
}