<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 30/10/2015
 * Time: 17:31
 */
class Vader_Redirect_BaseRedirect
{
  public $_menssagem;
  public $_alert;
  public $_Url;
  public $alertaAlt;


  const ALERT_LOG = 'AlertLog';
  const ALERT_SUCESSO = 'AlertSucesso';
  const ALERT_ERROR = 'AlertErro';
  const ALERTA = 'Alert';

  public function __construct()
  {
    return $this;
  }
  /**
   * @return mixed
   */
  private function getMenssagem()
  {
    return $this->_menssagem;
  }

  /**
   * @param mixed $menssagem
   */
  public function setMenssagem($menssagem)
  {
    $this->_menssagem = $menssagem;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getAlert()
  {
    return $this->_alert;
  }

  /**
   * @param mixed $alert
   */
  public function setAlert($alert)
  {
    $this->_alert = $alert;
    return $this;
  }
  /**
   * @return mixed
   */
  private function getUrl()
  {
    return $this->_Url;
  }

  /**
   * @param mixed $Url
   */
  public function setUrl($Url)
  {
    $this->_Url = $Url;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getAlertaAmsong()
  {
    return $this->alertaAmsong;
  }

  /**
   * @param mixed $alertasAlt
   */
  public function setAlertaAlt($alertaAmsong)
  {
    $this->alertaAlt = $alertaAmsong;
  }


}