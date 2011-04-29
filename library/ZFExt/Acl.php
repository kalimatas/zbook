<?php
/*
 * Acl class
 */
class ZFExt_Acl extends Zend_Acl {

    public function _addRoles($roles) {
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

    public function _configureNavigationAccess() {
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('error'));
        $this->add(new Zend_Acl_Resource('admin'));

        $this->allow('guest', array('index'));
        $this->allow('guest', array('error'));
        $this->allow('admin', array('admin'));
        $this->deny('guest', array('admin'));
    }
}
?>
