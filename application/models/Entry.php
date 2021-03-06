<?php
/*
 * Entry model
 */
class Entry extends Zend_Db_Table 
{
    protected $_name = 'entry';
    protected $_rowsetClass = 'EntryDetail';
    protected $_rowClass = 'EntryDetailRow';
    protected $_dependentTables = array('TagsLinks');
    protected $_referenceMap = array(
        'EntryDetail' => array(
            'columns' => array('author_id'),
            'refTableClass' => 'Authors',
            'refColumns' => array('id')
        )
    );

    /*
     * Fetch latest entries
     */
    public function fetchLatest($count = 10) 
    {
        $db = Zend_Registry::get('db');
        //$select = new Zend_Db_Select($db);
        //$select = $db->select();
        //$select->from('entry')
               //->where('id = ?', 2);
        //$result = $select->query();
        //Zend_Debug::dump($result);
        //Zend_Debug::dump($result->fetchAll());
        //echo '----------------------------------------';

        // insert an entry
        //$data = array('title' => 'From DB Insert',
                      //'announce' => 'This entry was created with DB Insert',
                      //'content' => 'Content of this entry',
                      //'date' => new Zend_Db_Expr('NOW()'),
                      //'author_id' => 1
                     //);
        //$db->insert('entry', $data);
        //echo 'LastInsertId: ' . $db->lastInsertId().'<br />';

        // update an entry 3
        //$datau = array('title' => 'From DB Update1');
        //$where = $db->quoteInto('title = ?', 'From DB Update');
        //$db->update('entry', $datau, $where);
        //$first = $this->fetchRow('id=2');
        //$first->title = 'The first new row';
        //$first->save();

        // user Zend_Db_Table_Abstract
        //$this->insert($data);
        //$this->delete($this->getAdapter()->quoteInto('id = ?', 1));

        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(array('main' => $this->_name), 
                   array('id', 'title', 'date', 'announce'))
            ->join(array('u' => 'Author'), 
                   'u.id = main.author_id',
                   array('login'))
            ->order('main.date DESC')
            ->limit($count);

        $entries = $this->fetchAll($select);
        $data = array();

        if (count($entries)) {
            $entries->loadTest();
            foreach ($entries as $i => $entry) {
                $data[$i]['testData'] = $entry->testData;
                $data[$i] = array_merge($entry->toArray(), $data[$i]);
            }
        }
        return $data;

        //$entries = $this->fetchAll(null, 'date DESC', $count);
        //return $entries->toArray();
    }
}
?>
