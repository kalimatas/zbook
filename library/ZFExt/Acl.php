<?php
/*
 * Acl class
 */
class ZFExt_Acl extends Zend_Acl 
{

    public function __construct() 
    {
        $config = new Zend_Config_Ini(APPLICATION_ROOT . '/config/application.ini', APPLICATION_ENV);
        $this->_addRoles($config->acl->roles);
    }

    public function _addRoles($roles) 
    {
        if (count($roles)) {
            foreach ($roles as $name => $parents) {
                if (!$this->hasRole($name)) {
                    if (empty($parents)) {
                        $parents = null;
                    } else {
                        $parents = explode(',', $parents);
                    }
                    $this->addRole(new Zend_Acl_Role($name), $parents);
                } 
            }
        } 
    }

    public function _configureNavigationAccess() 
    {
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('about'));
        $this->add(new Zend_Acl_Resource('contact'),'about');
        $this->add(new Zend_Acl_Resource('admin'));

        $this->allow('guest', array('index'));
        $this->allow('guest', array('error'));
        $this->allow('guest', 'about');
        $this->allow('admin', array('admin'));
        $this->allow('admin', array('about'));
        $this->deny('guest', array('admin'));
        //$this->deny('guest', 'about','contact');
    }

}
?>
