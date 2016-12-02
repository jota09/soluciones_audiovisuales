<?php

require_once 'librerias/php/dompdf/dompdf_config.inc.php';

class crearPDF {

    public function __construct($html, $nombrePDF, $path = '', $att = true) {
        ob_clean();

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
//      __P($html);
        $dompdf->render();

        if (!empty($path)) {
            $file_location = getcwd() . '/' . $path . $nombrePDF . ".pdf";
            if (file_exists($file_location)) {
                unlink($file_location);
            }
            file_put_contents($file_location, $dompdf->output());
        } else {
            if ($att) {
                $dompdf->stream($nombrePDF . "eeeeee.pdf", array("Attachment" => 0));
            } else {
                $dompdf->stream($nombrePDF . ".pdf");
            }
        }
    }

}
