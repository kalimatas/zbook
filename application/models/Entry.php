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
        $entries = $this->fetchAll(null, 'date DESC', $count);
        //$entries = $this->find('id = 1');
        //$entries = $this->fetchRow('id = 1');
        return $entries->toArray();
    }
}
?>
