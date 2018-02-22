<?php
include_once($_SERVER["DOCUMENT_ROOT"]."vendor/autoload.php");
class Product_DAO
{
    public $product_id;
    public $product_name;
    public $product_purchase_price;
    public $product_sale_price;
    public $product_stock_quantity;
    public $product_stock_unit;
    public $product_description;
    private $_connection;

    function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function find_product_by_name($name)
    {
        $query = "SELECT * FROM PRODUCT WHERE product_name LIKE ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $name = "%".$name."%";
        $prepared_query->bind_param('s',$name);
        $prepared_query->execute();
        $result = $prepared_query->get_result();

        if($result->num_rows>0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
        }
    }

    public function add_new_product($name, $purchase, $sale, $quantity, $unit, $description)
    {
        //krumo($name,$purchase,$sale,$quantity,$unit);
        $query = "INSERT INTO PRODUCT (product_name, product_purchase_price, product_sale_price, product_stock_quantity, product_stock_unit, product_description) VALUES (?,?,?,?,?,?)";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('siiis',$name,$purchase,$sale,$quantity,$unit,$description);
        $prepared_query->execute();
        return mysqli_insert_id($this->_connection);
    }

    public function update_product_stock($id, $quantity)
    {
        $query = "UPDATE PRODUCT SET product_stock_quantity = ? WHERE product_id = ?";
        $prepared_query = mysqli_prepare($this->_connection,$query);
        $prepared_query->bind_param('ii',$quantity,$id);
        $prepared_query->execute();
        return $id;
    }

    public function update_product_prices($id, $purchase, $sale)
    {
        $query = "UPDATE PRODUCT SET product_purchase_price = ?, product_sale_price=? WHERE product_id = ?";
        $prepared_query = mysqli_prepare($this->_connection, $query);
        $prepared_query->bind_param('iii',$purchase,$sale,$id);
        $prepared_query->execute();
        return $id;
    }

    public function list_all_product()
    {
        $query = "SELECT * FROM PRODUCT";
        $result = $this->_connection->query($query);
        if($result->num_rows > 0)
        {
            $allrows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            include_once('result_set.php');
            return new result_set($allrows);
        }
    }
}
?>