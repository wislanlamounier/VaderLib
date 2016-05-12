<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Vader_Email_BaseEmail
{

  protected $title = 'Título padrão da mobilus';
  protected $assunto;
  protected $body;
  protected $email;
  protected $html;
  
  // <editor-fold defaultstate="collapsed" desc="Caixa Titulo">
  protected $titleImagem = 'http://mobilus.com.br/img/imagens/cartao-mobilus-site.png';
  protected $titleImagemW = '180';
  protected $titleImagemH = '50';
  protected $titleImagemHref = '#';
  protected $titleLinks;
  // </editor-fold>
  // <editor-fold defaultstate="collapsed" desc="Cabeçalho">
  protected $cabImagem = '/fotos/img_palestra/no_image.gif';
  protected $cabImagemW = '600';
  protected $cabImagemH = '430';
  protected $cabTexto = '';
  protected $cabColor = '#404040';
  protected $cabHref = '#';
  // </editor-fold>
  // <editor-fold defaultstate="collapsed" desc="Corpo Email">
  protected $corpoColor = '#F4F4F4';
  protected $corpoTextColor = '#889098';
  protected $corpoTituloColor = '#404040';
  protected $corpoTexto = 'teste!';
  protected $corpoTitulo = 'Email Teste';
  protected $corpoTextoSize = '14px';
  protected $corpoTextoAlinhamento = 'center';
  // </editor-fold>
  // <editor-fold defaultstate="collapsed" desc="Rodapé">
  protected $rodapeImagem = '/fotos/img_palestra/no_image.gif';
  protected $rodapeImagemW = 73;
  protected $rodapeImagemH = 73;
  protected $rodapeColor = '#1a7d69';
  protected $rodapeHref = '#';

  // </editor-fold>
  
  protected $corPrincipal = '#1a7d69';
  protected $corSecundaria = '#1a7d69';
  protected $corRodape = '#1a7d69';

  public function MandarEmail()
  {
    try
    {
      $this->montarEmail();
      return $this->Enviar();
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
  }

  public function montarEmail()
  {
    $this->setBody();
    $this->html = '<!DOCTYPE html>'
            . '<html>'
            . '<head>'
            . '<title>' . $this->title . '</title>'
            . '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">'
            . '</head>'
            . '<body>'
            . $this->body
            . '</body>'
            . '</html>';
  }

  private function Enviar()
  {
    $Config = Zend_Registry::get('config');
    $settings = array('tls' => 'tls',
        'port' => 587,
        'auth' => 'login',
        'username' => $Config->mail->username,
        'password' => $Config->mail->password);
    $transport = new Zend_Mail_Transport_Smtp($Config->mail->host, $settings);
    $email_from = $Config->mail->sender_email;
    $name_from = $Config->mail->sender_name;
    $email_to = $this->email;
    $name_to = $this->email;

    $mail = new Zend_Mail ();
    $mail->setReplyTo($email_from, $name_from);
    $mail->setBodyHtml($this->html);
    $mail->setFrom($email_from, $name_from);
    $mail->addTo($email_to, $name_to);
    $subject = utf8_decode($this->assunto);
    $mail->setSubject($subject);
    $mail->setBodyText($this->html);
    try
    {
      $mail->send($transport);
      return true;
    }
    catch (Exception $ex)
    {
      throw new Exception($ex->getMessage());
    }
  }
  
  private function setBody()
  {
    $this->body = utf8_decode(
            '<style>

  /* Client-specific Styles */
  div, p, a, li, td {
    -webkit-text-size-adjust:none;
  }
  #outlook a {
    padding:0;
  } /* Force Outlook to provide a "view in browser" menu link. */
  html {
    width: 100%;
  }
  body {
    width:100% !important;
    -webkit-text-size-adjust:100%;
    -ms-text-size-adjust:100%;
    margin:0;
    padding:0;
  }
  /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
  .ExternalClass {
    width:100%;
  } /* Force Hotmail to display emails at full width */
  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
    line-height: 100%;
  } /* Force Hotmail to display normal line spacing. */
  #backgroundTable {
    margin:0;
    padding:0;
    width:100% !important;
    line-height: 100% !important;
  }
  img {
    outline:none;
    text-decoration:none;
    border:none;
    -ms-interpolation-mode: bicubic;
  }
  a img {
    border:none;
  }
  .image_fix {
    display:block;
  }
  p {
    margin: 0px 0px !important;
  }
  table td {
    border-collapse: collapse;
  }
  table {
    border-collapse:collapse;
    mso-table-lspace:0pt;
    mso-table-rspace:0pt;
  }
  a {
    color: #1a7d69;
    text-decoration: none;
    text-decoration:none!important;
  }
  /*STYLES*/
  table[class=full] {
    width: 100%;
    clear: both;
  }
  /*IPAD STYLES*/
  @media only screen and (max-width: 640px) {
    a[href^="tel"], a[href^="sms"] {
      text-decoration: none;
      color: #33b9ff; /* or whatever your want */
      pointer-events: none;
      cursor: default;
    }
    .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
      text-decoration: default;
      color: #1a7d69 !important;
      pointer-events: auto;
      cursor: default;
    }
    table[class=devicewidth] {
      width: 440px!important;
      text-align:center!important;
    }
    table[class=devicewidthinner] {
      width: 420px!important;
      text-align:center!important;
    }
    img[class=banner] {
      width: 440px!important;
      height:220px!important;
    }
    img[class=col2img] {
      width: 440px!important;
      height:220px!important;
    }
  }
  /*IPHONE STYLES*/
  @media only screen and (max-width: 480px) {
    a[href^="tel"], a[href^="sms"] {
      text-decoration: none;
      color: #33b9ff; /* or whatever your want */
      pointer-events: none;
      cursor: default;
    }
    .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
      text-decoration: default;
      color:#1a7d69 !important;
      pointer-events: auto;
      cursor: default;
    }
    table[class=devicewidth] {
      width: 280px!important;
      text-align:center!important;
    }
    table[class=devicewidthinner] {
      width: 260px!important;
      text-align:center!important;
    }
    img[class=banner] {
      width: 280px!important;
      height:140px!important;
    }
    img[class=col2img] {
      width: 280px!important;
      height:140px!important;
    }
  }

