@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title font-weight-bold">{{__('Theme Setting')}}</h3>
                    </div>
                    <div class="row">
                        @foreach($themes as $theme)
                            <div class="theme-box m-4 @if($theme->id == $userThemeId)active @else @endif">
                                <div class="theme-inner-box mb-3">
                                    <img class="theme-image" src=""/>
                                    <h3 class="mt-2 mb-3 font-weight-bold">{{$theme->name}}</h3>
                                    <div class="theme-button-wrapper">
                                        <button class="btn btn-info btn-apply" id="btnApply-{{$theme->id}}"
                                                style="width: 230px;">APPLY
                                        </button>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(function () {
            $('.btn-apply').click(function (e) {
                const themeId = $(this).attr('id').split('-')[1];
                console.log('{{route('admin.themes.applyTheme')}}');

                $.post({
                    url: '{{route('admin.themes.applyTheme')}}',
                    data: {
                        themeId: themeId
                    }
                })
                    .done(function (responseData) {
                        //toastr.success(responseData.message);
                        location.reload();
                    })
                    .fail(window.ajaxFailedResponseHandler)
                    .always(function () {
                        $('.overlay').hide();
                    });
            });

        });
    </script>
@endpush
