<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/database_class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/DAO/reporting_DAO.php");
$connection = new Database();
$reporting_DAO = new reporting_DAO($connection->getConnection());
$functionality = $_GET["func"];
$date = $_GET["d"];
$month = $_GET["m"];
$year = $_GET["y"];
switch ($functionality) {
    case 'yearly':
        $result = $reporting_DAO->yearly_sum($year);
        echo $result;
        break;
    case 'monthly':
        $result = $reporting_DAO->monthly_sum($month,$year);
        echo $result;
        break;
    case 'daily':
        $result = $reporting_DAO->daily_sum($date,$month,$year);
        echo $result;
        break;
    case 'batch_daily':
        $result = $reporting_DAO->batch_daily_sum($date,$month,$year);
        echo $result;
        break;
}?>