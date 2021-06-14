@php
    $edit = !empty($institute->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Institute' : 'Update Institute' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \App\Models\Institute::class)
                                <a href="{{route('course_management::admin.institutes.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('course_management::admin.institutes.update', [$institute->id]) : route('course_management::admin.institutes.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Institute Name') . '(English)' }}<span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $institute->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Institute Name') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $institute->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Institute Code') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $institute->code : '' }}"
                                           value="{{ $edit ? $institute->code : old('code') }}"
                                           placeholder="{{ __('code') }}">

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Institute Domain') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="domain"
                                           name="domain"
                                           value="{{ $edit ? $institute->domain : old('domain') }}"
                                           placeholder="{{ __('domain') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="primary_phone">{{ __('Primary Phone') }}</label>
                                    <input type="text" class="form-control" id="primary_phone"
                                           name="primary_phone"
                                           value="{{ $edit ? $institute->primary_phone : old('primary_phone') }}"
                                           placeholder="{{ __('Primary Phone') }}">
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div id='AddMultiPhone' class="mb-2">
                                            @if(!empty($institute->phone_numbers))
                                                <?php $sl = 0; $sl_div = 0; $phone_id = 0; ?>
                                                @foreach($institute->phone_numbers as $phone)
                                                    <div id="AddPhoneDiv{{ ++$sl_div }}">
                                                        <label class="label-text"
                                                               style="margin-bottom: 9px;">{{ __('Phone #') }}{{ ++$sl }}</label>
                                                        <input type='text' id='phone{{++$phone_id}}'
                                                               class="form-control phone_numbers" name="phone_numbers[]"
                                                               value="{{ $phone }}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div id="AddPhoneDiv1">
                                                    <label>Phone #1 : </label>
                                                    <input type='text' id='phone1' class="form-control phone_numbers"
                                                           name="phone_numbers[]">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="float-right  btn-group">
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='addPhone'>
                                                <i class="fa fa-plus-circle"></i> Add More Phone
                                            </a>

                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='removePhone'>
                                                <i class="fa fa-minus-circle"></i> Remove One
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div id='AddMultiPhone' class="mb-2">
                                            <div id="AddPhoneDiv1">
                                                <label>Phone #1 : </label>
                                                <input type='text' id='phone1' class="form-control"
                                                       name="phone_numbers[]">
                                            </div>
                                        </div>
                                        <div class="float-right  btn-group">
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='addPhone'>
                                                <i class="fa fa-plus-circle"></i> Add More Phone
                                            </a>

                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='removePhone'>
                                                <i class="fa fa-minus-circle"></i> Remove One
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="primary_mobile">{{ __('Primary Mobile') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="primary_mobile"
                                           name="primary_mobile"
                                           value="{{ $edit ? $institute->primary_mobile : old('primary_mobile') }}"
                                           placeholder="{{ __('Primary Mobile') }}">
                                </div>
                            </div>


                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div id='AddMultiMobile' class="mb-2">
                                            @if(!empty($institute->mobile_numbers))
                                                <?php $sl = 0; $sl_div = 0; $mobile_id = 0; ?>
                                                @foreach($institute->mobile_numbers as $mobile)
                                                    <div id="AddMobileDiv{{ ++$sl_div }}">
                                                        <label class="label-text"
                                                               style="margin-bottom: 9px;">{{ __('Mobile #') }}{{ ++$sl }}</label>
                                                        <input type='text' id='mobile{{++$mobile_id}}'
                                                               class="form-control mobile_numbers"
                                                               name="mobile_numbers[]" value="{{ $mobile }}">
                                                    </div>
                                                @endforeach
                                            @else
                                                <div id="AddMobileDiv1">
                                                    <label>Mobile #1 : </label>
                                                    <input type='text' id='mobile1' class="form-control mobile_numbers"
                                                           name="mobile_numbers[]">
                                                </div>
                                            @endif

                                        </div>
                                        <div class="float-right  btn-group">
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='addMobile'>
                                                <i class="fa fa-plus-circle"></i> Add More Mobile
                                            </a>
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='removeMobile'>
                                                <i class="fa fa-minus-circle"></i> Remove One
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div id='AddMultiMobile' class="mb-2">
                                            <div id="AddMobileDiv1">
                                                <label>Mobile #1 : </label>
                                                <input type='text' id='mobile1' class="form-control mobile_numbers"
                                                       name="mobile_numbers[]">
                                            </div>
                                        </div>
                                        <div class="float-right  btn-group">
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='addMobile'>
                                                <i class="fa fa-plus-circle"></i> Add More Mobile
                                            </a>
                                            <a class="btn btn-sm btn-outline-primary btn-rounded" id='removeMobile'>
                                                <i class="fa fa-minus-circle"></i> Remove One
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{ __('Institute Address') }}</label>
                                    <textarea class="form-control" id="address" name="address"
                                              rows="3">{{ $edit ? $institute->address : old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="google_map_src">{{ __('Google Map src') }}</label>
                                    <textarea class="form-control" id="google_map_src" name="google_map_src"
                                              rows="3">{{ $edit ? $institute->google_map_src : old('google_map_src') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="logo">{{ __('Logo') }} <span style="color: red"> * </span></label>
                                    <div class="input-group">
                                        <div class="logo-upload-section">
                                            <div class="avatar-preview text-center">
                                                <label for="logo">
                                                    <img class="figure-img"
                                                         src={{ $edit && $institute->logo ? asset('storage/'. $institute->logo) :  "https://via.placeholder.com/350x350?text=Institute+Logo"}}
                                                             width="200" height="200"
                                                         alt="Institute logo"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="logo" style="display: none"
                                                   id="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        const EDIT = !!'{{$edit}}';
        const editAddForm = $('.edit-add-form');


        $.validator.addMethod(
            "logoSize",
            function (value, element) {
                let isHeightMatched = $('.avatar-preview').find('img')[0].naturalHeight === 80;
                let isWidthMatched = $('.avatar-preview').find('img')[0].naturalWidth === 80;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "Invalid logo size. Size must be 80 * 80",
        );

        editAddForm.validate({
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
                code: {
                    required: true,
                    remote: {
                        param: {
                            type: "post",
                            url: "{{ route('course_management::admin.check-institute-code') }}",
                        },
                        depends: function (element) {
                            return $(element).val() !== $('#code').attr('data-code');
                        }
                    },
                },
                domain: {
                    required: true,
                    pattern: /^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/,
                },
                primary_phone: {
                    pattern: /^[0-9]*$/,
                },
                'phone_numbers[]': {
                    pattern: /^[0-9]*$/,
                },
                primary_mobile: {
                    required: true,
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                'mobile_numbers[]': {
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                logo: {
                    required: !EDIT,
                    accept: 'image/*',
                    // logoSize: true,
                },
            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
                code: {
                    required: "This field is required",
                    remote: "Code already in use!",
                },
                primary_phone: {
                    pattern: 'Please enter valid mobile number',
                },
                'phone_numbers[]': {
                    pattern: 'Please enter valid phone number',
                },
                primary_mobile: {
                    pattern: 'Please enter valid mobile number',
                },
                'mobile_numbers[]': {
                    pattern: 'Please enter valid mobile number',
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(input).parent().find('.avatar-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }


        $(document).ready(function () {
            var counter = 2;
            if (EDIT == true) {
                counter = $('.phone_numbers').length + 1;
            }
            $("#addPhone").click(function () {
                if (counter > 10) {
                    alert("Only 10 phone allow");
                    return false;
                }
                var newAddPhone = $(document.createElement('div'))
                    .attr("id", 'AddPhoneDiv' + counter);
                newAddPhone.after().html('<label>Phone #' + counter + ' : </label>' +
                    '<input type="text" name="phone_numbers[]' +
                    '" id="phone' + counter + '" value="" class="form-control phone_numbers" >');
                newAddPhone.appendTo("#AddMultiPhone");
                counter++;
            });

            $("#removePhone").click(function () {
                if (counter == 2) {
                    $('#phone1').val('');
                    return false;
                }
                counter--;
                $("#AddPhoneDiv" + counter).remove();
            });

        });

        //Add multiple Mobile
        $(document).ready(function () {
            //var main_counter = $('.mobile_numbers').length+1;
            var counter = 2;
            if (EDIT == true) {
                counter = $('.mobile_numbers').length + 1;
            }
            $("#addMobile").click(function () {
                if (counter > 10) {
                    alert("Only 10 mobile allow");
                    return false;
                }
                var newAddMobile = $(document.createElement('div'))
                    .attr("id", 'AddMobileDiv' + counter);
                newAddMobile.after().html('<label>Mobile #' + counter + ' : </label>' +
                    '<input type="text" name="mobile_numbers[]' +
                    '" id="mobile' + counter + '" value="" class="form-control mobile_numbers" >');
                newAddMobile.appendTo("#AddMultiMobile");
                counter++;
            });

            $("#removeMobile").click(function () {
                if (counter == 2) {
                    //alert("No more mobile to remove");
                    $('#mobile1').val('');
                    return false;
                }
                counter--;
                $("#AddMobileDiv" + counter).remove();
            });

            $("#logo").change(function () {
                readURL(this); //preview image
                editAddForm.validate().element("#logo");
            });

        });
    </script>
@endpush


