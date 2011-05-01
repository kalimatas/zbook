<?php
/*
 * Tags model
 */
class Tags extends Zend_Db_Table 
{
    protected $_name = 'Tags';    
    protected $_dependentTables = array('TagsLinks');
}
?>
