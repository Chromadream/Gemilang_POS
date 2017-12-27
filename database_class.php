<?php
include("connection_file.php");
class Database
{
    private $_user;
    private $_pass;
    private $_db;
    private $_host;
    private $_conn;
    private $_connerr;

    function __construct()
    {
        $this->setParams();
        $this->connect();
    }

    private function setParams()
    {
        global $USER, $PASS, $DB, $HOST;
        $this->_username = $USER;
        $this->_password = $PASS;
        $this->_db = $DB;
        $this->_host = $HOST;
    }

    private function connect()
    {
        error_reporting(E_ERROR);
        $this->_conn = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        if ($this->_conn->connect_errno)
        {
            $this->_connerr = $this->_conn->_connect_error;
        }
    }

    public function getConnection()
    {
        return $this->_conn;
    }

    public function getError()
    {
        return $this->_connerr;
    }

    public function checkConnection()
    {
        if($this->_connerr)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
?>