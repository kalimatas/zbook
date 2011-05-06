<?php
/*
 * Login Form
 */
class LoginForm extends Zend_Form
{
    
    public function __construct($action) 
    {
        parent::__construct();
    }

    public function init($action = '/auth/form/')
    {
        $this->setAction($action)
            ->setMethod('post')
            ->setAttrib('id', 'loginForm');

        $this->addElement('text', 'login', array('label' => 'Login'));
        $login = $this->getElement('login')
            ->addValidator('alnum')
            ->setRequired(true)
            ->addFilter('StringTrim')
            ->addPrefixPath('ZFExt_Validate','ZFExt/Validate/', 'validate')
            ->addValidator('Authorise');

        $login->getValidator('Authorise')->setMessage('No fu***ng user!');

        $this->addElement('password', 'password', array('label' => 'Password'));
        $password = $this->getElement('password')
            ->addValidator('stringLength', true, array(6))
            ->setRequired(true)
            ->addFilter('StringTrim');
        $password->getValidator('stringLength')->setMessage('Your passwor is too short.');

        $submit = $this->addElement('submit', 'Login');
    }
}
?>
