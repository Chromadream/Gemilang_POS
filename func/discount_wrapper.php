<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/database_class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/transaction_DAO.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/discount_card_DAO.php");
$connection = new Database();
$transaction_DAO = new transaction_DAO($connection->getConnection());
$discount_DAO = new discount_card_DAO($connection->getConnection());
$mode = $_GET["mode"];
$transactID = $_GET["tid"];
$sentID = $_GET["id"];
switch ($mode) {
    case 'phone':
        krumo($sentID);
        $ID = $discount_DAO->search_from_phone($sentID);
        krumo($ID);
        if($ID==NULL)
        {
            echo "Tidak ada kartu yang teregistrasi dengan nomor ini.<br/>";
            echo "<a class='btn btn-link' href='invoice.php?mode=$transactID' role='button'>Kembali ke invoice</a>";
            break;
        }
        else
        {
            $transaction_DAO->change_discount_code($transactID,$ID);
            echo "Kartu diskon telah teregistrasi ke transaksi dengan sukses.<br/>";
            echo "<a class='btn btn-link' href='invoice.php?mode=$transactID' role='button'>Kembali ke invoice</a>";
            break;
        }
    case 'id':
        $ID = $discount_DAO->search_from_id($sentID);
        if($ID==NULL)
        {
            echo "Tidak ada kartu yang teregistrasi dengan ID ini.<br/>";
            echo "<a class='btn btn-link' href='invoice.php?mode=$transactID' role='button'>Kembali ke invoice</a>";
            break;
        }
        else
        {
            $transaction_DAO->change_discount_code($transactID,$ID);
            echo "Kartu diskon telah teregistrasi ke transaksi dengan sukses.<br/>";
            echo "<a class='btn btn-link' href='invoice.php?mode=$transactID' role='button'>Kembali ke invoice</a>";
            break;
        }
}