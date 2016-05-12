<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of BaseArray
 *
 * @author Tiaguinho
 */
class Vader_Tratamento_BaseArray
{
  public static function QuickSort($array, $chave_ordenacao)
  {
    ksort($array);
    echo json_encode($array);exit;
  }
}