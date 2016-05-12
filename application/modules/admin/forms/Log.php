<?php
class Admin_Form_Log
{
  public function inserir($Localizacao, $Reposta, $Descricao = false)
  {
    $array = $this->arrayCadastro($Localizacao, $Reposta, $Descricao);
    $obj = new Application_Model_DbTable_log();
    try
    {
      $obj->insert($array);
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }
  private function arrayCadastro($Localizacao, $Reposta, $Descricao = false)
  {
    $array = array('Localizacao' => $Localizacao,
        'Resposta' => $Reposta,
        'Descricao' => $Descricao,
        'DataCadastro' => date('Y/m/d H:i:s'));
    return $array;
  }
}
