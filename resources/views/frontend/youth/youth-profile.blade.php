@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    ইয়ুথ প্রোফাইল
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row youth-profile" id="youth-profile">

            <div class="col-md-12 mt-2 personal-info-section">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Personal
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-md-12 education-info-section">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Education
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-md-12 guardian-info-section">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Guardian
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-md-12 occupation-info-section">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Occupation
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('jsfiles/html2canvas.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.40/pdfmake.min.js"></script>
    <script type="text/javascript">
        function getClippedRegion(image, x, y, width, height) {
            let canvas = document.createElement("canvas"), ctx = canvas.getContext("2d");
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(image, x, y, width, height, 0, 0, width, height);

            return {
                image: canvas.toDataURL(),
                width: 500
            };
        }

        function Export() {
            $('#downloadPDF').hide();
            $('meta').attr('name', 'viewport').attr('initial-scal', '1.0');
            html2canvas($("#youth-profile")[0], {
                onrendered: function (canvas) {
                    let splitAt = 775;
                    let images = [];
                    let y = 0;
                    while (canvas.height > y) {
                        images.push(getClippedRegion(canvas, 0, y, canvas.width, splitAt));
                        y += splitAt;
                    }

                    let docDefinition = {
                        content: images,
                        pageSize: {width: 580, height: 850},
                    };
                    pdfMake.createPdf(docDefinition).download("youth-profile.pdf");

                    setTimeout(function () {
                        window.location.reload(true);
                    }, 5000);
                }
            });
        }
    </script>

@endpush


