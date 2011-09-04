<?php
class ZFExt_Db_Row extends Zend_Db_Table_Row_Abstract
{
    public function __get($name)
    {
        $method = '___get'.$this->formatMethodName($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return $this->get($name);
        }
    }

    public function __set($name, $value)
    {
        $method = '___set'.$this->formatMethodName($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->set($name, $value);
        }
    }

    protected function formatMethodName($name)
    {
        $nameList = explode('_', $name);
        $nameList = array_map('ucfirst', $nameList);
        return implode('', $nameList);
    }

    public function get($name)
    {
        return parent::__get($name);
    }

    public function set($name, $value)
    {
        var_dump($name);
        parent::__set($name, $value);
    }
}
