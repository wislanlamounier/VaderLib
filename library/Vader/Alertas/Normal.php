<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 06/11/2015
 * Time: 12:04
 */
class Vader_Alertas_Normal extends Vader_Alertas_Deploy
{
  public $title;
  public $msg;

  public $tipo = Vader_Alertas_Builder::TIPO_NORMAL;
  public $type = Vader_Alertas_Builder::TYPE_ALERT_SUCESSO;
  public $animation = Vader_Alertas_Builder::ANIMATION_BAIXO;
  public $confirmBtnColor;

  /**
   * @param mixed $confirmBtnText
   */
  public function setConfirmBtnText($confirmBtnText)
  {
    $this->confirmBtnText = $confirmBtnText;
    return $this;
  }



  /**
   * @param mixed $confirmBtnColor
   */
  public function setConfirmBtnColor($confirmBtnColor)
  {
    $this->confirmBtnColor = $confirmBtnColor;
    return $this;
  }


  function setMensagem($msg)
  {

    $str = str_replace("\n",' ',$msg);

    $this->msg = $str;
    return $this;
  }

  function setTitle($title)
  {
    $this->title = $title;
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
  function setAnimation($animation)
  {
    $this->animation = $animation;
    return $this;
  }
}