<?php
/*
 * LoggedInUser
 */

class ZFExt_View_Helper_LoggedInUser extends Zend_View_Helper_Abstract 
{

    public function loggedInUser() 
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $logoutUrl = $this->view->url(array('controller' => 'auth', 'action' => 'logout'));
            $user = $auth->getIdentity();
            $username = $this->view->escape($user->login);
            $return = "Hello, ". $username ." | <a style='padding: 0;' href=".$logoutUrl.">Log out</a>";
        } else {
            $loginUrl = $this->view->url(array('controller' => 'auth', 'action' => 'index'));
            $return = "<a style='padding: 0;' href='".$loginUrl."'>Log in</a>";
        }

        return $return;
    }
}

?>
