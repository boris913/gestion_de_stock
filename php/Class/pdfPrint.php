<?php
// Include autoloader 
require_once 'dompdf/autoload.inc.php';

// Reference the Dompdf namespace 
use Dompdf\Dompdf;

// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

ob_start();
// Load content from html file 
$html = require_once "pdf.php";
$html = ob_get_contents();
ob_end_clean();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF 
$dompdf->render();

// Output the generated PDF for download 
$dompdf->stream("Facture.pdf", array(
    "Attachment" => 1 // 1 for download, 0 for preview in browser
));
