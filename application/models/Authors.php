<?php
/*
 * Authors model
 */
class Authors extends Zend_Db_Table 
{
    protected $_name = 'Author';
    protected $_rowClass = 'Author';
    protected $_dependentTables = array('Entry');

    public function insertAuthor() 
    {
        $data = array('login' => 'kohutapu',
                      'fullname' => 'Another user',
                      'email' => 'a.guz13@yahoo.com',
                      'password' => md5('password')
                     );
        //$this->insert($data);
    }

}
?>
