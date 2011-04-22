<?php

class IndexController extends Zend_Controller_Action {
    public function init() {
    }

    public function indexAction() {
        $entries = new Entry();
        //Zend_Debug::dump($entries->fetchAll()->count());
        //echo '----------------------------------------';
        //$result = $entries->fetchLatest();
        //Zend_Debug::dump($result);
        echo '----------------------------------------';

        $authors = new Authors();
        $authors->insertAuthor();
    }
}

?>
