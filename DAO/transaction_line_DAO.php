<?php
class transaction_line_DAO
{
    public $transact_id;
    public $product_id;
    public $product_name;
    public $product_sale_price;
    public $product_stock_unit;
    public $transact_item_quantity;
    public $transact_item_price;
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function list_all_items_from_order($id)
    {
        
        $query = "SELECT t.transact_item_quantity, t.transact_item_price, p.product_id,  p.product_name, p.product_sale_price, p.product_stock_unit 
                    FROM PRODUCT p, TRANSACTLINE t 
                    WHERE t.transact_id = ? AND t.product_id = p.product_id";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('i',$id);
        $prepared_query->execute();
        $result = $prepared_query->get_result();
        if($result->num_rows>0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
        }
    }

    public function add_new_item_to_line($transact_id,$product_id,$transact_item_quantity,$transact_item_price)
    {
        include_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");
        krumo::disable();
        $query = "INSERT INTO TRANSACTLINE (transact_id,product_id,transact_item_quantity,transact_item_price) VALUES (?,?,?,?)";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('iiii',$transact_id,$product_id,$transact_item_quantity,$transact_item_price);
        krumo($transact_id,$product_id,$transact_item_quantity,$transact_item_price);
        krumo($this->_connection,$query,$prepared_query);
        $prepared_query->execute();
        krumo($prepared_query->affected_rows);
        return $transact_id;
    }

    public function remove_item_from_line($transact_id,$product_id)
    {
        $query = "DELETE FROM TRANSACTLINE WHERE transact_id = ? AND product_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$transact_id, $product_id);
        $prepared_query->execute();
        return $transact_id;
    }

    public function update_item_quantity($transact_id,$product_id,$quantity)
    {
        $query = "UPDATE TRANSACTLINE SET transact_item_quantity = ? WHERE transact_id = ? AND product_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('iii',$quantity,$transact_id,$product_id);
        $prepared_query->execute();
        return $transact_id;
    }

    public function update_item_price($transact_id,$product_id,$transact_item_price)
    {
        include_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");
        krumo::disable();
        $query = "UPDATE TRANSACTLINE SET transact_item_price = ? WHERE transact_id = ? AND product_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('iii',$transact_item_price,$transact_id,$product_id);
        krumo($transact_id,$product_id,$transact_item_price);
        $prepared_query->execute();
        krumo($prepared_query->affected_rows);
        return $transact_id;
    }
}
?>