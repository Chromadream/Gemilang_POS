<?php
include("vendor/autoload.php");
class result_set{
    private $_results;

    function __construct($results)
    {
        $this->_results = $results;
    }

    public function getNext($dataobject, $counter)
    {
        $row = $this->_results[$counter];
        foreach($row as $key=>$value)
        {
            $dataobject->$key = $value;
        }
        return $dataobject;
    }

    public function rowCount()
    {
        $count = sizeof($this->_results);
        return $count;
    }    
}
?>