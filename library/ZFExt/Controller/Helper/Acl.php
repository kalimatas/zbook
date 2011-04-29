<?php
/*
 * Acl helper
 */
class ZFExt_Controller_Helper_Acl extends Zend_Controller_Action_Helper_Abstract {

    public function __construct() {
        return 'hello from ACL constructor!<br />';
    }

    public function direct($a) {
        return $a * 2;
    }

    public function acl() {
        return 'hello from ACL acl!<br />';
    }
}
?>
