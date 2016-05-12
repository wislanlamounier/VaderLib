<?php
class Default_Form_Login
{
  /**
  * @Versão   1.0.20140917
  * @Objetivo Retorna detalhes BOOL de login True para validado false para nao validado
  * @Autor    Tiago Alexandre
  * @Tabela   Alvo da tabela a ser verificado o Login
  * @Email    Email do guerreirinho
  * @Senha    Senha do Guerreirinho
  * @Licença  Mobilus Tecnologia Ltda
  */
  public function FazerLogin($Email, $Senha, $Tabela, $where)
  {
    try
    {
      if($this->ValidaCampos($Email, $Senha, $Tabela) == true)
      {
        $resultado = $this->GetbyLogineSenha($Email, $Senha, $Tabela, $where);
        return $resultado;
      }
      else
      {
        return array('Resposta' => false, 'Motivo' => ErroPreenchimento);
      }
    }
    catch (Exception $e)
    {
    throw new Exception ($e);
    }
  }
  
  private function GetbyLogineSenha($Login, $Senha,$Tabela, $where)
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