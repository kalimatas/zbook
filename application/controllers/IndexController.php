<?php

class IndexController extends Zend_Controller_Action {
    public function init() {
    }

    public function indexAction() {
        //require_once realpath('..') . '/application/models/Entry.php';
        $entries = new Entry();
        $result = $entries->fetchLatest();
        Zend_Debug::dump($result);
    }
}

?>
