<?php
session_start();
if(!isset($_SESSION["level"]) || $_SESSION["level"] != "B")
{
    header("location: login.php?redirposition=orders.php");
}
if(!isset($_GET["id"]))
{
    header("orders.php");
}
include_once("database_class.php");
include_once("DAO/transaction_DAO.php");
include_once("DAO/transaction_line_DAO.php");
include_once("func/terbilang.php");
include_once("func/format_wrapper.php");
include_once("vendor/autoload.php");
$mpdf = new \Mpdf\Mpdf();
$connection = new Database();
$transact_DAO = new transaction_DAO($connection->getConnection());
$transactitem_DAO = new transaction_line_DAO($connection->getConnection());
$price_percentage = 1;
$subtotal_price = 0;
$transact_DAO->get_transaction_detail($_GET["id"]);
$discount_presence = $transact_DAO->check_discount($_GET["id"]);
if($discount_presence)
{
    $price_percentage = 0.98;
}
$items = $transactitem_DAO->list_all_items_from_order($_GET["id"]);
$css = file_get_contents("css/printmode.css");
$mpdf->WriteHTML('<h1>Test</h1>');
$mpdf->Output();

?>
