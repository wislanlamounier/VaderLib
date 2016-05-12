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
class Vader_Calculos_BaseCalculos
{
  public function calcularPorcentagem($valor, $porcentagem)
  {
    $resultado = ($valor * $porcentagem) / 100;
    return $resultado;
  }
}