</style>
<!-- Start of preheader -->
<!-- End of preheader -->
<!-- Start of header -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="header" style="margin-top: 10px;">
  <tbody>
    <tr>
      <td>
        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
          <tbody>
            <tr>
              <td width="100%">
                <table width="600" bgcolor="'.$this->corSecundaria.'" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                  <tbody>
                    <tr>
                      <td>
                        <!-- logo -->
                        <table bgcolor="'.$this->corPrincipal.'" width="140" align="left" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                          <tbody>
                            <tr>
                              <td width="140" height="50" align="center">
                                <div class="imgpop">
                                  <a target="_blank" href="'.$this->titleImagemHref.'">
                                    <img src="'.$this->titleImagem.'" alt="" border="0" width="'.$this->titleImagemW.'" height="'.$this->titleImagemH.'" style="display:block; border:none; outline:none; text-decoration:none;">
                                  </a>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- end of logo -->
                        <!-- start of menu -->
                        <table bgcolor="'.$this->corSecundaria.'" width="250" height="50" border="0" align="right" valign="middle" cellpadding="0" cellspacing="0" border="0" class="devicewidth">
                          <tbody>
                            <tr>
                              '.$this->titleLinks.'
                            </tr>
                          </tbody>
                        </table>
                        <!-- end of menu -->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- End of Header -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
  <tbody>
    <tr>
      <td>
        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
          <tbody>
            <tr>
              <td align="center" height="30" style="font-size:1px; line-height:1px;">
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- End of seperator -->
<!-- Start of main-banner -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="banner">
  <tbody>
    <tr>
      <td>
        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
          <tbody>
            <tr>
              <td width="100%">
                <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                  <tbody>
                    <tr>
                      <!-- start of image -->
                      <td align="center" st-image="banner-image">
                        <div class="imgpop">
                          <a target="_blank" href="'.$this->cabHref.'">
                            <img border="0" width="' . $this->cabImagemW . '" height="' . $this->cabImagemH . '" alt="" style="display:block; border:none; outline:none; " src="' . $this->cabImagem . '">
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- end of image -->
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>

