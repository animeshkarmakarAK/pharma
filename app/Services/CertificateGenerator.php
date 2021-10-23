<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Module\CourseManagement\App\Models\CourseWiseYouthCertificate;


class CertificateGenerator
{
    public function generateCertificate(string $template, array $youthInfo): string
    {

        $path = $youthInfo['path'] . "/" . $youthInfo['register_no'] . ".pdf";

        if (!file_exists("storage/" . $path)) {
            $pdf = App::make('dompdf.wrapper');
            $certificate = $pdf->loadView($template, compact('youthInfo'));
            $pdf = $certificate->setPaper('A4-L', 'landscape')->setWarnings(false)->download();
            Storage::path(Storage::disk('public')->put($path, $pdf));
            $courseWiseCertificateData = [
                'publish_course_id' => $youthInfo['publish_course_id'],
                'youth_id' => $youthInfo['youth_id'],
                'certificate_path' => $path,

            ];
            CourseWiseYouthCertificate::create($courseWiseCertificateData);
        }
        return $path;
    }


}
