@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';


@endphp
@extends($layout)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <h1 class="text-center text-primary">কেন্দ্রের তালিকা সমূহ</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
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
                                                    $sl=0;
                                                    ?>
                                                    @foreach($publishedCourses as $publishedCourse)
                                                        <li style="list-style: none;">
                                                            <p>
                                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$sl) }}) {{ $publishedCourse->trainingCenter? $publishedCourse->trainingCenter->title_bn.',':''}}
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
@push('css')
    <style>


    </style>
@endpush
@push('js')

    <script type="text/javascript">


    </script>
@endpush
