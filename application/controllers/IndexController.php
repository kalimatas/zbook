<?php

class IndexController extends Zend_Controller_Action {
    public function init() {
        //$front = Zend_Controller_Front::getInstance();
        //$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());
    }

    public function indexAction() {
        //$this->view->title = 'Hello Zend!';
        $this->view->headTitle()->append('main');
    }
}

?>
