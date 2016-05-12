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
class Vader_DbTable_JoinConfig
{
  public $joinTabela;
  public $joinCondicao;
  public $joinCampos;
  public $joinType;
  public $joinCardinalidade = '1:1';
  
  const UM_PARA_UM = '1:1';
  const UM_PARA_N = '1:n';
  const N_PARA_N = 'n:n';
  
  
  function setJoinCardinalidade($joinCardinalidade)
  {
    $this->joinCardinalidade = $joinCardinalidade;
    return $this;
  }
  
  function setJoinTabela($joinTabela)
  {
    $this->joinTabela = $joinTabela;
    return $this;
  }

  function setJoinCondicao($joinCondicao)
  {
    $this->joinCondicao = $joinCondicao;
    return $this;
  }

  function setJoinCampos($joinCampos)
  {
    $this->joinCampos = $joinCampos;
    return $this;
  }

  function setJoinType($joinType)
  {
    $this->joinType = $joinType;
    return $this;
  }


}
