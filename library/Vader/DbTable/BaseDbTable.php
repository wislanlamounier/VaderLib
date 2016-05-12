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
class Vader_DbTable_BaseDbTable extends Zend_Db_Table
{
  public $JOIN_LEFT = "joinLeft";
  public $JOIN = "join";
  public $JOIN_CROSS = "joinCross";
  public $JOIN_INNER= "joinInner";
  public $JOIN_RIGHT= "joinRight";
  public $JOIN_NATURAL= "joinNatural";
  PUBLIC $JOIN_FULL = "joinFull";
  private $retornaSql = false;
  
  
  public $join = false;
  
  public function insert(array $data, $validar = false)
  {
    if($validar)
      $this->verificaCampos($data);
      
    return parent::insert($data);
  }
  
  public function update(array $data, $where)
  {
    return parent::update($data, $where);
  }
  
  private function verificaCampos($data)
  {
    $validador = new Vader_Validadores_BaseValidadores();
    $validador->validarBancoDeDados($this->_name, $data);
  }

  public function getAll($colunas = false, $where = false, $campoTabel =false, $chave = false, $order = false, $group = false, $limit)
  {
    $obj = new Vader_DbTable_JoinConfig();
    $sql = $this->select();
    $sql->from($this->_name, $colunas);
    $sql->setIntegrityCheck(false);
    if(!empty($where))
      $sql->where($where);
    if($campoTabel && $chave)
    {
      $like = $this->like($campoTabel, $chave);
      $sql->where($like);
    }
    if($group)
      $sql->group($group);
    
    if($order)
      $sql->order($order);
    
    
    if(!empty($this->join))
    {
      //echo json_encode($this->join);exit;
      foreach($this->join as $chave => $obj)
      {
        if(empty($obj->joinType))
          $obj->joinType = $this->JOIN_LEFT;
        
        if(empty($obj->joinTabela))
          throw new Exception('Tabela para o join não foi setada');
        
        if(empty($obj->joinCondicao))
          $obj->joinCondicao = $obj->joinTabela.'.'.$obj->joinTabela.'ID = '.$this->_name.'.'.$obj->joinTabela.'ID';
        
        $joinType = $obj->joinType;
        
        $sql->$joinType($obj->joinTabela, $obj->joinCondicao,$obj->joinCampos);
      }
    }

    if(!empty($limit))
      $sql->limit($limit);
    
    if($this->retornaSql == true)
    {
      return $sql;
    }
    else
    {
      return $this->fetchAll($sql)->toArray();
    }
  }
                       
  public function like($Campos, $chave)
  {
    $i = 0;
      foreach ($Campos as $Campos)
      {
        if ($i == 0)
          $where = $where . ' ' . $Campos . ' LIKE  "%'. $chave .'%" ';
        else
          $where = $where . ' OR ' . $Campos . ' LIKE "%'. $chave .'%" ';
        $i++;
      }
      return $where;
  }
  
  public function getLastRegistro($colunas = false, $where = false, $campoTabel =false, $chave = false, $order = false)
  {
    $obj = new Vader_DbTable_JoinConfig();
    $sql = $this->select();
    $sql->from($this->_name, $colunas);
    $sql->setIntegrityCheck(false);
    if(!empty($where))
      $sql->where($where);
    if($campoTabel && $chave)
    {
      $like = $this->like($campoTabel, $chave);
      $sql->where($like);
    }
    $sql->order($this->_name.'ID DESC');
    
    
    if(!empty($this->join))
    {
      //echo json_encode($this->join);exit;
      foreach($this->join as $chave => $obj)
      {
        if(empty($obj->joinType))
          $obj->joinType = $this->JOIN_LEFT;
        
        if(empty($obj->joinTabela))
          throw new Exception('Tabela para o join não foi setada');
        
        if(empty($obj->joinCondicao))
          $obj->joinCondicao = $obj->joinTabela.'.'.$obj->joinTabela.'ID = '.$this->_name.'.'.$obj->joinTabela.'ID';
        
        $joinType = $obj->joinType;
        
        $sql->$joinType($obj->joinTabela, $obj->joinCondicao,$obj->joinCampos);
      }
    }
    $sql->limit(1);
    $total = $this->fetchAll($sql)->toArray();
    return $total[0];
  }
  
  public function insertBigList($list)
  {
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $query = 'INSERT INTO '.$this->_name.' (';
    foreach($list[0] as $chave => $valor)
    {
      $query .=$chave.",";
    }
    $query = substr($query, 0, -1);
    $query .= ') VALUES ';
    
    foreach($list as $key => $value)
    {
      $valuesInsert .= '(';
      foreach($value as $chaveinsert => $teste)
      {
        $valuesInsert .= $teste.',';
      }
      $valuesInsert = substr($valuesInsert, 0, -1);
      $valuesInsert .= '),';
    }
    $query .= $valuesInsert;
    $queryFinal = substr($query, 0, -1);
    $db->query($queryFinal);
  }
  
  public function insertList($array)
  {
    foreach($array as $chave => $valor)
    {
      $this->insert((array)$valor);
    }
  }

  function addJoin($join)
  {
    $this->join[] = $join;
    return $this;
  }
  
  function join()
  {
    return new Vader_DbTable_JoinConfig();
  }
  
  function retornaSql($bool)
  {
    $this->retornaSql = $bool;
  }
}