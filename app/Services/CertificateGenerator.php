<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class CertificateGenerator
{
    public function generateCertificate(string $template,array $youthInfo): string
    {
        $path=$youthInfo['path']."/".$youthInfo['register_no'].".pdf";
        if(!file_exists("storage/".$path)){
            $certificate= PDF::loadView($template, compact('youthInfo'), [],
                [
                    'title' => 'Certificate',
                    'format' => 'A4-L',
                    'orientation' => 'L',
                    'font-size' => '50',

                ]
            );

            $pdf=$certificate->output();
            Storage::path(Storage::disk('public')->put($path,$pdf));
        }
        //TODO:Save to Table

        return $path;
    }


}
