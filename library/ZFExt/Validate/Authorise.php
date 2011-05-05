<?php
/*
 * Custom validate
 */
class ZFExt_Validate_Authorise extends Zend_Validate_Abstract
{
    const NOT_AUTHORIZED = 'notAuthorized';
    protected $_authAdapter;
    protected $_messageTemplates = array(
        self::NOT_AUTHORIZED => 'User not exists.'
    );
    
    public function getAuthAdapter()
    {
        return $this->_authAdapter;
    }

    public function isValid($value, $context = null) 
    {
        $value = (string)$value;
        $this->_setValue($value);

        if (is_array($context)) {
            if (!isset($context['password'])) {
                return false;
            }
        }

        $db = Zend_Registry::get('db');
        $this->_authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $this->_authAdapter->setTableName('Author')
            ->setIdentityColumn('login')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('MD5(?)');

        $this->_authAdapter->setIdentity($value);
        $this->_authAdapter->setCredential($context['password']);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($this->_authAdapter);

        if (!$result->isValid()) {
            $this->_error(self::NOT_AUTHORIZED);
            return false;
        }

        return true;
    }
}
?>
