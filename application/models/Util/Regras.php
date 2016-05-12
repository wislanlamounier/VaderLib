<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Regras
 *
 * @author Tiaguinho
 */
class Application_Model_Util_Regras
{
  // <editor-fold defaultstate="collapsed" desc="Dados para envio de email">
  protected $emailDestino;
  protected $assunto;
  protected $nomeUsuario;
  protected $title;
  protected $bodyEmail;
  protected $links;
  protected $textoCorpo;
  // </editor-fold>
  
  public function setBodyEmail($enviar = true)
  {
    $email = new Vader_Email_BaseEmail;
    
    $email->setAssunto($this->assunto);
    $email->setTitle($this->title);
    $email->setEmail($this->emailDestino);
    
    $email->setTitleImagem('http://votemix.mobilus.com.br/imagens/im_logo.png', "70%", "70%", '#', array('Página inicial' => 'http://votemix.mobilus.com.br/imagens/im_logo.png'));
    $email->setCabImagem('http://votemix.mobilus.com.br/imagens/im_logo.png', '50%', '50%', 'teste', 'white','#');
    $email->setCorpoTexto($this->links, null, null, null, null, $this->textoCorpo, null);
    $email->setRodapeImagem('http://votemix.mobilus.com.br/imagens/im_logo.png', 121, 41, null, 'http://mobilus.com.br/');
    $email->setCores('#25231F', '#666057', '#666057');
    $email->montarEmail();
    $this->bodyEmail = $email->getHtml();
    if($enviar != false)
      $email->MandarEmail();
  }
  
  public function setDadosEmail($assunto = false, $emailDestino = false, $title= false, $link = false, $textoCorpo = false)
  {
    if($assunto)
      $this->assunto = $assunto;
    
    if($emailDestino)
      $this->emailDestino = $emailDestino;
    
    if($title)
      $this->title = $title;
    
    if($link)
      $this->links .= '<a clor="#F9B733" target="_blank" href="'. $link[0] .'"><i style="color: black;" class="'.$link[2].' "></i>'.$link[1].'  </a><br/>';
    
    if($textoCorpo)
      $this->textoCorpo = $textoCorpo;
  }
  
  function getbodyEmail()
  {
    return $this->bodyEmail;
  }
}