<?php
/**
 * Extrai um resenha do texto com a quantidade de palavras especificadas
 * Auxiliar da Camada de Visualização
 * @author Cristiano G Carvalho
 * @see APPLICATION_PATH/views/helpers/TextoResenha.php
 */
class Zend_View_Helper_TextoResenha extends Zend_View_Helper_Abstract
{

    /**
     * Método Principal
     * @param string $texto texto original
     * @param string $palavras 
     * @return string novo texto
     */
    public function textoresenha($texto, $palavras)
    {
        $aux = explode(" ", $texto, $palavras);
        $novoTexto = null;

        for ($i = 0; $i < count($aux) - 1; $i++) {
            $novoTexto .= $aux[$i] . " ";
        }

        return $novoTexto . "...";
    }

}