@php
    $currentInstitute = domainConfig('institute');
@endphp
<!-- Main Sidebar Container -->
{{--elevation-4--}}
<aside class="main-sidebar sidebar-blue-dark nav-compact nav-flat nav-child-indent text-sm">
    <a href="{{url('/')}}" class="brand-link bg-white logo-switch pb-4">
        <span class="logo-xl">
            @if($currentInstitute)
                <img src="{{asset('storage/' .$currentInstitute->logo)}}" height="35px" alt="logo"/>
            @else
                <img src="{{asset('/assets/company/images/nise-logo.jpeg')}}" height="35px" alt="logo"/>
            @endif
        </span>
        <span class="logo-xs">
             @if($currentInstitute)
                <img src="{{asset('storage/' .$currentInstitute->logo)}}" height="35px" alt="logo"/>
            @else
                <img src="{{asset('/assets/company/images/nise-logo.jpeg')}}" height="35px" alt="logo"/>
            @endif
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            {!! menu('admin_menu', 'admin-lte', ['icon' => true]) !!}
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
