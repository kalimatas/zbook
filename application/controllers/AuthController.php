<?php
/*
 * AuthController
 */
class AuthController extends Zend_Controller_Action 
{
    /*
     * Forward to login action
     */
    public function indexAction() 
    {
        if (null == Zend_Auth::getInstance()->getIdentity()) {
            $this->_forward('form');
        }
    }

    public function formAction() 
    {
        $form = new LoginForm('/auth/form/');
        $this->view->formResponse = 'Some response';
        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $authAdapter = $form->login->getValidator('Authorise')
                                           ->getAuthAdapter();

                $data = $authAdapter->getResultRowObject(null, 'password');
                $auth = Zend_Auth::getInstance();
                $auth->getStorage()->write($data);
                $this->_redirect($this->_redirectUrl);
            } else {
                $this->view->formResponse = 'Some problem: ';
            }
        } 
        $this->view->form = $form;
    }

    /*
     * Login form
     */
    public function loginAction() 
    {
        // Get flashed message
        $flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->setNamespace('actionErrors');
        $this->view->actionErrors = $flashMessenger->getMessages();
    }

    /*
     * Clear identity
     */
    public function logoutAction() 
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/');
    }

    public function identifyAction() 
    {
        // checks for POST
        if ($this->_request->isPost()) {
            $formData = $this->_request->getParams();
            if (empty($formData['login']) || empty($formData['password'])) {
                $this->_flashMessage('Empty login or password.');
            } else {
                $authAdapter = $this->_getAuthAdapter($formData);
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($authAdapter);

                if (!$result->isValid()) {
                    $this->_flashMessage('Login failed.');
                } else {
                    $data = $authAdapter->getResultRowObject(null, 'password');
                    $auth->getStorage()->write($data);

                    $this->_redirect($this->_redirectUrl);
                    return;
                }
            }
        }
        $this->_redirect('/auth/login');
    }

    /*
     * Get AuthAdapter
     * @param array $formData Data
     */
    public function _getAuthAdapter($formData) 
    {
        $db = Zend_Registry::get('db');

        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName('Author')
            ->setIdentityColumn('login')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('MD5(?)');

        $authAdapter->setIdentity($formData['login']);
        $authAdapter->setCredential($formData['password']);

        return $authAdapter;
    }

    /*
     * Flash message
     * @param str $message Message
     */
    public function _flashMessage($message) 
    {
        $flashMessenger = $this->_helper->FlashMessenger;
        $flashMessenger->setNamespace('actionErrors');
        $flashMessenger->addMessage($message);
    }
}

?>
