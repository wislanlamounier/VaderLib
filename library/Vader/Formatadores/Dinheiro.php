<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 10/11/2015
 * Time: 16:34
 */
class Vader_Formatadores_Dinheiro
{
  public function convertDB($valor)
  {
    $valor = str_replace('R$','', $valor);
    $source = array('.', ',');
    $replace = array('', '.');
    $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
    return $valor;
  }

  public function convertDinheiro($valor)
  {
    return number_format($valor,2, ',', '.');
  }
}