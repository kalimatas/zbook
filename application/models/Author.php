<?php
/*
 * Author 
 */
class Author extends Zend_Db_Table_Row_Abstract {

    public function name() {
        $name = $this->fullname;
        if (empty($name)) {
            $name = $this->login;
        }
        return $name;
    }
}
?>
