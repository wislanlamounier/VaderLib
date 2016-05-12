<?php
class Vader_Login_BaseLogin extends Zend_Db_Table
{
  protected $_name = 't';
  protected $_tipoUsuario = false;
  protected $_tipousuarioTable = 'TipoUsuario';
  protected $_tipousuarioNome = 'Nome';
  protected $_tipousuarioApelido = 'DescTipoUsuario';
  protected $_tipousuarioFK = 'TipoUsuarioID';
  

  
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
    if($this->_tipoUsuario == true)
    {
      $sql->join(array('t'=>$this->_tipousuarioTable), $this->_name.'.'.$this->_tipousuarioFK .' = t.'.$this->_tipousuarioFK, array($this->_tipousuarioApelido => 't.'.$this->_tipousuarioNome));
    }
    return $this->fetchAll($sql)->toArray();
  }
  //<editor-fold defaultstate="collapsed" desc="Get & sets">
  function get_name()
  {
    return $this->_name;
  }
  
  function get_tipoUsuario()
  {
    return $this->_tipoUsuario;
  }

  function set_tipoUsuario($_tipoUsuario)
  {
    $this->_tipoUsuario = $_tipoUsuario;
  }
  
  function get_tipousuarioTable()
  {
    return $this->_tipousuarioTable;
  }

  function get_tipousuarioNome()
  {
    return $this->_tipousuarioNome;
  }

  function get_tipousuarioApelido()
  {
    return $this->_tipousuarioApelido;
  }

  function set_tipousuarioTable($_tipousuarioTable)
  {
    $this->_tipousuarioTable = $_tipousuarioTable;
  }

  function set_tipousuarioNome($_tipousuarioNome)
  {
    $this->_tipousuarioNome = $_tipousuarioNome;
  }

  function set_tipousuarioApelido($_tipousuarioApelido)
  {
    $this->_tipousuarioApelido = $_tipousuarioApelido;
  }
  
  function get_tipousuarioFK()
  {
    return $this->_tipousuarioFK;
  }

  function set_tipousuarioFK($_tipousuarioFK)
  {
    $this->_tipousuarioFK = $_tipousuarioFK;
  }
  //</editor-fold>
}