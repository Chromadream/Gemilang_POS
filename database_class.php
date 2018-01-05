<?php
require("connection_file.php");
class Database
{
    private $_user;
    private $_pass;
    private $_db;
    private $_host;
    public $conn;
    private $_connerr;

    function __construct()
    {
        $this->setParams();
        $this->connect();
    }

    public function setParams()
    {
        $this->_username = $GLOBALS["user"];
        $this->_password = $GLOBALS["pass"];
        $this->_db = $GLOBALS["db"];
        $this->_host = $GLOBALS["host"];
    }

    public function connect()
    {
        error_reporting(E_ERROR);
        $this->conn = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);
        error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
        if ($this->conn->connect_errno)
        {
            $this->_connerr = $this->conn->_connect_error;
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