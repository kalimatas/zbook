<?php

class IndexController extends Zend_Controller_Action {
    public function init() {
        //$this->_helper->layout->setLayout('default2');
    }

    public function testAction() {
        $authors = new Authors();
        $me = $authors->find(1)->current();
        echo '<h2>'.$me->name().'</h2>';

        $meAgain = $authors->fetchRow('id = 3');
        $pubs = $meAgain->findDependentRowset('Entry')->toArray();
        //Zend_Debug::dump($pubs);

        // list of entries by tag "Test tag 1"
        $tags = new Tags();
        $firstTag = $tags->fetchRow('id = 2');
        $tagEntries = $firstTag->findManyToManyRowset('Entry', 'TagsLinks')->toArray();
        Zend_Debug::dump($tagEntries);
    }

    public function indexAction() {
        $entries = new Entry();
        $result = $entries->fetchLatest(6);
        if ($result) {
            $this->view->entries = $result;
        }

    }

    public function __get($key) {
        if (method_exists($this, $key)) {
            return $this->$key();
        } 
        return parent::__get($key);
    }
}

?>
