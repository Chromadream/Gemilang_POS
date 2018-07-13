<?php
session_start();
if(!isset($_SESSION["level"]) || ($_SESSION["level"] != "B" && $_SESSION["level"] != "T"))
{
    header("location: login.php?redirposition=orders.php");
}
if(!isset($_GET["id"])){
    header("location: login.php?redirposition=orders.php");
}
include_once("vendor/autoload.php");
include_once("func/generate_table.php");
define('K_PATH_IMAGES','img/');
$id = $_GET["id"];
$PDF_HEADER_LOGO = "logo.jpg";
$PDF_HEADER_LOGO_WIDTH = "70";
$sizes = array(215,220);
$tcpdf = new TCPDF('P','mm',$sizes,true,'UTF-8',false,false);
$tcpdf->SetHeaderData($PDF_HEADER_LOGO,$PDF_HEADER_LOGO_WIDTH,"Nota",'');
$tcpdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN,'',20));
$tcpdf->SetPrintFooter(false);
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED,'',12);
$tcpdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetAutoPageBreak(FALSE,PDF_MARGIN_BOTTOM);
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$tcpdf->AddPage();
$content = generate_table($id);
$tcpdf->writeHTML($content,true,true,true,true,'');
$savedir = $_SERVER["DOCUMENT_ROOT"]."/tmps/";
if($tcpdf->Output('testoutput.pdf','I')){
    return $content;
}
exit();
?>
