<?php 

/**
 * Exibi as mensagens disparadas pelos ações da aplicação
 * Auxiliar da Camada de Visualização
 * @author Cristiano G Carvalho
 * @see APPLICATION_PATH/views/helpers/MensagemAcoes.php
 */

class Zend_View_Helper_MensagemAcoes extends Zend_View_Helper_Abstract {

    /**
     * Método Principal
     * @return string novo texto
     */
    public function mensagemacoes() {
        
        $session = Zend_Registry::get('session');

        if (isset($session->MensagemAcoes_Texto)) {
            $msg = '<div class="msg-' . $session->MensagemAcoes_Tipo . '">' . $session->MensagemAcoes_Texto . '</div>';
            unset($session->MensagemAcoes_Texto);
            unset($session->MensagemAcoes_Tipo);
            return $msg;
        }

        return null;
        
    }

}