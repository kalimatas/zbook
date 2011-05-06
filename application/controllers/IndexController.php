<?php
/*
 * Index controller
 */
class IndexController extends Zend_Controller_Action 
{

    /*
     * Set permissions
     */
    public function init() 
    {
        $guestActions = array('index','ajax','info');
        //$this->_helper->acl->allow('guest', $guestActions);
        $this->_helper->acl->allow(null);

        $adminActions = array('index','test','ajax','info');
        //$this->_helper->acl->allow('admin', $adminActions);
        //$this->_helper->acl->allow(null);

        $this->view->baseUrl = $this->getRequest()->getBaseUrl();
        // set ajax action
        $ajaxContent = $this->_helper->getHelper('AjaxContext');
        $ajaxContent->addActionContext('ajax', 'html');
        $ajaxContent->initContext();
    }

    /*
     * Test ajax action
     */
    public function ajaxAction() 
    {
        $ajaxTest = new AjaxTest();
        $param = trim($this->getRequest()->getParam('name'));
        $this->view->result = $ajaxTest->formResponse($param ? $param : 'default');
    }

    public function testAction() 
    {
        $authors = new Authors();
        $me = $authors->find(1)->current();
        echo '<span>'.$me->name().'</span>';

        $meAgain = $authors->fetchRow('id = 3');
        $pubs = $meAgain->findDependentRowset('Entry')->toArray();
        //Zend_Debug::dump($pubs);

        // list of entries by tag "Test tag 1"
        $tags = new Tags();
        $firstTag = $tags->fetchRow('id = 2');
        $tagEntries = $firstTag->findManyToManyRowset('Entry', 'TagsLinks')->toArray();
        //Zend_Debug::dump($tagEntries);
    }

    /*
     * Display last entries in blog
     */
    public function indexAction() 
    {
        $entries = new Entry();
        // test memcached
        if (extension_loaded('memcache')) {
            $mem = new Memcache();
            $mem->addServer('localhost', 11211);
            $result = $mem->get('indexContent');
            if (!$result) {
                $result = $entries->fetchLatest(100);
                $mem->set('indexContent', $result, 0, 4);
            }
        } else {
            $result = $entries->fetchLatest(100);
        }

        if ($result) {
            $this->view->entries = $result;
            // Zend_Paginator
            $page = $this->_request->getParam('page', 1);
            $paginator = Zend_Paginator::factory($result);
            $paginator->setItemCountPerPage(4);
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
        }

    }

    /*
     * phpinfo
     */
    public function infoAction()
    {
        $this->_helper->layout->disableLayout();
    }

    public function __get($key) 
    {
        if (method_exists($this, $key)) {
            return $this->$key();
        } 
        return parent::__get($key);
    }
}

?>
