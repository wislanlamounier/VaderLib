<?php
class Default_Form_Servidor
{
  public function ExcluirImagem($url)
  {
    $Config = Zend_Registry::get('config');
    $urlfoto = str_replace($Config->host->domain, '', $url);
    unlink($urlfoto);
  }
  public static function ExcluirImagemStatic($url)
  {
    $Config = Zend_Registry::get('config');
    $urlfoto = str_replace($Config->host->domain, '', $url);
    unlink($urlfoto);
  }
}