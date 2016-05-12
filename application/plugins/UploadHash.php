<?php
/**
 * UploadHash
 * 
 * Classe faz upload de arquivo e renomeio o arquivo com um hash
 * 
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author Cristiano Carvalho
 * @copyright Copyright (c) 2011
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0
 * @filesource
 */

class Plugin_UploadHash {

    public $field = null;
    public $path = null;
    public $uploaded = null;
    public $filename = null;
    public $filehash = null;
    public $filesize = null;

    public function __construct($field, $path) {
        $this->field = $field;
        $this->path = $path;
    }

    public function setField($field) {
        $this->field = $field;
    }

    public function getField() {
        return $this->field;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    /**
     * Upload Function
     *
     * Esta função faz upload do arquivo, renomeia e seta os atriutos
     * filename, filehash, filesize
     *
     * @return boolean
     */
    public function upload() {

        /* Verifica se ha arquivo para upload */
        $upload = new Zend_File_Transfer_Adapter_Http();      

        if ($upload->isValid($this->field)) {
            
           

            $this->filename = $upload->getFileName($this->field, false);
            $this->filehash = md5(time() . microtime(true)) . "." . $this->getExtension($this->filename);
            $this->filesize = $upload->getFileSize();

            $upload->setDestination($this->path)
                    ->setFilters(array("Rename" => $this->filehash));

            //return $upload->receive($this->field);

            try {

                $upload->receive();                                
                
                return true;

            } catch(Exception $e) {
                
                $writer = new Zend_Log_Writer_Stream('./logs/plugins_UploadHash.txt');
                $logger = new Zend_Log($writer);
                $logger->info($upload->filename);
                $logger->info($e->getMessage());
                
                return false;

            }

        } else {
            return false;
        }
        
    }

    /**
     * GetExtension Function
     *
     * Esta função retorna a extensão do arquivo
     *
     * @return string
     */
    private function getExtension($name) {

        $exts = @split("[/\\.]", $name);
        $n = count($exts) - 1;
        $exts = $exts[$n];

        return $exts;
    }
 
}