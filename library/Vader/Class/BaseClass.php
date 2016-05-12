<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BaseDbTable
 *
 * @author Tiaguinho
 */
class Vader_Class_BaseClass
{
  
  private $paransView;
  private function getObj($array)
  {
    
    $array = (array)$array;
    foreach($array as $nome => $info)
    {
      $this->$nome = $array[$nome];
    }
    
    foreach($this as $key => $value)
    {
      if($value === null || $value == "")
      {
        unset($this->$key);
      }
    }
    
    
    foreach($this as $chave => $valor)
    {
      $val[$chave] = $valor;
    }
    return (object)$val;
  }

  public function getObjList($array)
  {
    $array = (array)$array;
    foreach($array as $key => $value)
    {
      $listaObj[$key] = $this->getObj($value);
    }
    return $listaObj;
  }

  public function insertList($dao, $listObj)
  {
    foreach($listaObj as $key => $value)
    {
      foreach($value as $chave => $valor)
      {
        $objArray = Array($chave => $valor);
      }
      $dao->insert($data);
    }
  }
  
  public function getNomesAtributos()
  {
    foreach($this as $key => $val)
    {
      $array[$key] = $key;
    }
    $obj = $this->getObj($array);
    return $obj;
  }
  
  public function getPrimeiroNome($Nome)
  {
    $nome = explode(" ", $Nome);
    return $nome[0];
  }
  
  public function getObjetobyParans($parans)
  {
    
    foreach($this as $key => $val)
    {
      $array[$key] = $key;
    }
    $atributos = $this->getObj($array);
    $this->paransView = $parans;
    $array = $this->getArrayObejtos($atributos);
    $this->ajustarParans();
    foreach($this->paransView as $chave => $valor)
    {
      $chaveArray = array_search($chave , $array, false);
      if($chaveArray)
      {
        $objeto[$chaveArray] = $valor;
      }
    }
    
    return (object)$objeto;
  }
  
  public static $arrayParans;
  
  public function getParansByObjeto($parans , $posicao)
  {
    foreach($parans as $key => $value)
    {
      if(is_array($value) && !empty($value))
      {
        $this->getParansByObjeto($value, $key);
      }
      else
      {
        if(empty($posicao))
        {
          if(ctype_upper($key))
          {
            self::$arrayParans["p_" . strtolower($key)] = $value;
          }
          else
          {
            $povaPos = lcfirst($key);
            self::$arrayParans["p_" . $povaPos] = $value; 
          }
        }
        else
        {
          $povaPos = lcfirst($posicao);
          self::$arrayParans["p_" . $povaPos][$key] = $value;
        }
      }
    }


//    $this->paransView = $parans;
//    $array = $this->getArrayObejtos($atributos);
//    $this->ajustarParans();
//    foreach($this->paransView as $chave => $valor)
//    {
//      $chaveArray = array_search($chave , $array, false);
//      if($chaveArray)
//      {
//        $objeto[$chaveArray] = $valor;
//      }
//    }
//    return (object)$objeto;
  }
  
  private function ajustarParans()
  {
    
    unset($this->paransView['controller']);
    unset($this->paransView['action']);
    unset($this->paransView['VWx0aW1hUGFnaW5h']);
    unset($this->paransView['module']);
    //unset($this->paransView['p_imagemAntiga']);

    
    foreach($this->paransView as $key => $value)
    {
      $NovaKey = strtoupper(str_replace('p_', '', $key));
      $this->paransView[$NovaKey] = $value;
      if($NovaKey != $key){
        unset($this->paransView[$key]);
      }
    }
  }
  
  private function getArrayObejtos($objetos)
  {
    $objetos = (array)$objetos;
    foreach($objetos as $chave => $valor)
    {
      $objetos[$chave] = strtoupper($valor);
    }
    return $objetos;
  }
  
  public function validate($obj)
  {
    $obj = array($obj);
    $validador = new Vader_Validadores_BaseValidadores();
    $obj = $obj[0];
    $class = get_called_class();
    $class = split('_', $class);
    $model = $class[count($class) -1 ];
    $validador->validarBancoDeDados($model, $obj);
  }

}