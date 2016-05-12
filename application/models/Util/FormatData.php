<?php
class Application_Model_Util_FormatData
{
  protected $formato = 'Y-m-d H:i:s';
  protected $hora;
  protected $min;
  protected $data;

  public function __construct($formato)
  {
    $this->setFormato($formato);
  }
  
  public function convertHoraToMinuto($hora)
  {
    $quebraHora = explode(":",$hora);
    $minutos = $quebraHora[0];
    $minutos = $minutos*60;
    return $minutos = $minutos+$quebraHora[1];
  }
  
  public function convertMinToHora($min)
  {
    $horas = (int)($min / 60);
    $resto =(int)($min % 60);
    $horas = $horas.'.'.$resto;
    
    return number_format($horas, 2, ':','.');
  }
  
  public function formatarData($data)
  {
    $formatada = date($this->formato, strtotime($data));
    return $formatada;
  }
  
  function getFormato()
  {
    return $this->formato;
  }

  function getHora()
  {
    return $this->hora;
  }

  function getMin()
  {
    return $this->min;
  }

  function getData()
  {
    return $this->data;
  }

  function setFormato($formato)
  {
    $this->formato = $formato;
  }

  function setHora($hora)
  {
    $this->hora = $hora;
  }

  function setMin($min)
  {
    $this->min = $min;
  }

  function setData($data)
  {
    $this->data = $data;
  }
  
}
