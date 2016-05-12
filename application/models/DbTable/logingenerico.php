<?php
class Application_Model_DbTable_logingenerico extends Zend_Db_Table
{
  protected $_name = 'Aluno';
  
  public function Login($Login, $Senha, $Table, $where = false)
  {
    $this->_name = $Table;
    $sql = $this->select();
    $sql->setIntegrityCheck(false);
    $sql->from($Table);
    $sql->where("Email = ?", $Login);
    $sql->where("Senha = ?", $Senha);
    
    if($where){
      $sql->where($where);
    }
    return $this->fetchAll($sql)->toArray();
  }
}