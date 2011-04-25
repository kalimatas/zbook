<?php
/*
 * TagsLinks
 */
class TagsLinks extends Zend_Db_Table_Abstract {
    protected $_name = 'TagsLinks';    
    protected $_referenceMap = array(
        'Entry' => array(
            'columns' => array('entryID'),
            'refTableClass' => 'Entry',
            'refColumns' => array('id')
        ),
        'Tags' => array(
            'columns' => array('tagID'),
            'refTableClass' => 'Tags',
            'refColumns' => array('id')
        )
    );
}
?>
