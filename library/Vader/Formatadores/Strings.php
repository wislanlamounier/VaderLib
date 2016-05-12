<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Strings
 *
 * @author Tiaguinho
 */
class Vader_Formatadores_Strings
{
  public static $DINHEIRO = 0;
  public static $PADRAO_BRASILEIRO = 1;



  public function getPrimeiroNome($Nome)
  {
    $nome = explode(" ", $Nome);
    return $nome[0];
  }
  public function ReplaceCaracteres($string)
  {
    $str = $string; 
    $map = array(
        'á' => 'a',
        'à' => 'a',
        'ã' => 'a',
        'â' => 'a',
        'é' => 'e',
        'ê' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ç' => 'c',
        'Á' => 'A',
        'À' => 'A',
        'Ã' => 'A',
        'Â' => 'A',
        'É' => 'E',
        'Ê' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ú' => 'U',
        'Ü' => 'U',
        'Ç' => 'C',
    );
    $result = strtr($str, $map); 
    return $result;
  }
  
  public function formatNumberList($lista, $campos, $formato)
  {
    foreach($lista as $chave => $valor)
    {
      $tipo = gettype($valor);
      $arrayValor = (array)$valor;
      foreach($campos as $campo)
      {
        if(key_exists($campo, $arrayValor))
        {
          if(Vader_Formatadores_Strings::$DINHEIRO == $formato)
            $lista[$chave]->$campo = number_format($arrayValor[$campo],2, ',', '.');
    
          else if(Vader_Formatadores_Strings::$PADRAO_BRASILEIRO == $formato)
            $lista[$chave]->$campo = number_format($arrayValor[$campo],1, ',', '.');
        }
      }
    }
    return $lista;
  }

  public function convert_metros_km($metros)
  {
    return ($metros/1000);
  }
  
}