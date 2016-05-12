<?php
class Default_Form_Formulas extends Zend_Validate
{
  public function init()
  {
    
  }
  public function CalculaPorcentagem(array $array)
  {
    echo json_encode($array);exit;
  }
  public function contadorDeMes($Resultado)
  {
    $ContadorMes[1] = 0;
    $ContadorMes[2] = 0;
    $ContadorMes[3] = 0;
    $ContadorMes[4] = 0;
    $ContadorMes[5] = 0;
    $ContadorMes[6] = 0;
    $ContadorMes[7] = 0;
    $ContadorMes[8] = 0;
    $ContadorMes[9] = 0;
    $ContadorMes[10] = 0;
    $ContadorMes[11] = 0;
    $ContadorMes[12] = 0;
    
    foreach($Resultado as $Mes)
      {
        switch ($Mes['Mes'])
        {
          case "1":
            $ContadorMes[1] += 1;
            break;
          case "2":
            $ContadorMes[2] += 1;
            break;
          case "3":
            $ContadorMes[3] += 1;
            break;
          case "4":
            $ContadorMes[4] += 1;
            break;
          case "5":
            $ContadorMes[5] += 1;
            break;
          case "6":
            $ContadorMes[6] += 1;
            break;
          case "7":
            $ContadorMes[7] += 1;
            break;
          case "8":
            $ContadorMes[8] += 1;
            break;
          case "9":
            $ContadorMes[9] += 1;
            break;
          case "10":
            $ContadorMes[10] += 1;
            break;
          case "11":
            $ContadorMes[11] += 1;
            break;
          case "12":
            $ContadorMes[12] += 1;
            break;
        }
      }
      return $ContadorMes;
  }
}