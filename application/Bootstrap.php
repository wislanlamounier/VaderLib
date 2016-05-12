<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoload() {

        $loader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => APPLICATION_PATH
                ));

        $loader->addResourceType('acl', 'acls', 'Acl');
        
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Bvb_'); // Biblioteca Zend Data Grid
        $autoloader->registerNamespace('PhpThumb_'); // Biblioteca Php Thumb
        $autoloader->suppressNotFoundWarnings(false);
        $autoloader->setFallbackAutoloader(true);
        
        
    }

    protected function _initFilter() {
        Zend_Registry::set("post", new Zend_Filter_Input(NULL, NULL, $_POST));
        Zend_Registry::set("get", new Zend_Filter_Input(NULL, NULL, $_GET));
    }

    protected function _initController() {

        $front = Zend_Controller_Front::getInstance();

        $front->addModuleDirectory(APPLICATION_PATH . '/modules');
        $front->setDefaultModule('default');
        $front->setModuleControllerDirectoryName('controllers');

        $front->setControllerDirectory(
                array(
                    'default' => APPLICATION_PATH . '/modulesac/default/controllers',
                    'admin' => APPLICATION_PATH . '/modules/admin/controllers',
                    'service' => APPLICATION_PATH . '/modules/service/controllers'
                )
        );

        //ACL desabilitado. Para habilitar, descomente a linha abaixo.
        //$front->registerPlugin( new Plugin_AuthCheck );
    }

    protected function _initSession() {
      Zend_Session::start();
      Zend_Registry::set('session', new Zend_Session_Namespace);
    }

    protected function _initConfig() {
        $config = new Zend_Config_Ini(sprintf('%s/configs/application.ini', APPLICATION_PATH), APPLICATION_ENV);
        Zend_Registry::set('config', $config);
    }

    protected function _initLayout() {

        $layout = explode('/', $_SERVER['REQUEST_URI']);

        /* Layout default */
        $layout_dir = "/modules/default";

        /* Se for área administrativa utilize o layout específico da administração */
        if (in_array('admin', $layout)) {
            $layout_dir = "/modules/admin";
        }
        
        if (in_array('service', $layout)) {
            $layout_dir = "/modules/service";
        }

        $options = array(
            'layout' => 'layout',
            'layoutPath' => APPLICATION_PATH . $layout_dir . "/layouts/scripts/",
        );

        Zend_Layout::startMvc($options);
    }

    protected function _initLocale() {
        $locale = new Zend_Locale('pt_BR');
        Zend_Registry::set('Zend_Locale', $locale);
    }

    protected function _initDatabase() {
        $config = Zend_Registry::get('config');

        $db = Zend_Db::factory($config->db->adapter, $config->db->config->toArray());
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $db->setFetchMode(Zend_Db::FETCH_OBJ);

        /** Registra a variável db */
        Zend_Registry::set('db', $db);
    }

    protected function _initMail() {
        $config = Zend_Registry::get('config');

        $MailTransport = new Zend_Mail_Transport_Smtp($config->mail->host, array(
                    'ssl' => 'tls',
                    'port' => 587,
                    'auth' => 'login',
                    'username' => $config->mail->username,
                    'password' => $config->mail->password
                ));


        /*
          $MailTransport = new Zend_Mail_Transport_Smtp( $config->mail->host, array(
          'auth'      => 'login',
          'username'  => $config->mail->username,
          'password'  => $config->mail->password
          ));
         * 
         */


        Zend_Mail::setDefaultTransport($MailTransport);
    }

}

