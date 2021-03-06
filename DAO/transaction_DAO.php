<?php
class transaction_DAO
{
    public $transact_id;
    public $transact_date;
    public $customer_id;
    public $customer_name;
    public $discount_id;
    public $transact_total;
    private $_connection;
    
    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    function list_all_transactions_from_customer($customer_id)
    {
        $query = "SELECT t.transact_id, date_format(t.transact_date, '%d/%m/%Y %T') transact_date, t.customer_id, c.customer_name, t.discount_id, t.transact_total FROM TRANSACT t, CUSTOMER c WHERE c.customer_id = ? AND c.customer_id = t.customer_id ORDER BY t.transact_id DESC";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i', $customer_id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
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

    function check_discount()
    {
        if($this->discount_id==NULL)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function list_all_transactions()
    {
        $query = "SELECT t.transact_id, date_format(t.transact_date, '%d/%m/%Y %T') transact_date, t.customer_id, c.customer_name, t.discount_id, t.transact_total FROM TRANSACT t, CUSTOMER c WHERE c.customer_id = t.customer_id ORDER BY t.transact_id DESC";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
        }
    }
    
    function get_transaction_detail($transact_id)
    {
        $query = "SELECT t.transact_id, date_format(t.transact_date, '%d/%m/%Y %T') transact_date, t.customer_id, c.customer_name, t.discount_id FROM TRANSACT t, CUSTOMER c WHERE transact_id = ? AND c.customer_id = t.customer_id";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i', $transact_id);
        $prepared_query->execute();
        $prepared_query->bind_result($this->transact_id,$this->transact_date,$this->customer_id,$this->customer_name,$this->discount_id);
        $prepared_query->fetch();
        //krumo($this->transact_id,$this->transact_date,$this->customer_id,$this->customer_name,$this->discount_id);
    }

    function update_transaction_total($transact_id,$transact_total)
    {
        $query = "UPDATE TRANSACT SET transact_total = ? WHERE transact_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$transact_total,$transact_id);
        $prepared_query->execute();
        return true;
    }
}
?>