<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
  <tbody>
    <tr>
      <td>
        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
          <tbody>
            <tr>
              <td align="center" height="30" style="font-size:1px; line-height:1px;">
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- End of seperator -->
<!-- start of Full text -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
  <tbody>
    <tr>
      <td>
        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
          <tbody>
            <tr>
              <td width="100%">
                <table bgcolor="' . $this->corpoColor . '" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                  <tbody>
                    <!-- Spacing -->
                    <tr>
                      <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                        &nbsp;
                      </td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                      <td>
                        <table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">
                          <tbody>
                            <!-- Title -->
                            <tr>
                              <td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: ' . $this->corpoTituloColor . '; text-align:center; line-height: 24px;">
                                ' . $this->corpoTitulo . '
                              </td>
                            </tr>
                            <!-- End of Title -->
                            <!-- spacing -->
                            <tr>
                              <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                &nbsp;
                              </td>
                            </tr>
                            <!-- End of spacing -->
                            <!-- content -->
                            <tr>
                              <td style="font-family: Helvetica, arial, sans-serif; font-size: ' . $this->corpoTextoSize . '; color: ' . $this->corpoTextColor . '; text-align:' . $this->corpoTextoAlinhamento . '; line-height: 24px;">
                               ' . $this->corpoTexto . '
                               </td>
                            </tr>
                            <!-- End of content -->
                            <!-- Spacing -->
                            <tr>
                              <td width="100%" height="15" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                                &nbsp;
                              </td>
                            </tr>
                            <!-- Spacing -->
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                      <td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                        &nbsp;
                      </td>
                    </tr>
                    <!-- Spacing -->
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- End of Right Image -->
<!-- Start of seperator -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
  <tbody>
    <tr>
      <td>
        <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
          <tbody>
            <tr>
              <td align="center" height="30" style="font-size:1px; line-height:1px;">
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<!-- End of seperator -->
<!-- Start of footer -->
<table width="100%" bgcolor="#fcfcfc" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="footer">
  <tbody>
    <tr>
      <td>
        <table width="600" bgcolor="#e20404" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
          <tbody>
            <tr>
              <td width="100%">
                <table bgcolor="' . $this->rodapeColor . '" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                  <tbody>
                    <!-- Spacing -->
                    <tr>
                      <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                        &nbsp;
                      </td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                      <td>
                        <!-- Social icons -->
                        <table width="150" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth">
                          <tbody>
                            <tr>
                              <td align="left" width="20" style="font-size:1px; line-height:1px;">
                                &nbsp;
                              </td>
                              <td width="43" height="43" align="center">
                                <div class="imgpop">
                                  <a target="_blank" href="' . $this->rodapeHref . '">
                                    <img src="' . $this->rodapeImagem . '" alt="" border="1" width="' . $this->rodapeImagemW . '" height="' . $this->rodapeImagemH . '" style="display:block; border:none; outline:none; text-decoration:none;">
                                  </a>
                                </div>
                              </td>
                              <td align="left" width="20" style="font-size:1px; line-height:1px;">
                                &nbsp;
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <!-- end of Social icons -->
                      </td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                      <td height="10" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">
                        &nbsp;
                      </td>
                    </tr>
                    <!-- Spacing -->
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>');
  }

  function getEmail()
  {
    return $this->email;
  }

  function setEmail($email)
  {
    $this->email = $email;
  }

  function getHtml()
  {
    return $this->html;
  }

  function getRodapeImagem()
  {
    return $this->rodapeImagem;
  }

  function getRodapeImagemW()
  {
    return $this->rodapeImagemW;
  }

  function getRodapeImagemH()
  {
    return $this->rodapeImagemH;
  }

  function setHtml($html)
  {
    $this->html = $html;
  }

  function setRodapeImagem($rodapeImagem, $w = false, $h = false, $color = false, $href = false)
  {
    if($rodapeImagem)
      $this->rodapeImagem = $rodapeImagem;
    if($w)
      $this->setRodapeImagemW($w);
    if($h)
      $this->setRodapeImagemH($h);
    if($color)
      $this->setRodapeColor($color);
    if($href)
      $this->setRodapeHref($href);
  }

  function setCorpoTexto($texto = false, $textoColor = false, $textoColor = false, $textoSize = false, $textoAlinhamento, $titulo = false, $tituloColor = false)
  {
    if($texto)
      $this->corpoTexto = ($texto);
    if($textoColor)
      $this->setCorpoTextColor($textoColor);
    if($textoSize)
      $this->setCorpoTextoSize($textoSize);
    if($textoAlinhamento)
      $this->setCorpoTextoAlinhamento($textoAlinhamento);
    if($titulo)
      $this->setCorpoTitulo($titulo);
    if($tituloColor)
      $this->setCorpoTituloColor($tituloColor);
    if($textoColor)
      $this->setCorpoTextColor($textoColor);
  }

  function setCabImagem($cabImagem, $cabImagemW, $cabImagemH, $cabTexto, $cabColor, $cabHref)
  {
    if($cabImagem)
      $this->cabImagem = $cabImagem;
    if($cabImagemW)
    $this->setCabImagemW($cabImagemW);
    if($cabImagemH)
      $this->setCabImagemH($cabImagemH);
    if($cabTexto)
      $this->setCabTexto($cabTexto);
    if($cabColor)
      $this->setCabColor($cabColor);
    if($cabHref)
      $this->setCabHref($cabHref);
  }

  function getCorpoTexto()
  {
    return $this->corpoTexto;
  }

  function setRodapeImagemW($rodapeImagemW)
  {
    $this->rodapeImagemW = $rodapeImagemW;
  }

  function setRodapeImagemH($rodapeImagemH)
  {
    $this->rodapeImagemH = $rodapeImagemH;
  }

  function getRodapeColor()
  {
    return $this->rodapeColor;
  }

  function setRodapeColor($rodapeColor)
  {
    $this->rodapeColor = $rodapeColor;
  }

  function getRodapeHref()
  {
    return $this->rodapeHref;
  }

  function setRodapeHref($rodapeHref)
  {
    $this->rodapeHref = $rodapeHref;
  }

  function getCorpoColor()
  {
    return $this->corpoColor;
  }

  function getCorpoTextColor()
  {
    return $this->corpoTextColor;
  }

  function getCorpoTituloColor()
  {
    return $this->corpoTituloColor;
  }

  function getCorpoTitulo()
  {
    return $this->corpoTitulo;
  }

  function setCorpoColor($corpoColor)
  {
    $this->corpoColor = $corpoColor;
  }

  function setCorpoTextColor($corpoTextColor)
  {
    $this->corpoTextColor = $corpoTextColor;
  }

  function setCorpoTituloColor($corpoTituloColor)
  {
    $this->corpoTituloColor = $corpoTituloColor;
  }

  function setCorpoTitulo($corpoTitulo)
  {
    $this->corpoTitulo = $corpoTitulo;
  }

  function getCorpoTextoSize()
  {
    return $this->corpoTextoSize;
  }

  function getCorpoTextoAlinhamento()
  {
    return $this->corpoTextoAlinhamento;
  }

  function setCorpoTextoSize($corpoTextoSize)
  {
    $this->corpoTextoSize = $corpoTextoSize;
  }

  function setCorpoTextoAlinhamento($corpoTextoAlinhamento)
  {
    $this->corpoTextoAlinhamento = $corpoTextoAlinhamento;
  }

  function getCabImagem()
  {
    return $this->cabImagem;
  }

  function getCabTexto()
  {
    return $this->cabTexto;
  }

  function getCabColor()
  {
    return $this->cabColor;
  }

  function setCabTexto($cabTexto)
  {
    $this->cabTexto = $cabTexto;
  }

  function setCabColor($cabColor)
  {
    $this->cabColor = $cabColor;
  }

  function getTitle()
  {
    return $this->title;
  }

  function getAssunto()
  {
    return $this->assunto;
  }

  function getBody()
  {
    return $this->body;
  }
  
  function setTitle($title)
  {
    $this->title = $title;
  }

  function setAssunto($assunto)
  {
    $this->assunto = $assunto;
  }

  function getCabImagemW()
  {
    return $this->cabImagemW;
  }

  function getCabImagemH()
  {
    return $this->cabImagemH;
  }

  function setCabImagemW($cabImagemW)
  {
    $this->cabImagemW = $cabImagemW;
  }

  function setCabImagemH($cabImagemH)
  {
    $this->cabImagemH = $cabImagemH;
  }
  
  function getCabHref()
  {
    return $this->cabHref;
  }

  function setCabHref($cabHref)
  {
    $this->cabHref = $cabHref;
  }

  function getTitleImagem()
  {
    return $this->titleImagem;
  }

  function getTitleImagemW()
  {
    return $this->titleImagemW;
  }

  function getTitleImagemH()
  {
    return $this->titleImagemH;
  }

  function getTitleImagemHref()
  {
    return $this->titleImagemHref;
  }

  function getTitleLinks()
  {
    return $this->titleLinks;
  }
