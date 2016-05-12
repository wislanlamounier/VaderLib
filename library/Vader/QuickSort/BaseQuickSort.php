<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BaseQuickSort
 *
 * @author Tiaguinho
 */
class Vader_QuickSort_BaseQuickSort
{
  const ASC = 0;
  const DESC = 1;
  protected $campos;


  public static function orderBy(&$array, $campo, $Operador = 0)
  {
    //$this->campos = $campo;
    if($Operador == self::ASC)
    {
      function cmp($a, $b) {
            //return $a[$campo] > $b[$campo];
        }
    }
    else if($Operador == self::DESC)
    {
      
    }
      // Ordena
      usort($array, 'cmp');
  }
}