<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 06/11/2015
 * Time: 12:04
 */
class Vader_Alertas_Confirm extends Vader_Alertas_Deploy
{
  public $title;
  public $msg;

  public $tipo = Vader_Alertas_Builder::TIPO_CONFIRM;
  public $type = Vader_Alertas_Builder::TYPE_ALERT_SUCESSO;
  public $animation = Vader_Alertas_Builder::ANIMATION_BAIXO;

  public $showCancelBtn = "true";
  public $showConfirmBtn = "true";

  public $closeOnCancel = 'true';
  public $closeOnConfirm = 'false';

  public $functionConfirm = 'swal("Deletado com sucesso!", "Conseguimos deletar este item com sucess!.", "success");';
  public $functionCancel;

  /**
   * @param string $confirmBtnColor
   */
  public function setConfirmBtnColor($confirmBtnColor)
  {
    $this->confirmBtnColor = $confirmBtnColor;
    return $this;
  }

  /**
   * @param mixed $confirmBtnText
   */
  public function setConfirmBtnText($confirmBtnText)
  {
    $this->confirmBtnText = $confirmBtnText;
    return $this;
  }

  /**
   * @param mixed $cancelBnText
   */
  public function setCancelBnText($cancelBnText)
  {
    $this->cancelBnText = $cancelBnText;
    return $this;
  }





  function setMensagem($msg)
  {
    $this->msg = $msg;
    return $this;
  }

  function setTitle($title)
  {
    $this->title = $title;
    return $this;
  }

  function setFunctionConfirm($functionConfirm)
  {
    $this->functionConfirm = $functionConfirm;
    return $this;
  }

  function setFunctionCancel($functionCancel)
  {
    $this->functionCancel = $functionCancel;
    return $this;
  }

  function deploy()
  {
    return parent::Deploy();
  }

  /**
   * @param Voce pode pegar do constructor do builder
   * @var Vader_Alertas_Builder
   */
  function setType($type)
  {
    $this->type = $type;
    return $this;
  }

  /**
   * @param Voce pode pegar do constructor do builder
   * @var Vader_Alertas_Builder
   */
  function setAnimation($type)
  {
    $this->type = $type;
    return $this;
  }

  /**
   * @param string $closeOnCancel
   */
  public function setCloseOnCancel($closeOnCancel)
  {
    $this->closeOnCancel = $closeOnCancel;
    return $this;
  }

  /**
   * @param string $closeOnConfirm
   */
  public function setCloseOnConfirm($closeOnConfirm)
  {
    $this->closeOnConfirm = $closeOnConfirm;
    return $this;
  }
}