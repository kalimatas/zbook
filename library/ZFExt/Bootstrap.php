<?php
/*
 * Bootstrap class
 */

class ZFExt_Bootstrap extends Zend_Application_Bootstrap_Bootstrap 
{
    
    /*
     * Set View
     */
    protected function _initView() {
        $options = $this->getOptions();
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

    /*
     * Set Db
     */
    protected function _initDb() 
    {
        $resource = $this->getPluginResource('db');
        $db = $resource->getDbAdapter();
        $db->getProfiler()->setEnabled(true);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);

        Zend_Registry::set('db', $db);
    }

    /*
     * Set Acl
     */
    protected function _initAcl() 
    {
        $options = $this->getOptions();
        $config = $options['acl']['roles'];

        if (isset($config)) {
            $auth = Zend_Auth::getInstance();
            $role = ($auth->hasIdentity() && !empty($auth->getIdentity()->role)) ? $auth->getIdentity()->role : 'guest';
            $acl = new ZFExt_Acl();
            $acl->_configureNavigationAccess();

            // привязываем Acl к Navigation
            Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
            Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($role);
        }

        return $acl;
    }

    /*
     * Set Navigation
     */
    protected function _initNavigation() 
    {
        $this->bootstrap('View');
        if ($this->hasResource('View')) {
            $view = $this->getResource('View');
        }

        $pages = array(
            array(
                'controller' => 'index',
                'label' => 'Home',
                'route' => 'default'
            ),
            array(
                'controller' => 'about',
                'label' => 'About',
                'resource' => 'about',
                'route' => 'default',
                'pages' => array(
                    array(
                        'controller' => 'about',
                        'action' => 'contact',
                        'label' => 'Contact',
                        'resource' => 'contact',
                        'route' => 'default'
                    )
                )
            ),
            array(
                'controller' => 'sitemap',
                'label' => 'Sitemap',
                'route' => 'default'
            ),
            array(
                'controller' => 'admin',
                'label' => 'Admin',
                'resource' => 'admin',
                'route' => 'default',
                'pages' => array(
                    array(
                        'controller' => 'index',
                        'action' => 'info',
                        'label' => 'Info',
                        'route' => 'default'
                    )
                )
            )
        );

        $container = new Zend_Navigation($pages);
        $view->menu = $container;

        return $container;
    }

    /*
     * Set FrontController
     */
    protected function _initModifiedFrontController() 
    {
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

    protected function _initRouter() {
        $this->bootstrap('FrontController');
        if ($this->hasResource('FrontController')) {
            $front = $this->getResource('FrontController');
        }
        $router = $front->getRouter();
        // login
        $router->addRoute('login', new Zend_Controller_Router_Route_Static(
            'login',
            array('controller' => 'auth', 'action' => 'form')
        ));
        // logout
        $router->addRoute('logout', new Zend_Controller_Router_Route_Static(
            'logout',
            array('controller' => 'auth', 'action' => 'logout')
        ));
        // entry
        $router->addRoute('entry', new Zend_Controller_Router_Route(
            'entry/:id',
            array(
                'controller' => 'entry',
                'action' => 'full',
                'id' => ''
            ),
            array(
                'id' => '\d+'
            )
        ));
        //$router->addConfig(new Zend_Config_Ini(APPLICATION_ROOT . '/config/routes.ini'), 'production', 'routes');
        
    }
}



?>
