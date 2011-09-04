<?php
/*
 * 
 */
class EntryDetailRow extends ZFExt_Db_Row
{
    public $testData;

    public function testFunc()    
    {
        $this->testData = array('Test data');
    }

    public function ___setTestData($data) 
    {
        $this->testData = $data;
    }

    public function ___getTestData() 
    {
        return $this->testData;
    }

    public function testPrint()
    {
        echo get_class($this) . '<br />';
    }
}
