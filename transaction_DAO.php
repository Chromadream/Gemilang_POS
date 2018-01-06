<?php
include("vendor/autoload.php");
class transaction_DAO
{
    public $transact_id;
    public $transact_date;
    public $customer_id;
    public $customer_name;
    public $discount_id;
    private $_connection;
    
    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    function list_all_transactions_from_customer($customer_id)
    {
        $query = "SELECT t.transact_id, t.transact_date, t.customer_id, c.customer_name, t.discount_id FROM TRANSACT t, CUSTOMER c WHERE customer_id = ? AND c.customer_id = t.customer_id";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i', $customer_id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            krumo($result);
            include_once('result_set.php');
            return new result_set($result);
        }
    }

    function init_transaction()
    {
        $query = "INSERT INTO TRANSACT (transact_date) VALUES (CURRENT_TIMESTAMP)";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->execute();
        return mysqli_insert_id($this->_connection);
    }

    function change_customer_code($transact_id,$customer_id)
    {
        $query = "UPDATE TRANSACT SET customer_id = ? WHERE transact_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$customer_id,$transact_id);
        $prepared_query->execute();
        return $transact_id;
    }

    function change_discount_code($transact_id,$discount_id)
    {
        $query = "UPDATE TRANSACT SET discount_id = ? WHERE transact_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$discount_id,$transact_id);
        $prepared_query->execute();
        return $transact_id;
    }

    function check_discount($transact_id)
    {
        $query = "SELECT discount_id from TRANSACT WHERE transact_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i',$transact_id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            return TRUE;
        }
        return FALSE;
    }

    function list_all_transactions()
    {
        $query = "SELECT t.transact_id, t.transact_date, t.customer_id, c.customer_name, t.discount_id FROM TRANSACT t, CUSTOMER c WHERE c.customer_id = t.customer_id";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            krumo($result);
            include_once('result_set.php');
            return new result_set($result);
        }
    }
    
    function get_transaction_detail($transact_id)
    {
        $query = "SELECT t.transact_id, t.transact_date, t.customer_id, c.customer_name, t.discount_id FROM TRANSACT t, CUSTOMER c WHERE transact_id = ? AND c.customer_id = t.customer_id";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i', $transact_id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            krumo($result);
            include_once('result_set.php');
            return new result_set($result);
        }
    }
}
?>