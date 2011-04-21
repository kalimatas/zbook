<?php
/*
 * Entry model
 */
class Entry extends Zend_Db_Table {
    protected $_name = 'entry';

    /*
     * Fetch latest entries
     */
    public function fetchLatest($count = 10) {
        //$db = Zend_Registry::get('db');
        //$db->setFetchMode(Zend_Db::FETCH_ASSOC);
        return $this->fetchAll(null, 'date DESC', $count);
    }
}
?>
