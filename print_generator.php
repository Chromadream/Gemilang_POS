<?php
include_once("vendor/autoload.php");
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Test</h1>');
$mpdf->Output('test.pdf',\Mpdf\Output\Destination::INLINE);

?>
