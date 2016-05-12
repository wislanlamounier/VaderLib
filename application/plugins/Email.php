<?php 
/**
 * Email
 * 
 * Classe para fazer o envio de vários emails
 * 
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author Wanderson Flávo Santos de Amorim
 * @copyright Copyright (c) 2012
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
 * @filesource
 */

/*
 * Para utilizar esse plugin basta utilizar os codigos abaixo no seu controller;
 * 
 *  $email = new Plugin_Email();
  * $teste = $email->simples();
 * 
 */

class Plugin_Email  {
    
    public function simples($id = null) {
       

        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = " Esta é uma mensagem automática para informar que houve atualização na proposta do <br>
                      cliente $id  na página da Extranet Digicomp. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.";
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        //$mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function reenvia_senha($email,$senha) {
       

        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        
        $mensagem = "<html>
                        <head>
                            <title>Solicitação de Senha</title>
                        </head>
                        <body>
                            <p>Você solicitou sua senha através da App iEscritura no dia ".date('d/m/Y')." às ".date('H:i')." para acesso.</p>
                            <p>Sua senha é <strong>".$senha."</strong></p>
                            <br>
                            <p>Obrigado por usar o App iEscritura. Desejamos que você desfrute de todos os benefícios que este aplicativo lhe proporciona.</p>
                            <h4>Lalubema: apps para você!</h4>
                        </body>
                     </html>";
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom($config->mail->username, 'iEscritura');
        $mail->addTo($email, 'Nova atualização');
        $mail->setSubject('iEscritura - Reenvio de Senha');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function solicitar_servico($parametros) {
       
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        
        $mensagem = "
            <html>
                <head>
                    <title>Serviço online - Cartório Fácil</title>
                </head>

                <body style='font-family: Verdana, Arial; font-size: 12px;>
                    <div style='text-align:justify; text-justify:inter-word; border: none; width: 580px; margin: 0 auto; padding: 10px; border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px;'>
                        <p>Prezado(a),</p>
                        <p>O ".$parametros['Nome']." solicitou um atendimento no serviço online do App. Cartório Fácil. Segue abaixo as informações:</p>
                        <ul style='list-style: none;'>
                            <li style='padding: 8px 14px;'>Solicitante: ".$parametros['Nome']."</li>
                            <li style='padding: 8px 14px;'>Telefone: ".$parametros['Telefone']."</li>
                            <li style='padding: 8px 14px;'>Email: ".$parametros['Email']."</li>
                            <li style='padding: 8px 14px;'>Tipo de Escritura: ".$parametros['TipoEscritura']."</li>
                            <li style='padding: 8px 14px;'>Tipo de Documento: ".$parametros['TipoDocumento']."</li>
                        </ul>
                    </div>
                </body>

            </html>";
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom($config->mail->username, 'iEscritura');
        //$mail->addTo('bernardo.graciano@moisesfreire.com.br', 'Nova atualização');
        $mail->addTo('bruno.marcal@lalubema.com', 'Nova atualização');
        $mail->setSubject('iEscritura: Escritura: '.$parametros['TipoEscritura'].' - Doc.: '.$parametros['TipoDocumento']);
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
       
    
    public function cliente_adicionado($id) {
       

        $html_view = new Zend_View();
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = "Nova atualização";
        
        $html_view->mensagem = $mensagem;
        $html = $html_view->render('cliente.phtml');
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($id);           

        $mail = new Zend_Mail('utf-8');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Cliente Adicionado');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }  
    
    public function atualizacao_cliente() {
       

        $html_view = new Zend_View();
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = "Nova atualização";
        
        $html_view->mensagem = $mensagem;
        $html = $html_view->render('atualizacao_cliente.phtml');

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Extranet Digicomp cliente ');
        $mail->addTo('wanderson@olyva.com.br', 'Extranet Digicomp cliente ');        
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }      


    public function projetoAdicionado($proposta_id) {

        
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);
        
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = 'Esta é uma mensagem automática para informar que houve atualização de projeto na proposta ' . $proposta_nome['proposta_nome']. '. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        //$mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        //$mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    } 
    
   public function builtAdicionado($proposta_id) {
       
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);        
       
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = ' Esta é uma mensagem automática para informar que houve atualização de As Buil na proposta ' . $proposta_nome['proposta_nome']. '. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function docsAdicionado($proposta_id) {
       
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);            
        
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = ' Esta é uma mensagem automática para informar que houve atualização de Documentos na proposta ' . $proposta_nome['proposta_nome']. '. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function pendenciasAdicionado($proposta_id) {
       
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);            
        
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = ' Esta é uma mensagem automática para informar que houve atualização de Pendência na proposta ' . $proposta_nome['proposta_nome']. '. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function mensagemAdicionado($proposta_id) {
        
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);         
        
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = ' Esta é uma mensagem automática para informar que houve atualização em uma mensagem na proposta ' . $proposta_nome['proposta_nome'] .'. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
    public function satisfacaoAdicionado($proposta_id) {
        
        $objProposta = new Application_Model_DbTable_Proposta;
        $proposta_nome = $objProposta->getById($proposta_id);
        
        $objUsuario = new Application_Model_DbTable_Usuarios;
        $dado_email = $objUsuario->getById($proposta_nome['usuario_id']);           
        
        $html_view = new Zend_View();
        $config = Zend_Registry::get('config'); 
        $url =  $config->host->domain;
        $html_view->setScriptPath(APPLICATION_PATH . '/views/scripts/email');
        $mensagem = ' Esta é uma mensagem automática para informar que houve atualização de uma Pesquisa de Satisfação na proposta ' . $proposta_nome['proposta_nome'] .'. <br><br>
                      <a href='. $url .'> Clique para visualizar</a>. Ou, 
                      se preferir acesse a extranet direto do seu navegador.';
        
        $html_view->mensagem = $mensagem;
        $html = $mensagem;

        $mail = new Zend_Mail('utf-8');
        $mail->setFrom('flavinho177@gmail.com', 'Nova atualização');
        $mail->addTo('wanderson@olyva.com.br', 'Nova atualização');
        $mail->addTo('rayssa.fonseca@digicomp.com.br', 'Nova atualização');
        $mail->addTo($dado_email->usuario_email, 'Nova Atualização');
        $mail->setSubject('Extranet Digicomp');
        $mail->setBodyHtml($html);

        $mail->send();
            
    }
    
}

