<?php
include_once("database_class.php");
include_once("transaction_DAO.php");
include_once("transaction_line_DAO.php");
$connection = new Database();
$transaction_DAO = new transaction_DAO($connection->getConnection());
$item_DAO = new transaction_line_DAO($connection->getConnection());
$functionality = $_GET["func"];
$transactID = $_GET["tid"];
$secondaryID = $_GET["id"];
$quantity = $_GET["qty"];
switch ($functionality) {
    case 'add_prod':
        $result = $item_DAO->add_new_item_to_line($transactID,$secondaryID,1);
    case 'update_cust':
        $result = $transaction_DAO->change_customer_code($transactID,$secondaryID);
        echo $result;
        break;
    case 'change_qty':
        $result = $item_DAO->update_item_quantity($transactID,$secondaryID,$quantity);
        echo $result;
        break; 
    case 'remove_prod':
        $result = $item_DAO->remove_item_from_line($transactID,$secondaryID);
        echo $result;
        break;
}?>