<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ServiceBaseController
 *
 * @author Cassio
 */
class Vader_Controller_BaseServicosController extends Vader_Controller_BaseController
{
  public function init()
  {
    header('Access-Control-Allow-Origin:*');  
    $auth = parent::servicos();
    try
    {
      parent::setNoLayout();
      $this->_helper->viewRenderer('service', null, true);
      parent::init();
      parent::getParansJson();
      
      $auth->set_credential($this->_config->host->chave);
      $auth->Autenticar($this->chave);
    }
    catch (Exception $e)
    {
      $auth->setRetornoException($e->getMessage());
      $json = $auth->montaJSON();
      echo $json;exit;
    }
  }
  
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
  
  public function retornaException($ErroMessage){
    
    $this->setRetornoException($ErroMessage);
    $json = $this->montaJSON();
    echo $json; exit;
  }
  
  public function retornaAlerta($Message){
    
    $this->setRetornoAlert($Message);
    $json = $this->montaJSON();
    echo $json; exit;
  }
  
  public function retornaSucesso()
  {
    $this->setRetornoSucesso();
    $json = $this->montaJSON();
    echo $json; exit;
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
        throw new Exception('Erro ao autenticar app');
      }

      return $valida;
    }
    else
    {
      throw new Exception('Erro ao autenticar app');
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
