<?php
/*
 * Bootstrap class
 */
require_once 'Zend/Loader.php';

class Bootstrap{

    public static $root = '';
    public static $frontController = null;

    /*
     * Run app
     */
    public static function run() {
        self::setupEnvironment();
        self::prepare();
        $response = self::$frontController->dispatch();
        self::sendResponse($response);
    }

    public static function setupEnvironment() {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_startup_errors', true);
        ini_set('display_errors', true);
        date_default_timezone_set('Europe/Moscow');

        self::$root =  realpath('..');
        define('APP_ROOT', self::$root);
        spl_autoload_register(array(__CLASS__, 'autoload'));

        /*
         *set_include_path(ROOT_DIR . '/library' . 
         *    PATH_SEPARATOR . ROOT_DIR . '/application/models' . 
         *    PATH_SEPARATOR . get_include_path());
         */
    }

    public static function autoload($class) {
        include str_replace('_','/', $class).'.php';
        return $class;
    }

    public static function prepare() {
        self::setupFrontController();
        self::setupView();
    }

    public static function setupFrontController() {
        self::$frontController = Zend_Controller_Front::getInstance();
        self::$frontController->throwExceptions(true);
        self::$frontController->returnResponse(true);
        self::$frontController->setControllerDirectory(realpath(self::$root . '/application/controllers'));
        $response = new Zend_Controller_Response_Http;
        $response->setHeader('Content-type', 'text/html; charset=utf-8', true);
        self::$frontController->setResponse($response);
    }

    public static function setupView() {
        $view = new Zend_View;
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type','text/html; charset=utf-8');
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }

    public static function sendResponse(Zend_Controller_Response_Http $response) {
        $response->sendResponse();
    }

}
?>
