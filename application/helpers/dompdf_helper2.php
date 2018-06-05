<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $paper, $orientation, $stream=TRUE) 
{
    // require_once("dompdf/dompdf_config.inc.php");
    include_once APPPATH.'helpers/dompdf/dompdf_config.inc.php';

    $dompdf = new DOMPDF();
    $dompdf->set_paper($paper,$orientation);
    $dompdf->load_html($html);
    $dompdf->render();
    $canvas = $dompdf->get_canvas();
    // $old_limit = ini_set("memory_limit", "240M");

    $font = Font_Metrics::get_font("helvetica", "italic");
    $canvas->page_text(450, 800, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $font, 9, array(0,0,0));
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        $dompdf->stream($filename.".pdf",array('Attachment'=>0));
    }
}
?>