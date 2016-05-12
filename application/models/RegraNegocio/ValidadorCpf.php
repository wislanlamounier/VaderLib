<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_RegraNegocio_ValidadorCpf extends Vader_Validadores_BaseValidadores
{
  public $cpf;
  public $length;
  public $validado = false;
  
  public function getbyCpf($cpf = false)
  {
    $dao = new Application_Model_DbTable_Usuario();
    $usuarios = $dao->getAll('UsuarioID', 'CPF = "'.$cpf.'" ');
    if(empty($usuarios))
    {
      $this->validado = true;
      return true;
    }
    else
    {
      $this->validado = false;
      return false;
    }
  }
}
