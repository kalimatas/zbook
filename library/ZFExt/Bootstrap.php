<?php
/*
 * Bootstrap class
 */

class ZFExt_Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    
    protected function _initView() {
        $options = $this->getOptions();
        //Zend_Debug::dump($options);
        $config = $options['resources']['view'];
        
        if (isset($config)) {
            $view = new Zend_View($config);
        } else {
            $view = new Zend_View;
        }

        if (isset($config['doctype'])) {
            $view->doctype($config['doctype']);
        }

        if (isset($config['contentType'])) {
            $view->headMeta()->appendHttpEquiv('Content-Type',
                $config['contentType']);
        }

        if (isset($config['language'])) {
            $view->headMeta()->appendName('language', $config['language']);
        }

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        
        return $view;
    }

    protected function _initDb() {
        $resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        Zend_Db_Table_Abstract::setDefaultAdapter($db);

        Zend_Registry::set('db', $db);
    }

    protected function _initModifiedFrontController() {
        $options = $this->getOptions();
        if (!isset($options['resources']['modifiedFrontController']['contentType'])) {
            return;
        }

        $this->bootstrap('FrontController');
        if ($this->hasResource('FrontController')) {
            $front = $this->getResource('FrontController');
        }
        $response = new Zend_Controller_Response_Http;
        $response->setHeader('Content-type',
            $options['resources']['modifiedFrontController']['contentType']);
        $front->setResponse($response);

        return $response;
    }
}



?>
