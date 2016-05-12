<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Datas
 *
 * @author Tiaguinho
 */
class Vader_Formatadores_Datas
{
  protected $formato = 'Y-m-d H:i:s';
  protected $hora;
  protected $min;
  protected $data;
  
  protected $diaDiff;
  protected $mesDiff;
  protected $anoDiff;
  protected $horaDiff;
  protected $minDiff;
  protected $segundoDiff;

  const DOMINGO = 'Domingo';
  const SEGUNDA = 'Segunda';
  const TERCA = 'Terca';
  const QUARTA = 'Quarta';
  const QUINTA = 'Quinta';
  const SEXTA =  'Sexta';
  const SABADO = 'Sabado';

  public function convertHoraToMinuto($hora)
  {
    $quebraHora = explode(":",$hora);
    $minutos = $quebraHora[0];
    $minutos = $minutos*60;
    return $minutos = $minutos+$quebraHora[1];
  }
  
  public function getDataAtual()
  {
    return date($this->formato);
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
    $data = str_replace('/', '-', $data);
    $data = date('Y-m-d H:i:s', strtotime($data));
    $formatada = date($this->formato, strtotime($data));
    return $formatada;
  }
  
  public function adicionarHoras($data, $hora)
  {
    $data = str_replace('/', '-', $data);
    $data = date('Y-m-d H:i:s', strtotime($data));
    $min = $this->convertHoraToMinuto($hora);
    $horaFim = date('Y-m-d H:i:s', strtotime("".$data." + ".$min." minutes"));
    return $horaFim;
  }
  
  public function diminuirHoras($data, $hora)
  {
    $data = str_replace('/', '-', $data);
    $data = date('Y-m-d H:i:s', strtotime($data));
    $min = $this->convertHoraToMinuto($hora);
    $horaFim = date('Y-m-d H:i:s', strtotime("".$data." - ".$min." minutes"));
    return $horaFim;
  }
  
  public function diferencaData($data1, $data2)
  {
    $date1 = date_create($data1);
    $date2 = date_create($data2);
    $diff = date_diff($date1,$date2);
    
    $this->setSegundoDiff(str_pad($diff->format("%s"), 2,"0",STR_PAD_LEFT));
    $this->setMinDiff(str_pad($diff->format("%i"), 2,"0",STR_PAD_LEFT));
    $this->setHoraDiff(str_pad($diff->format("%h"), 2,"0",STR_PAD_LEFT));
    
    $this->setDiaDiff($diff->format("%a"));
    $this->setMesDiff($diff->format("%m"));
    $this->setAnoDiff($diff->format("%y"));
    return $this;
  }
  
  public function formatarListWithCampos($lista, $campos, $formato)
  {
    $this->setFormato($formato);
    foreach($lista as $chave => $valor)
    {
      $tipo = gettype($valor);
      $arrayValor = (array)$valor;
      foreach($campos as $campo)
      {
        if(array_key_exists($campo, $arrayValor))
        {
          $lista[$chave]->$campo = $this->formatarData($arrayValor[$campo]);
        }
      }
      
    }
    return $lista;
  }

  public function getDiaSemana($data)
  {
    $data_formatada = date('Y-m-d H:i:s', strtotime($data));
    /**
     * Lembrando que 0 é para Domingo
     * e 6 é Sabado;
     */
    $numero_data_semana = date('w', strtotime($data_formatada));

    if($numero_data_semana == 0)
      $semana = self::DOMINGO;

    else if($numero_data_semana == 1)
      $semana = self::SEGUNDA;

    else if($numero_data_semana == 2)
      $semana = self::TERCA;

    else if($numero_data_semana == 3)
      $semana = self::QUARTA;

    else if($numero_data_semana == 4)
      $semana = self::QUINTA;

    else if($numero_data_semana == 5)
      $semana = self::SEXTA;

    else if($numero_data_semana == 6)
      $semana = self::SABADO;

    return $semana;
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
  
  function getDiaDiff()
  {
    return $this->diaDiff;
  }

  function getMesDiff()
  {
    return $this->mesDiff;
  }

  function getAnoDiff()
  {
    return $this->anoDiff;
  }

  function getHoraDiff()
  {
    return $this->horaDiff;
  }

  function getMinDiff()
  {
    return $this->minDiff;
  }

  function getSegundoDiff()
  {
    return $this->segundoDiff;
  }

  function setDiaDiff($diaDiff)
  {
    $this->diaDiff = $diaDiff;
  }

  function setMesDiff($mesDiff)
  {
    $this->mesDiff = $mesDiff;
  }

  function setAnoDiff($anoDiff)
  {
    $this->anoDiff = $anoDiff;
  }

  function setHoraDiff($horaDiff)
  {
    $this->horaDiff = $horaDiff;
  }

  function setMinDiff($minDiff)
  {
    $this->minDiff = $minDiff;
  }

  function setSegundoDiff($segundoDiff)
  {
    $this->segundoDiff = $segundoDiff;
  }
}