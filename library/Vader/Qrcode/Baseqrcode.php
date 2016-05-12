<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BaseQrCode
 *
 * @author Tiaguinho
 */
class Vader_Qrcode_Baseqrcode
{

  protected $_id;
  protected $_destino;
  protected $_baseUrl;
  protected $_conteudo;
  protected $_urlQrCode;
  protected $_destinofisico;

  // <editor-fold defaultstate="collapsed" desc="Contructor">
  public function __construct()
  {
    include "phpqrcode/qrlib.php";

    $Config = Zend_Registry::get('config');
    $this->set_baseUrl($Config->host->domain);
  }
  // </editor-fold>
  // <editor-fold defaultstate="collapsed" desc="Functions para gerar QRCode">
  public function getQRCodePNG()
  {
    
    $permissao = new Application_Model_Util_Gerenciadorarquivos();
    $Conteudo = $this->_conteudo;

    $NomeArquivo = md5(time() . microtime(true)) . rand(1, 10000) . "." . 'png';

    $Destino = $this->_destino . $NomeArquivo;
    $this->_urlQrCode = $this->_baseUrl . $Destino;
    $this->_destinofisico = $Destino;
    
    $errorCorrectionLevel = 'H';
    $matrixPointSize = 10;
    
    
    if(!file_exists($Destino))
    {
      QRcode::png($Conteudo, $Destino, $errorCorrectionLevel, $matrixPointSize, 2);
      $permissao->setPermissao($this->_destinofisico, 0755);
    }
    else
    {
      throw new Exception('Erro ao criar o QRCode');
    }
  }
  // </editor-fold>
  // <editor-fold defaultstate="collapsed" desc="Gets and Sets">
  function get_id()
  {
    return $this->_id;
  }

  function get_destino()
  {
    return $this->_destino;
  }

  function get_baseUrl()
  {
    return $this->_baseUrl;
  }

  function set_id($_id)
  {
    $this->_id = $_id;
  }

  function set_destino($_destino)
  {
    $this->_destino = $_destino;
  }

  function set_baseUrl($_baseUrl)
  {
    $this->_baseUrl = $_baseUrl;
  }

  function get_conteudo()
  {
    return $this->_conteudo;
  }

  function set_conteudo($_conteudo)
  {
    $this->_conteudo = $_conteudo;
  }

  function get_urlQrCode()
  {
    return $this->_urlQrCode;
  }

  function set_urlQrCode($_urlQrCode)
  {
    $this->_urlQrCode = $_urlQrCode;
  }

  function get_destinofisico()
  {
    return $this->_destinofisico;
  }

  function set_destinofisico($_destinofisico)
  {
    $this->_destinofisico = $_destinofisico;
  }
  // </editor-fold>
}