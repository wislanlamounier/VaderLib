<?php
/**
 * Controle de accesso para usuarios
 * @author Tiago Alexandre
 */
class Acl_Access extends Zend_Acl
{

  public static $modules = array("service");
  
  /**
   * Construtor da lista
   */
  public function __construct()
  {
    $this->AddResources();
    $this->createRoles();
  }

  /**
   * Adiciona as regras
   */
  protected function createRoles()
  {

    // heranca
    $this->addRole(new Zend_Acl_Role('visitante'));
    $this->addRole(new Zend_Acl_Role('usuario'), 'visitante');
    $this->addRole(new Zend_Acl_Role('administrador'), 'visitante');
    

    // Visitante
    $this->allow('visitante', 'default:index', array('index', 'logout', 'prototipos', 'autenticaprototipo'));

    $this->allow('visitante', 'admin:index', array('index'));
  }

  /**
   * Cria os recursos
   */
  protected function AddResources()
  {


    // M√≥dulo Administra√ß√£o
    $this->add(new Zend_Acl_Resource('default'))
            ->add(new Zend_Acl_Resource('default:error'), 'default');
  }

}