<?php

class IndexController extends Zend_Controller_Action {
    public function init() {
    }

    public function indexAction() {
        $entries = new Entry();
        $result = $entries->fetchLatest();
        Zend_Debug::dump($result);
    }
}

?>
