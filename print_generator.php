<?php
include_once("vendor/autoload.php");
include_once("func/generate_table.php");
define('K_PATH_IMAGES','img/');
$id = $_GET["id"];
$PDF_HEADER_LOGO = "logo.jpg";
$PDF_HEADER_LOGO_WIDTH = "20";
$sizes = array(215,140);
$tcpdf = new TCPDF('L','mm',$sizes,true,'UTF-8',false,false);
$tcpdf->SetHeaderData($PDF_HEADER_LOGO,$PDF_HEADER_LOGO_WIDTH,"Invoice",'');
$tcpdf->SetHeaderFont(array(PDF_FONT_NAME_MAIN,'',20));
$tcpdf->SetPrintFooter(false);
$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED,'',12);
$tcpdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$tcpdf->SetAutoPageBreak(FALSE,PDF_MARGIN_BOTTOM);
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$tcpdf->AddPage();
$content = generate_table($id);
krumo($content);
$tcpdf->writeHTML($content,true,true,true,true,'');
$savedir = $_SERVER["DOCUMENT_ROOT"]."/tmps/";
if($tcpdf->Output('testoutput.pdf','I')){
    echo 200;
}
exit();
?>
