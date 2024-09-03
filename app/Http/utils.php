<?php

use Fpdf\Fpdf;
use Carbon\Carbon;

function generatePDFHistorial($arrRecibos,$codpay,$val,$cond){
    $pdf = new Fpdf();

    $pdf::AddPage();
    //constants
    $codepay = utf8_decode("Código de pago");
    $page = utf8_decode("Página");
    $contrib = utf8_decode("Código del contribuyente: ");
    $dir = utf8_decode("Dirección Fiscal");
    
    if($cond=="desc") {
        $pdf::Output('recibo.pdf', 'D');
    }else{
        $pdf::Output('recibo.pdf', 'I');
    }
}
