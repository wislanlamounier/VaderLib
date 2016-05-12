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
class Vader_Controller_BaseController extends Zend_Controller_Action
{
  protected $_where;
  protected $_session;
  protected $_usuario;
  protected $_parans;
  protected $_paginaAtual;
  protected $_config;
  protected $VWx0aW1hUGFnaW5h;
  protected $p_pesquisa;
  protected $_ultimaUrl;
  protected $typeImagems = array("image/jpeg", "image/png", "application/octet-stream");
  protected $_dao;
  protected $_urlReferer;

  protected $_urlController;
  protected $objMsg;


  protected $_menssagem = 'Default';
  protected $_alert = 'AlertSucesso';
  protected $_Url = '/';
  
  const PERMISSAO_VISUALISAR_SE_LOGADO = 1;
  const PERMISSAO_VISUALIZAR_SEMPRE = 2;
  const PERMISSAO_PADRAO = self::PERMISSAO_VISUALISAR_SE_LOGADO;
  const IMAGEM_PADRAO = '/fotos/padrao/no_image.gif';
  
  private $db;
  
  public function init()
  {
    parent::init();
    $this->_urlController = $_SERVER['REQUEST_URI'];
    ini_set('display_errors',0);
    $this->_config = Zend_Registry::get('config');
    $this->_parans = $this->getRequest()->getParams();
    $this->_session = Zend_Registry::get('session');
    $this->view->msg = $this->_helper->flashMessenger->getMessages();

    if($this->view->msg[3])
      $this->setviewAlertaAlt($this->view->msg[3]);

    $this->servicos = new Vader_Servicos_BaseServicos();
    $this->view->baseName = $this->getNomeProjeto();
    $this->getParans();
    $this->view->UltimaPagina = base64_decode($this->VWx0aW1hUGFnaW5h);
    $this->_ultimaUrl = base64_decode($this->VWx0aW1hUGFnaW5h);
    if($this->_config->verificador->version == 1)
      $this->verificarLIB();

    $this->seturlReferer();
  }
  
  protected function getParans()
  {
    foreach($this->_parans as $chave => $valor )
    {
      $this->$chave = $valor;      
    }
    $this->_paginaAtual = $_SERVER['REQUEST_URI'];
  }
  
  protected function indexAction()
  {
  }
  
  protected function isLoggedIn()
  {
    if(empty($this->session->usuario))
    {
      return false;
    }
    else
    {
      return true;
    }
  }
  protected function criarSessao($usuario)
  {
    $this->session->usuario = $usuario;
  }
  protected function isPost()
  {
    $isPost = $this->getRequest()->isPost();
    return $isPost;
  }
  /**
   * @Objetivo Acesse as constantes da classe Gameteclib_Controller_AdminBaseController
   * para consultar as permissoes (PERMISSAO_LOGADO, PERMISSAO_DESLOGADO, PERMISSAO_VISITANTE
   * @Autor Cássio
   */
  protected function setPermissao($permissao)
  {
    $this->view->permissao = $permissao;
  }
  
  public function getSession()
  {
    
  }
  
  protected function KickUser()
  { 
    $this->_helper->flashMessenger->addMessage('Você nao tem permissão para acessar essa página');
    $this->_helper->flashMessenger->addMessage('AlertErro');
    $this->_redirect($this->_url);
  }

  /**
   * Redirect to another URL
   *
   * Proxies to {@link Zend_Controller_Action_Helper_Redirector::gotoUrl()}.
   *
   * @param string $url
   * @param array $options Options to be used when redirecting
   * @return void
   * @deprecated Deprecated as of Zend Framework 1.7. Use
   *             redirecionar()-> instead.
   */
  protected function _redicionar()
  {
    $this->_menssagem = substr($this->_menssagem, 0, 50); 
    $this->_helper->flashMessenger->addMessage($this->_menssagem);
    $this->_helper->flashMessenger->addMessage($this->_alert);
    $this->_helper->flashMessenger->addMessage($this->_parans);
    $this->_redirect($this->_Url);
  }

  protected function redirecionar(Vader_Redirect_BaseRedirect $obj)
  {
    $obj->_menssagem = substr($obj->_menssagem, 0, 50);
    $this->_helper->flashMessenger->addMessage($obj->_menssagem);
    $this->_helper->flashMessenger->addMessage($obj->_alert);
    $this->_helper->flashMessenger->addMessage($this->_parans);
    $this->_helper->flashMessenger->addMessage($this->objMsg->alertaAlt);
    $this->setviewAlertaAlt($obj->alertaAlt);
    $this->redirect($obj->_Url);
  }

  protected function redirecionarV1($js, $url)
  {
    $this->_helper->flashMessenger->addMessage(null);
    $this->_helper->flashMessenger->addMessage(null);
    $this->_helper->flashMessenger->addMessage($this->_parans);
    $this->_helper->flashMessenger->addMessage($js);
    $this->redirect($url);
  }
  
