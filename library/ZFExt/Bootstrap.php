<?php
/*
 * Bootstrap class
 */

class ZFExt_Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    
    protected function _initView() {
        $options = $this->getOptions();
        //Zend_Debug::dump($options);

        if (isset($options['resources']['view'])) {
            $view = new Zend_View($options['resources']['view']);
        } else {
            $view = new Zend_View;
        }
        if (isset($options['resources']['view']['doctype'])) {
            $view->doctype($options['resources']['view']['doctype']);
        }
        if (isset($options['resources']['view']['contentType'])) {
            $view->headMeta()->appendHttpEquiv('Content-Type',
                $options['resources']['view']['contentType']);
        }

        $view->headTitle()->setSeparator(' / ')->append('zbook');

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        
        return $view;
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
