@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    সাধারণ জিজ্ঞাসা
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card py-3 mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 mx-auto faq-area">
                                <div class="faq-area-body">
                                    <div class="text-center">
                                        <h3 class="question-answer-heading text-dark p-3">সচারাচর জিজ্ঞাসা</h3>
                                    </div>
                                    @forelse($faqs as $key => $qa)
                                        <div class="panel-group question-answer-container" id="accordion">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="question-title">
                                                        <a class="question-heading" data-toggle="collapse"
                                                           href="#collapseExample{{$key}}" role="button"
                                                           aria-expanded="false"
                                                           aria-controls="collapseExample1">
                                                            {{ $qa['question'] }}
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseExample{{$key}}" class="question-answer collapse">
                                                    <div class="panel-body">
                                                        <p>{!! $qa['answer'] !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <div class="alert text-danger text-center">
                                                কোন সচারাচর জিজ্ঞাসা নেই
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .download-area {
            text-align: center;
        }

        .general-ask-download-area {
            border-left: 1px solid #e1e1e1;
        }

        .question-answer-heading {
            text-transform: uppercase;
            font-size: 1.1rem;
            margin: 0 0 25px;
            font-weight: bold;
            letter-spacing: 0.5pt;
            color: #4B77BE;
        }

        .question-answer-container {
            margin-bottom: 15px;
        }

        .question-answer-container:hover .question-heading {
            color: #fff;
            transition: .3s;
        }

        .question-heading {
            background: linear-gradient(45deg, #671688, #9c36c6);
            display: block;
            padding: 15px 15px;
            color: #eeeeee;
            font-size: 14px;
            transition: .3s;
            border-radius: 5px;
        }

        .question-title {
            margin-bottom: 0;
        }

        .question-answer {
            background: #f8f9fa;
            padding: 25px 20px;
        }

        .faq-area {
            border: 1px solid #f9f9f9;
            padding: 20px;
            box-shadow: 0 0 15px #eee;
            min-height: 100%;
        }

        .faq-area-body {
            padding: 15px 15px;
            border: 1px solid #e1e1e1 !important;
            border-radius: 8px !important;
        }
    </style>
@endpush
