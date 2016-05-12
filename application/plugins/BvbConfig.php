<?php 

/** 
 * Instância padrão Zend Data Grid
 * @author Cristiano Carvalho <cristiano@olyva.com.br>
 */
class Plugin_BvbConfig extends Zend_Controller_Plugin_Abstract {

    /**
     * Funcao executada antes da aplicacao ser disparada
     */
    public function preDispatch() {
        
    }

    /**
     * Processo simplificado de criação do Formulário Zend Data Grid BVb 
     * @return Bvb_Grid_Form
     */
    public function form($zend_form) {

        $form = new Bvb_Grid_Form($zend_form);

        $form->setAdd(true)
                ->setEdit(true)
                ->setDelete(true)
                ->setAddButton(true)
                ->setSaveAndAddButton(false);

        $form->setUseDecorators(false);
        $form->setUseCSRF(true);

        return $form;
    }

    /** 
     * Processo simplificado de criação do Grid Zend Data Grid BVb 
     * @return Bvb_Grid_Deploy_Table
     */ 
    public function grid($id = '') {

        $config = new Zend_Config_Ini(sprintf('%s/configs/grid.ini', APPLICATION_PATH), APPLICATION_ENV);
        $grid = Bvb_Grid::factory('Table', $config, $id);
        $grid->setView(new Zend_View(array("encoding" => "UTF-8")));
        //$grid->setEscapeOutput(false);
        //$form->setUseDecorators(false); 
        $grid->setDeleteConfirmationPage(false); // página para confirmação do cadastro
        $grid->setExport(array()); // Retirar os links de exportação do grid
        $grid->setAlwaysShowOrderArrows(false);
        $grid->setNoFilters(true);

        return $grid;

    }

}
