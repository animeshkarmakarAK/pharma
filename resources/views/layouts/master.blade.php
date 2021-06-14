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
    @yield('header', \Illuminate\Support\Facades\View::make('master::layouts.partials.master.header'))

    @yield('sidebar', Illuminate\Support\Facades\View::make('master::layouts.partials.master.sidebar'))

    <div class="content-wrapper px-1 py-2">
        @yield('content')
    </div>

    @yield('footer', Illuminate\Support\Facades\View::make('master::layouts.partials.master.footer'))

    <x-modal id="user-profile-view-modal" type="success" xl></x-modal>
</div>
<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
<script src="{{asset('/js/admin-lte.js')}}"></script>
<script src="{{asset('/js/on-demand.js')}}"></script>
<script>
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

    /**
     * To show current logged in user in modal
     */
    $(document).on('click', "#user-profile-view", async function () {
        let url = '{{route('admin.users.show', auth()->user()->id)}}';
        let response = await $.get(url);
        $("#user-profile-view-modal").find('.modal-content').html(response);
        $("#user-profile-view-modal").modal('show');
    });
</script>
@stack('js')
</body>
<script>
</script>
</html>

