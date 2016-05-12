<?php
class Default_Form_Email extends Zend_Mail
{
  public function init()
  {
    
  }
  public function MandarEmail($confirmaemail, $subject, $body)
  {
    try
    {
      return $this->MontarHtml($body, $confirmaemail, $subject);
    }
    catch (Exception $e)
    {
      throw new Exception($e);
    }
  }
  
  private function MontarHtml($body, $confirmaemail, $subject)
  {
    $Config = Zend_Registry::get('config');
    $html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
            <html>
               <head>
                 <meta http-equiv="content-type" content="text/html; charset=windows-1250">
                 <title></title>
                </head>
                <body style="background-color: #FAFAFA">
                <br />
                <br />
        	    <br />
        	    <div style="width:"810px"">
                  ' . $body . '
                </div>
                <br />
                <br />
                </body>
            </html>';
    try
    {
      return $this->Enviar($confirmaemail, $html, $subject);
    }
    catch (Exception $e)
    {
      throw new Exception($e);
    }
  }
  private function Enviar($email, $html, $subject)
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
    $email_to = $email;
    $name_to = $email;

    $mail = new Zend_Mail ();
    $mail->setReplyTo($email_from, $name_from);
    $mail->setBodyHtml($html);
    $mail->setFrom($email_from, $name_from);
    $mail->addTo($email_to, $name_to);
    $subject = utf8_decode($subject);
    $mail->setSubject($subject);
    $mail->setBodyText($html);
    try
    {
      $mail->send($transport);
      return true;
    }
    catch (Exception $ex)
    {
      throw new Exception($ex);
    }
    
  }
//==============================================================================================================
//Aqui acaba a configuração do Envio de e-mail
//==============================================================================================================
}