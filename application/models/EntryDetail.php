<?php
/*
 * Entry Detail 
 */
class EntryDetail extends Zend_Db_Table_Rowset_Abstract 
{

    public function justPrint()
    {
        echo '<pre>';
        var_dump($this);
        echo '</pre>';
        //foreach ($this as $row) {
            //var_dump($row);
        //}
    }

    public function loadTest()
    {
        foreach ($this as $row) {
            $row->testData = array('hello testData');
            //$row->testFunc();
        }
    }

}
?>
