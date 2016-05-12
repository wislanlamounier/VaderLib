<?php
class Application_Model_RegraNegocio_ValidadorEmail extends Vader_Validadores_BaseValidadores
{
  public $email;
  public $length;
  public $validado = false;
  
  public function getbyEmail($email)
  {
    $dao = new Application_Model_DbTable_Usuario();
    $usuarios = $dao->getAll('UsuarioID', 'Email = "'.$email.'" ');
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
  
  public function getPalestranteByEmail($email)
  {
    $dao = new Application_Model_DbTable_Palestrante();
    $usuarios = $dao->getAll('PalestranteID', 'Email = "'.$email.'" ');
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