//  protected $titleImagem = 'http://mobilus.com.br/img/imagens/cartao-mobilus-site.png';
//  protected $titleImagemW = '180';
//  protected $titleImagemH = '50';
//  protected $titleImagemHref = '#';
//  protected $titleLinks;
  function setTitleImagem($titleImagem = false, $titleImagemW = false, $titleImagemH = false, $titleImagemHref = false, $titleLinks = false)
  {
    if($titleImagem)
      $this->titleImagem = $titleImagem;
    if($titleImagemW)
      $this->setTitleImagemW($titleImagemW);
    if($titleImagemH)
      $this->setTitleImagemH($titleImagemH);
    if($titleImagemHref)
      $this->setTitleImagemHref($titleImagemHref);
    if($titleLinks)
      $this->setTitleLinks($titleLinks);
  }

  function setTitleImagemW($titleImagemW)
  {
    $this->titleImagemW = $titleImagemW;
  }

  function setTitleImagemH($titleImagemH)
  {
    $this->titleImagemH = $titleImagemH;
  }

  function setTitleImagemHref($titleImagemHref)
  {
    $this->titleImagemHref = $titleImagemHref;
  }

  function setTitleLinks($titleLinks)
  {
    foreach($titleLinks as $chave => $valor)
    {
      $this->titleLinks .= '<td height="50" align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 13px;color: #282828" st-content="menu">
        <a href="'.$valor.'" target="_blank"style="color: #ffffff;text-decoration: none;">'.$chave.'</a>
        &nbsp;&nbsp;&nbsp;
      </td>';
    }
  }
  
  function setCores($principal, $segundaria, $rodape)
  {
    if($principal)
      $this->corPrincipal = $principal;
    if($segundaria)
      $this->corSecundaria = $segundaria;
    if($rodape)
      $this->rodapeColor = $rodape;
  }



}