<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Module\CourseManagement\App\Models\CourseWiseYouthCertificate;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class CertificateGenerator
{
    public function generateCertificate(string $template, array $youthInfo): string
    {
        $path = $youthInfo['path'] . "/" . $youthInfo['register_no'] . ".pdf";

        if (!file_exists("storage/" . $path)) {
            $certificate = PDF::loadView($template, compact('youthInfo'), [],
                [
                    'title' => 'Certificate',
                    'format' => 'A4-L',
                    'orientation' => 'L',
                    'font-size' => '50',
                ]
            );

            $pdf = $certificate->output();
            Storage::path(Storage::disk('public')->put($path, $pdf));

            $courseWiseCertificateData = [
                'publish_course_id' => $youthInfo['publish_course_id'],
                'youth_id' => $youthInfo['youth_id'],
                'certificate_path' => $path,

            ];
            //TODO:Save to Table
            CourseWiseYouthCertificate::create($courseWiseCertificateData);
        }
        return $path;
    }


}
