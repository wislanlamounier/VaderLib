<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
  public function initResourceLoader()
  {
    parent::initResourceLoader();
    $this->libraryServidor();
  }
  
  /**
   * Libary para o servidor paralles, onde a estrutura de arquivos é diferente que a local
   */
  public function libraryServidor()
  {
    include 'library/PhpImagizer-ver1.0/PhpImagizer.php';
  }
  
  private function librarylocal()
  {
    include '../library/PhpImagizer-ver1.0/PhpImagizer.php';
  }
}

