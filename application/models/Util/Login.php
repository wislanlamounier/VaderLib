<?php
class Application_Model_Util_Login
{
  protected $_name;
  /**
  * @Versão   1.0.20140917
  * @Objetivo Retorna detalhes BOOL de login True para validado false para nao validado
  * @Autor    Tiago Alexandre
  * @Tabela   Alvo da tabela a ser verificado o Login
  * @Email    Email do guerreirinho
  * @Senha    Senha do Guerreirinho
  * @Licença  Mobilus Tecnologia Ltda
  */
  public function __construct($Tabela)
  {
    $this->_name = $Tabela;
  }
  public function FazerLogin($Email, $Senha, $where)
  {
    try
    {
      if($this->ValidaCampos($Email, $Senha, $this->_name) == true)
      {
        $resultado = $this->GetbyLogineSenha($Email, $Senha, $this->_name, $where);
        return $resultado;
      }
      else
      {
        return array('Resposta' => false, 'Motivo' => 'Campos não validados');
      }
    }
    catch (Exception $e)
    {
    throw new Exception ($e->getMessage());
    }
  }
  
  private function GetbyLogineSenha($Login, $Senha, $Tabela, $where)
  {
    $obj = new Application_Model_DbTable_logingenerico();
    try
    {
      $resultado = $obj->Login($Login, $Senha, $Tabela, $where);      
          
      return $resultado;
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }
  
  public function ValidaCampos($Email, $Senha, $Tabela)
  {
    $obj = new Default_Form_Cadastro();
    if($obj->Validarpreenchido(array($Email, $Senha, $Tabela)) == true)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
}