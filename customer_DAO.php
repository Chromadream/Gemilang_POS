<?php
class customer_DAO
{
    public $customer_id;
    public $customer_name;
    public $customer_phone;
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function list_all_customer()
    {
        $query = "SELECT * FROM CUSTOMER";
        $result = $this->_connection->query($query);
        if($result->num_rows > 0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
        }
    }

    public function add_new_customer($name, $phone)
    {
        $query = "INSERT INTO CUSTOMER (customer_name, customer_phone) VALUES (?,?)";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ss',$name,$phone);
        $prepared_query->execute();
        return mysqli_insert_id($this->_connection);
    }

}
?>