<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Avaliacao
 *
 * @author Bruno Marçal
 */
class Application_Model_RegraNegocio_Autenticacao extends Application_Model_DbTable_BaseDbTable
{
  // app_ipemed|6qD19WURsTcpiTo
  protected $_credential = 'a4909cc2a3e3e008d24706a0a27be4b5fa8222b5:19cc2740bdd3816e64400aac2e403461ac345c2b';

  public function Autenticar($Chave)
  {
    if(!empty($Chave))
    {
      $valida = true;
      if($Chave != $this->_credential)
        $valida = false;

      return $valida;
    }
  }
}