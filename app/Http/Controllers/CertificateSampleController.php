<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
class CertificateSampleController extends Controller
{
    public function generatePDF(){

        $data = [
            'name'   => "Bosir Uddin Ahmad",
            'father' => "Mohammad Baser Uddin",
            'mother' => "Halima Akter",
            'grade'  => "3.5",
            'institute' => 'BUET',

        ];
        $customPaper = array(0,0,919,1300);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('backend.certificate-sample',$data)
            ->setPaper($customPaper, 'landscape');

        return $pdf->download('certificate.pdf');
    }
}
