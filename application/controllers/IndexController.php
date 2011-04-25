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

    public function __get($key) {
        if (method_exists($this, $key)) {
            return $this->$key();
        } 
        return parent::__get($key);
    }
}

?>
