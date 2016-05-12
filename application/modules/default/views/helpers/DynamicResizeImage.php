<?php

/**
 * Redimensionamento de imagem em tempo de execução
 * Auxiliar da Camada de Visualização
 * @author Cristiano G Carvalho
 * @see APPLICATION_PATH/views/helpers/DynamicResizeImage.php
 */
class Zend_View_Helper_DynamicResizeImage extends Zend_View_Helper_Abstract {

    /**
     * Nome do arquivo original
     * @var String
     */
    protected static $file = null;

    /**
     * Diretório do arquivo original
     * @var String
     */
    protected static $path = null;

    /**
     * Tipo de redimensionamento
     * @var String
     */
    protected static $type = null;

    /**
     * Nome do arquivo
     * @var String
     */
    protected static $newfilename = null;

    /**
     * Nome do arquivo
     * @var String
     */
    protected static $originalDimensions = array();

    /**
     * Opções de imagem
     * @var String
     */
    protected static $options = array();

    /**
     * Imagem
     * @var Object
     */
    protected static $thumb = null;

    /**
     * Método Principal
     * @param string $file Nome do arquivo original
     * @param string $path Diretório do arquivo original
     * @param string $width Largura novo arquivo
     * @param string $height Altura novo arquivo
     * @return string Nome do novo arquivo gerado
     */
    public function dynamicresizeimage($file, $path, $width, $height, $type=null, $options = array()) {
        $this->file = $file;
        $this->path = $path;
        $this->type = $type;
        $this->options = $options;
        $source = $this->path . $this->file;

        if (is_file($source)) { // Se o arquivo original existe 
            // Classe de redimensionamento de imagem 
            $this->thumb = PhpThumb_PhpThumbFactory::create($source, $this->options);
            $this->setOriginalDimensions($this->thumb->getCurrentDimensions());
            return $this->resize($width, $height);
        }

        return array();
    }

    private function setNewFileName($newfilename) {
        $this->newfilename = $newfilename;
    }

    private function setOriginalDimensions($dimensions) {
        $this->originalDimensions = $dimensions;
    }

    /**
     * Método Principal
     * @param string $width Largura novo arquivo
     * @param string $height Altura novo arquivo
     * @return string Nome do novo arquivo gerado
     */
    private function resize($width, $height) {

        $newfilename = $width . "x" . $height . "-" . $this->file;
        $newfile = $this->path . $newfilename;

        if (!is_file($newfile)) { // Verifica se arquivo ainda não existe
            try {
                switch ($this->type) {
                    case "ForceResize":
                        $this->thumb->resize($width, $height)->save($newfile);
                        break;
                    case "AdaptiveResize":
                        $this->thumb->adaptiveResize($width, $height)->save($newfile);
                        break;
                    case "CropFromCenter":
                        $this->thumb->cropFromCenter($width, $height)->save($newfile);
                        break;
                    case "ResizeAndCropFromCenter":
                        $this->thumb->adaptiveResize($width, $height)->cropFromCenter($width, $height)->save($newfile);
                        break;
                    default :
                        $this->thumb->resize($width, $height)->save($newfile);
                        break;
                }
            } catch (Exception $e) { 
                return null;
            }
        }

        $this->setNewFileName($newfilename);

        if (substr($this->path, 0, 2) == "./") {
            $filepath = substr($this->path, 1);
        } else {
            $filepath = $this->path;
        }

        return array(
            "path" => $this->path,
            "file" => $newfilename,
            "filepath" => $filepath . $newfilename,
            "originalDimensions" => $this->originalDimensions
        );
        
    }

}