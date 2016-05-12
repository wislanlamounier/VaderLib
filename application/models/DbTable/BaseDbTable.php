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
class Application_Model_DbTable_BaseDbTable extends Zend_Db_Table
{
  public function getAll($colunas = false, $where = false, $campoTabel =false, $chave = false, $order = false)
  {
    $sql = $this->select();
    $sql->from($this->_name, $colunas);
    if(!empty($where))
      $sql->where($where);
    if($campoTabel && $chave)
    {
      $like = $this->like($campoTabel, $chave);
      $sql->where($like);
    }
    if($order)
      $sql->order($order);

    return $this->fetchAll($sql)->toArray();
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
  
  public function insertList($array)
  {
    foreach($array as $chave => $valor)
    {
      $this->insert((array)$valor);
    }
  }
}