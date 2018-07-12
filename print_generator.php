<?php
include_once("vendor/autoload.php");
define('K_PATH_IMAGES','img/');
$PDF_HEADER_LOGO = "logo.jpg";
$PDF_HEADER_LOGO_WIDTH = "50";
$sizes = array(215,140);
$tcpdf = new TCPDF('L','mm',$sizes,true,'UTF-8',false,false);
$tcpdf->SetHeaderData($PDF_HEADER_LOGO,$PDF_HEADER_LOGO_WIDTH,"Invoice",'');
$tcpdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN,'',20));
$tcpdf->SetFooterFont(array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED,'',12);
$tcpdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$tcpdf->SetAutoPageBreak(FALSE,PDF_MARGIN_BOTTOM);
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$tcpdf->AddPage();
$tcpdf->writeHTML("<h1>test</h1>",true,true,true,true,'');
$savedir = $_SERVER["DOCUMENT_ROOT"]."/tmps/";
if($tcpdf->Output('testoutput','I')){
    return "<h1>test</h1>";
}
exit();
?>
