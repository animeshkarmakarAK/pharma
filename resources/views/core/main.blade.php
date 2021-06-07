<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>{{'NISE3'}} - @yield('title', 'TMS')</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/frontendStyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <style>
        .sidebar-blue-dark {
            background: #2F49D1;
        }

        .sidebar-blue-dark .nav-sidebar .nav-item > .nav-link {
            color: #F2F4FC;
        }

        .sidebar-blue-dark .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
            background-color: #0d2bc6;
        }
    </style>
    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('core.header')

    @include('core.sidebar')

    <div class="content-wrapper px-1 py-2">
        @yield('content')
    </div>

    @include('core.footer')
</div>
<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
<script src="{{asset('/js/admin-lte.js')}}"></script>
<script src="{{asset('/js/on-demand.js')}}"></script>
<script>
    window.asset_storage = '{{asset('storage/')}}';
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $.validator.setDefaults({
        errorElement: "em",
        onkeyup: false,
        ignore: [],
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            element.parents(".form-group").addClass("has-feedback");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else if (element.hasClass('select2-ajax') || element.hasClass('select2') || element.hasClass('select2-ajax-wizard')) {
                error.insertAfter(element.parents(".form-group").find('.select2-container'));
            } else if (element.parents('.form-group').find('.input-group').length) {
                error.insertAfter(element.parents('.form-group').find('.input-group'));
            } else {
                error.insertAfter(element);
            }
        },
        success: function (label, element) {
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
        },
    });

    @if(\Illuminate\Support\Facades\Session::has('alerts'))
    let alerts = {!! json_encode(\Illuminate\Support\Facades\Session::get('alerts')) !!};
    helpers.displayAlerts(alerts, toastr);
    @endif
    @if(\Illuminate\Support\Facades\Session::has('message'))
    let alertType = {!! json_encode(\Illuminate\Support\Facades\Session::get('alert-type', 'info')) !!};
    let alertMessage = {!! json_encode(\Illuminate\Support\Facades\Session::get('message')) !!};
    let alerter = toastr[alertType];
    alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");
    @endif

    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });

    window.ajaxFailedResponseHandler = function (xhr) {
        if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON.errors !== 'undefined' && Array.isArray(xhr.responseJSON.errors) && xhr.responseJSON.errors.length) {
            xhr.responseJSON.errors.forEach(function (error) {
                toastr.error(error);
            })
        } else if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON.data !== 'undefined') {
            toastr.error(xhr.responseJSON.data);
        } else if (typeof xhr.responseJSON !== 'undefined' && Array.isArray(xhr.responseJSON) && xhr.responseJSON.length) {
            xhr.responseJSON.forEach(function (error) {
                toastr.error(error);
            })
        } else if (typeof xhr.responseJSON !== 'undefined' && xhr.responseJSON && xhr.responseJSON.message !== 'undefined' && xhr.responseJSON.message) {
            toastr.error(xhr.responseJSON.message);
        } else if (typeof xhr.responseJSON !== 'undefined' && xhr.responseJSON) {
            toastr.error(xhr.responseJSON);
        } else {
            toastr.error(xhr.responseText);
        }
    }
</script>
@stack('js')
</body>
<script>
</script>
</html>

