<?php

/**
 * Plugin para checar autenticação
 * @author Cristiano Carvalho <cristiano@olyva.com.br>
 */
class Plugin_AuthCheck extends Zend_Controller_Plugin_Abstract {

    /**
     * Funcao que e executada antes da aplicacao ser disparada
     */
    public function preDispatch() {


        $request = $this->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();

        if (!($controller == 'error')) {
            $this->isAuth();
        }
    }

    /**
     * Verifica se o usuario esta logando
     */
    protected function isAuth() {

        $auth = Zend_Auth::getInstance();
        $credenciais = $auth->getStorage()->read();
        
       
        if ($auth->hasIdentity()) {       
            $this->CheckAccess($credenciais["acesso"]);
        } else {
            
            $this->CheckAccess("visitante");
            
        }
    }

    /**
     * Verifica se o usuario tem permissao de acessar a pagina
     * @param object $usuario
     */
    protected function CheckAccess($tipo_usuario) {        

        $request = $this->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module = $request->getModuleName();

        $acl = new Acl_Access;

        if (!$acl->isAllowed($tipo_usuario, $module . ":" . $controller, $action)) {
        
            $this->getRequest()
                    ->setModuleName($module)
                    ->setControllerName('index')
                    ->setActionName('index')
                    ->setParam("permissao", "no");            
        }
    }
}