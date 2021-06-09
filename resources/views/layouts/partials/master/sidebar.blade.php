<!-- Main Sidebar Container -->
{{--elevation-4--}}
<aside class="main-sidebar sidebar-blue-dark nav-compact nav-flat nav-child-indent text-sm">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link bg-white logo-switch pb-4">
        <span class="logo-xl" style="box-shadow: 2px 2px 0 #130202">
            <span class="pl-4 pr-1" style="background: #52606d">
                <span class="text-warning font-weight-bold">NISE</span><sup class="text-white">3</sup>
            </span>
            <span class="pl-1 pr-4 text-white" style="background: #777f85">
                <i class="fa fa-arrow-right"></i>DC|DBoard
            </span>
        </span>
        <span class="logo-xs" style="box-shadow: 1px 1px 0 #130202">
            <span class="" style="background: #52606d">
                <span class="text-warning font-weight-bold">NISE</span><sup class="text-white">3</sup>
            </span>
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
