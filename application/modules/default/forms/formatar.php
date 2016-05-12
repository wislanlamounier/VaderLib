<?php
class Default_Form_Formatar extends Zend_Validate
{
  public function init()
  {
    
  }
  public function getPrimeiroNome($nome)
  {
    $name = $nome;
    $first = strstr($name, ' ', true);
    return $first;
  }
}