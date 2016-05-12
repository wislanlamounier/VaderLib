<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BaseAlertas
 *
 * @author Tiaguinho
 */
class Vader_Alertas_Builder
{
  const TIPO_NORMAL = 0;
  const TIPO_CONFIRM = 1;

  const TYPE_ALERT_AVISO = 'warning';
  const TYPE_ALERT_SUCESSO = 'success';
  const TYPE_ALERT_ERRO = 'error';
  const TYPE_ALERT_INFO = 'info';
  const TYPE_ALERT_NULL = '';

  const ANIMATION_TOP = 'slide-from-top';
  const ANIMATION_BAIXO = 'slide-from-bottom';

  public function __construct()
  {
    return $this;
  }

  public function tipoNormal()
  {
    return new Vader_Alertas_Normal();
  }

  public function tipoConfirm()
  {
    return new Vader_Alertas_Confirm();
  }
}