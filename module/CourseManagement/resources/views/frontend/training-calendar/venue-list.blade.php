@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';

@endphp
@extends($layout)
@section('title')
    কেন্দ্রের তালিকা সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header custom-bg-gradient-info">
                        <h2 class="text-center text-primary font-weight-lighter">
                            কেন্দ্রের তালিকা সমূহ
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>
                                            <form>
                                                {{--@csrf--}}
                                                <input class="form-control center-search" name="search"
                                                       id="venue_name"
                                                       value="{{ request()->query('search') }}"
                                                       placeholder="অনুসন্ধান">
                                            </form>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="venue-list">
                                                <ul class="center-list" id="center_list">
                                                    <?php
                                                    $sl = 0;
                                                    ?>
                                                    @foreach($publishedCourses as $publishedCourse)
                                                        <li style="list-style: none;">
                                                            <p>
                                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$sl) }}
                                                                ) {{ $publishedCourse->trainingCenter? $publishedCourse->trainingCenter->title_bn.',':''}}
                                                                {{ $publishedCourse->branch? $publishedCourse->branch->title_bn.',':''}}
                                                                {{ $publishedCourse->institute? $publishedCourse->institute->title_bn: ''}}
                                                            </p>
                                                            <p class="personmobile">
                                                                {{ $publishedCourse->institute? $publishedCourse->institute->primary_mobile: ''}} </p>
                                                            <address>
                                                                <i>ঠিকানা :
                                                                    @php
                                                                        if($publishedCourse->trainingCenter){
                                                                            $address =  $publishedCourse->trainingCenter->address;
                                                                        }elseif ($publishedCourse->branch){
                                                                            $address =   $publishedCourse->branch->address;
                                                                        }else{
                                                                            $address =   $publishedCourse->institute->address;
                                                                        }
                                                                    @endphp
                                                                    {{ $address }}
                                                                </i>
                                                            </address>
                                                            <hr>
                                                        </li>

                                                    @endforeach
                                                    @if(!count($publishedCourses))
                                                        <h5 class="text-danger text-center p-5">দুঃখিত কোনো ভ্যানু পাওয়া
                                                            যায়নি</h5>
                                                    @endif

                                                </ul>
                                                {{--{{$publishedCourses->links()}}--}}

                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

