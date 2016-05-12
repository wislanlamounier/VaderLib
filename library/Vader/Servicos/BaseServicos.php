<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Gameteclib_Controller_BaseController
 *
 * @author Cassio
 */
class Vader_Servicos_BaseServicos
{

  // Variaveis Globais
  private $OcorreuErro;
  private $CodigoErro;
  private $DescricaoErro;
  private $OcorreuAlerta;
  private $CodigoAlerta;
  private $DescricaoAlerta;
  protected $_credential;
  
  
  /*
   * Função para preencher variaveis de Sucesso
   */

  public function setRetornoSucesso()
  {
    $this->OcorreuErro = "false";
    $this->DescricaoErro = null;
    $this->OcorreuAlerta = "false";
    $this->DescricaoAlerta = "";
  }

  /**
   * Função para preencher variaveis de Erro
   * @param type $ErrorMessage - Mensagem de erro que será retornada
   */
  public function setRetornoException($ErrorMessage)
  {
    $this->OcorreuErro = "true";
    $this->DescricaoErro = $ErrorMessage;
    $this->OcorreuAlerta = "false";
    $this->DescricaoAlerta = null;
    
  }

  /**
   * Função para preencher variaveis de Alerta
   * @param type $Message - Mensagem de alerta que será retornada
   */
  public function setRetornoAlert($Message)
  {
    $this->OcorreuErro = "false";
    $this->DescricaoErro = null;
    $this->OcorreuAlerta = "true";
    $this->DescricaoAlerta = $Message;
  }

   

  public function Autenticar($Chave)
  {
    if(!empty($Chave))
    {
      $valida = true;
      if($Chave != $this->_credential)
      {
        throw new Exception('Requisicao não é valida');
      }

      return $valida;
    }
    else
    {
      throw new Exception('Requisicao não é valida');
    }
  }
  /**
   * Função para transformar um array de objetos em uma string serializada com JSON
   * @param type $arrayObject
   * @return string
   */
  public function montaJSON($arrayObject = null)
  {
    $retorno = '{"OcorreuErro":' . $this->OcorreuErro . ',"DescricaoErro":"' . $this->DescricaoErro . '","OcorreuAlerta":' . $this->OcorreuAlerta . ',"DescricaoAlerta":"' . $this->DescricaoAlerta . '"';

    if($arrayObject == null)
      $retorno .= '}';
    else
    {
      foreach($arrayObject as $key => $value)
      {
        $retorno .= ',"' . $key . '": ' . json_encode($value);
      }
      $retorno .= '}';
    }

    return $retorno;
  }
  
  function get_credential()
  {
    return $this->_credential;
  }

  function set_credential($_credential)
  {
    $this->_credential = $_credential;
  }
}