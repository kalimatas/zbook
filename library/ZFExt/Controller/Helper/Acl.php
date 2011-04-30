<?php
/*
 * Acl helper
 */
class ZFExt_Controller_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {
    protected $_action;
    protected $_acl;
    protected $_auth;
    protected $_controllerName;

    public function __construct(Zend_View_Interface $view = null, array $options = array()) {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = new ZFExt_Acl();
        //if (isset($options['acl'])) {
            //$this->_acl = $options['acl'];
        //}
    }

    public function init() {
        $this->_action = $this->getActionController();
        // add resource
        $controller = $this->_action->getRequest()->getControllerName();
        if (!$this->_acl->has($controller)) {
            $this->_acl->add(new Zend_Acl_Resource($controller));
        }
    }

    public function preDispatch(){
        $role = ($this->_auth->hasIdentity() && !empty($this->_auth->getIdentity()->role)) ? $this->_auth->getIdentity()->role : 'guest';
        $request = $this->_action->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module = $request->getModuleName();
        $this->_controllerName = $controller;

        $resource = $controller;
        $privilege = $action;

        if (!$this->_acl->has($resource)) {
            $resource = null;
        }

        if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
            //$request->setModuleName('default');
            $request->setControllerName('auth');
            $request->setActionName('login');
            $request->setDispatched(false);
        }
    }

    public function allow($roles = null, $actions = null) {
        $resource = $this->_controllerName;
        $this->_acl->allow($roles, $resource, $actions);
        return $this;
    }

    public function deny($roles = null, $actions = null) {
        $resource = $this->_controllerName;
        $this->_acl->deny($roles, $resource, $actions);
        return $this;
    }

    public function direct($a) {
        return $a * 2;
    }
}
?>
