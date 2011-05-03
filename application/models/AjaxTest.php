<?php
/*
 * Ajax test
 */
class AjaxTest 
{
    /*
     * Return text with param
     * @param str $name Param
     */
    public function formResponse($name) 
    {
        return '<div style="color: green;">Test ajax response: '.$name.'.</div>';
    }    
}
?>
