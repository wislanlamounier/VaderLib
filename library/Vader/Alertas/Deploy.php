<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 06/11/2015
 * Time: 12:33
 */
class Vader_Alertas_Deploy
{
  protected $msg;
  protected $tipo;
  protected $type;
  protected $title;

  protected $showConfirmBtn = "true";
  protected $showCancelBtn =  "false";

  protected $closeOnConfirm = "true";
  protected $closeOnCancel =  "true";

  protected $confirmBtnColor = '#DD6B55';
  protected $confirmBtnText;
  protected $cancelBnText;

  protected $imageUrl;
  protected $imageSize = '80x80';

  protected $html = "false";
  protected $timer;
  protected $animation;

  protected $functionConfirm;
  protected $functionCancel;


  function __construct($estrutura)
  {
    if($estrutura->msg)
      $this->msg = $estrutura->msg;

    if($estrutura->tipo)
      $this->tipo = $estrutura->tipo;

    if($estrutura->type)
      $this->type = $estrutura->type;

    if($estrutura->title)
      $this->title = $estrutura->title;

    if($estrutura->showCancelBtn)
      $this->showCancelBtn = $estrutura->showCancelBtn;

    if($estrutura->showConfirmBtn)
      $this->showConfirmBtn = $estrutura->showConfirmBtn;

    if($estrutura->closeOnCancel)
      $this->closeOnCancel = $estrutura->closeOnCancel;

    if($estrutura->closeOnConfirm)
      $this->closeOnConfirm = $estrutura->closeOnConfirm;

    if($estrutura->confirmBtnColor)
      $this->confirmBtnColor = $estrutura->confirmBtnColor;

    if($estrutura->confirmBtnText)
      $this->confirmBtnText = $estrutura->confirmBtnText;

    if($estrutura->cancelBnText)
      $this->cancelBnText = $estrutura->cancelBnText;

    if($estrutura->imageUrl)
      $this->imageUrl = $estrutura->imageUrl;

    if($estrutura->imageSize)
      $this->imageSize = $estrutura->imageSize;

    if($estrutura->animation)
      $this->animation = $estrutura->animation;

    if($estrutura->functionConfirm)
      $this->functionConfirm = $estrutura->functionConfirm;

    if($estrutura->functionCancel)
      $this->functionCancel = $estrutura->functionCancel;

    if($estrutura->html)
      $this->html = $estrutura->html;

    if($estrutura->times)
      $this->timer = $estrutura->times;
  }

  public function Deploy()
  {
    $retorno = $this->getJS();

    return $retorno;
  }

  private function getJS()
  {
    $this->msg = trim(preg_replace('/\s\s+/', ' ', $this->msg));
    $this->msg = str_replace('"',"'",$this->msg);
    $js = 'swal({
    title: "'.$this->title.'",
    text: "'.$this->msg.'",
    type: "'.$this->type.'",
    showConfirmButton: '.$this->showConfirmBtn.',
    showCancelButton: '.$this->showCancelBtn.',

    closeOnConfirm: '.$this->closeOnConfirm.',
    closeOnCancel: '.$this->closeOnCancel.',

    confirmButtonColor: "'.$this->confirmBtnColor.'",
    confirmButtonText: "'.$this->confirmBtnText.'",
    imageUrl: "'.$this->imageUrl.'",
    imageSize:"'.$this->imageUrl.'",

    cancelButtonText: "'.$this->cancelBnText.'",

    html: '.$this->html.',

    timer: "'.$this->timer.'",

    animation: "'.$this->animation.'",

    },
    function(isConfirm){
       if(isConfirm)
       {
          '.$this->functionConfirm.'
       }
      else
      {
        '.$this->functionCancel.'
       }
    }
    );';
    return $js;
  }
}