  protected function _salvarLog($Descricao)
  {
    $obj = new Application_Model_Class_log();
    $dao = new Application_Model_DbTable_log();
    $obj = $obj->getNomesAtributos();
    $array = array($obj->Descricao => $Descricao, $obj->DataCadastro => date('Y-m-d H:i:s'));
    $dao->insert($array);
  }
  
  protected function logoutAction()
  {
    Zend_Auth::getInstance()->clearIdentity();
    Zend_Session::destroy(true);
    $this->_redirect($this->_Url);
  }
  
  protected function validarPreenchimento($parans)
  {
    $resposta = 0;
    foreach($parans as $validacoes)
    {
      if(empty($validacoes))
      {
        $resposta += 1;
      }
      if($validacoes == null)
      {
        $resposta +=1;
      }
    }
    if($resposta == 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  protected function setNoLayout()
  {
    $this->_helper->layout()->disableLayout();
    $this->getResponse()->setHeader('Content-Type', 'application/json');
    header('Content-type: application/json; charset=UTF-8');
  }
  
  protected function beginTransaction()
  {
    $this->initDbTable();
    $this->db->beginTransaction();
  }
  
  protected function commit()
  {
    $this->db->commit();
  }
  
  protected function rollBack()
  {
    $this->db->rollBack();
  }


  private function initDbTable()
  {
    $this->db = Zend_Db_Table_Abstract::getDefaultAdapter();
  }
  
  protected function servicos()
  {
    $servicos = new Vader_Servicos_BaseServicos();
    return $servicos;
  }
  
  protected function formatStrings()
  {
    $format = new Vader_Formatadores_Strings();
    return $format;
  }
  
  protected function formatData()
  {
    $format = new Vader_Formatadores_Datas();
    return $format;
  }

  protected function formatDinheiro()
  {
    $format = new Vader_Formatadores_Dinheiro();
    return $format;
  }
  
  protected function calcular()
  {
    $calc = new Vader_Calculos_BaseCalculos();
    return $calc;
  }


  protected function getArrayByJson()
  {
    $json = $this->getRequest()->getRawBody();
    $array = Zend_Json::decode($json);
    return $array;
  }
  
  protected function getParansJson()
  {
    $json = $this->getArrayByJson();
    if(!empty($json))
    {
      $this->_parans += $json;
    }
    $this->getParans();
  }
  
  protected function getNomeProjeto()
  {
    return $this->_config->host->name;
  }
  
  private function verificarLIB()
  {
    $update = new MLU_BaseUpdater($this->_config->ftp->host, $this->_config->ftp->user, $this->_config->ftp->pass);
    $update->update('library/', 'php', $this->_config->lib->version);
  }
  
  protected function auth($role, $msg = true)
  {
    $this->view->Loguin = true;
    if($role != 'allow')
    {
      if(!is_array($role))
        $array = split(',', $role);
      else
        $array = $role;
      foreach($array as $chave => $valor)
      {
        if(!empty($this->_session->$valor))
        {
          $testeChave++;
        }
      }
      if($testeChave == 0)
      {
        $this->view->SemPermissao = 1;
        $this->view->Loguin = false;
        if($msg)
        {
          $this->view->msg[0] = 'Você não tem permissão para acessar essa página, logue com um usuario que tenha';
          $this->view->msg[1] = 'AlertLog';
        }
      }
    }
  }
  
  protected function excluirAction()
  {
    try
    {
      $this->beginTransaction();
      $this->_dao->delete($this->_where);
      $this->commit();
      return true;
    }
    catch (Exception $e)
    {
      $this->rollBack();
      if($e->getCode() == 23000)
        throw new Exception('Existem itens vinculados com este registro');
      else
        throw new Exception($e->getMessage);
    }
  }
  
  protected function inserirG(Vader_DbTable_BaseDbTable $dao, $obj)
  {
    return $dao->insert((array)$obj, true);
  }
  
  protected function editarG(Vader_DbTable_BaseDbTable $dao, $obj, $where)
  {
    return $dao->update((array)$obj, $where);
  }
  
  protected function setViewG(Vader_Class_BaseClass $obj, $array)
  {
    $obj->getParansByObjeto((array)$array);
    $this->_parans += (Vader_Class_BaseClass::$arrayParans);
    return $this->_parans;
  }
  
  protected function getObjG(Vader_Class_BaseClass $class, $array)
  {
    return $class->getObjList($array);
  }
  
  function geturlReferer()
  {
    return $this->_urlReferer;
  }
  
  function seturlReferer()
  {
    $this->_urlReferer = $_SERVER['HTTP_REFERER'];
  }

  public function setviewAlertaAlt($js)
  {
    $this->view->alertsMobilusLib =  $js;
  }

  public function getObjByParansG(Vader_Class_BaseClass $obj)
  {
    $objeto = $obj->getObjetobyParans($this->_parans);
    return $objeto;
  }
}
