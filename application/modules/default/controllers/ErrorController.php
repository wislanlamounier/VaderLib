<?php
class default_ErrorController extends Zend_Controller_Action
{
  const BASE_URL = '/index';
  
  public $_pagina;
  public $_code;
  public $_message;
  public $_parans;
  public $_type;
  public $_error;
  public $_pagenotfound;


  public function init()
  {
    parent::init();
    $this->_helper->layout()->disableLayout();
    $this->setVariavel();
  }
  
  public function errorAction()
  {
      echo json_encode($this);exit;
    if(!$this->_error)
    {
      $this->view->message = 'You have reached the error page';
      return;
    }

    switch ($this->_type)
    {
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        // 404 error -- controller or action not found
        $this->getResponse()->setHttpResponseCode(404);
        
        $priority = Zend_Log::NOTICE;
        $this->view->message = $this->_message;
        $this->view->Cod = 404;
        break;
      default:
        // application error
        $this->getResponse()->setHttpResponseCode(500);
        $priority = Zend_Log::CRIT;
        $this->view->message = $this->_message;
        $this->view->Cod = $this->getResponse()->getHttpResponseCode();
        break;
    }

    $this->view->request = $this->_error->request;
    $this->view->url = self::BASE_URL;
    echo json_encode($this);exit;
  }

  public function getLog()
  {
    $bootstrap = $this->getInvokeArg('bootstrap');
    if(!$bootstrap->hasResource('Log'))
    {
      return false;
    }
    $log = $bootstrap->getResource('Log');
    return $log;
  }
  
  private function setVariavel()
  {
    
    $errors = $this->_getParam('error_handler');
    $this->_parans =  $this->getRequest()->getParams();
    $this->_pagina = $this->_parans['controller'];
    $this->_code = $errors->exception->getCode();
    $this->_message = $errors->exception->getMessage();
    $this->_error = $errors;
    $this->getPageNotFound();
    $this->getType();
  }
  
  private function getType()
  {
    if($this->_pagenotfound[2] == 'notfound')
      $this->_type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER;
    else
      $this->_type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
  }
  
  private function getPageNotFound()
  {
    $teste = explode("'", $this->_error->exception->getMessage());
    $teste = str_replace(' ', '', $teste);
    $this->_pagenotfound = $teste;
  }

}