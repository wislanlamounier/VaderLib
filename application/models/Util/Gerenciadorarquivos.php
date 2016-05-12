<?php
/**
 * Description of GerenciadorFiles
 * 
 * Faz upload 
 *
 * @author Tiaguinho
 */
class Application_Model_Util_Gerenciadorarquivos extends Vader_Gerenciador_BaseGerenciador
{
  public $filename;
  public $filehash;
  private $filesize;
  public $Destination;
  public $Caminho;
  private $pastaraiz;
  public $pasta;
  public $permissaoAtual;
  public $CaminhoSemDominio;
  protected $typeImagems = array("image/jpeg","image/png","application/octet-stream");
}