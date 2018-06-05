<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function ini_tcpdf(){
    include_once APPPATH.'helpers/tcpdf/tcpdf.php';
    // include_once APPPATH.'helpers/tcpdf/examples/config/tcpdf_config_alt.php';
    // $tcpdf_include_dirs = array(
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Semen Indonesia');
    $pdf->SetTitle('E-Procurement Semen Indoensia');
    $pdf->SetSubject('Export to PDF');
    $pdf->SetKeywords('E-Proc, Semen, Semen Indonesia, Indonesia');

    // set default header data
    // $pdf->SetHeaderData('tcpdf_logo.jpg', '17', 'PT Semen Indonesia (Persero) Tbk', PDF_HEADER_STRING);

    // // set header and footer fonts
    // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

    $pdf->setPrintHeader(false);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    return $pdf;
}

function pdf_content($pdf, $content, $paper, $orientation, $fontsize = 12) 
{
    $pdf->SetFont('dejavusans', '', $fontsize);

        // protrait
    if($orientation == "P"){
        $pdf->addPage( 'P', $paper );
    } else {
        // landscape
        $pdf->addPage( 'L', $paper );
    }
    ob_start();
    $html = $content;


    $pdf->writeHTML($html, true, false, true, false, '');

    return $pdf;
}

function pdf_render($pdf,$filename){   
    ob_clean(); 
    $pdf->Output($filename, 'I');
}
?>