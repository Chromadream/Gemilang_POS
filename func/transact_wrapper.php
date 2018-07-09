<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/database_class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/transaction_DAO.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/transaction_line_DAO.php");
$connection = new Database();
$transaction_DAO = new transaction_DAO($connection->getConnection());
$item_DAO = new transaction_line_DAO($connection->getConnection());
$functionality = $_GET["func"];
$transactID = $_GET["tid"];
$secondaryID = $_GET["id"];
switch ($functionality) {
    case 'add_prod':
        $price = $_GET["price"];
        $result = $item_DAO->add_new_item_to_line($transactID,$secondaryID,1,$price);
        echo $result;
        break;
    case 'update_cust':
        $result = $transaction_DAO->change_customer_code($transactID,$secondaryID);
        echo $result;
        break;
    case 'change_qty':
        $quantity = $_GET["qty"];
        $result = $item_DAO->update_item_quantity($transactID,$secondaryID,$quantity);
        echo $result;
        break; 
    case 'remove_prod':
        $result = $item_DAO->remove_item_from_line($transactID,$secondaryID);
        echo $result;
        break;
    case 'change_price':
        $price = $_GET["price"];
        $result = $item_DAO->update_item_price($transactID,$secondaryID,$price);
        echo $result;
        break;
    default:
        echo $connection->checkConnection();
}?>