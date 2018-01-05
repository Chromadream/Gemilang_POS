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

    public function setParams()
    {
        //global $USER, $PASS, $DB, $HOST;
        $this->_username = "GEMILANG";
        $this->_password = "gemilang_adm";
        $this->_db = "GEMILANG";
        $this->_host = "localhost";
    }

    public function connect()
    {
        //error_reporting(E_ERROR);
        $this->_conn = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);
        //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        if ($this->_conn->connect_errno)
        {
            $this->_connerr = $this->_conn->_connect_error;
        }
        else
        {
            echo "Connection successful";
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