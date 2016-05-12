<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Qrcode
 *
 * @author Tiaguinho
 */
class Application_Model_Util_Qrcode extends Vader_Qrcode_Baseqrcode
{
  protected $_destino = 'images/QRCode/';
  protected $_id;
  protected $_baseUrl;
  protected $_conteudo;
  protected $_urlQrCode;
  protected $_destinofisico;
  

   
  public function getQrCode($Conteudo)
  {
    $this->set_conteudo($Conteudo);
    $this->getQRCodePNG();
  }
  
  // <editor-fold defaultstate="collapsed" desc="Gets and Setes">
  function get_destino()
  {
    return $this->_destino;
  }

  function get_id()
  {
    return $this->_id;
  }

  function get_baseUrl()
  {
    return $this->_baseUrl;
  }

  function get_conteudo()
  {
    return $this->_conteudo;
  }

  function set_destino($_destino)
  {
    $this->_destino = $_destino;
  }

  function set_id($_id)
  {
    $this->_id = $_id;
  }

  function set_baseUrl($_baseUrl)
  {
    $this->_baseUrl = $_baseUrl;
  }

  function set_conteudo($_conteudo)
  {
    $this->_conteudo = $_conteudo;
  }
  
  function get_urlQrCode()
  {
    return $this->_urlQrCode;
  }

  function get_destinofisico()
  {
    return $this->_destinofisico;
  }

  function set_urlQrCode($_urlQrCode)
  {
    $this->_urlQrCode = $_urlQrCode;
  }

  function set_destinofisico($_destinofisico)
  {
    $this->_destinofisico = $_destinofisico;
  }
  
  // </editor-fold>

}