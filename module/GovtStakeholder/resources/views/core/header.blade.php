<nav class="main-header navbar navbar-fixed navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        @auth
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fa fa-circle"></i></a>
            </li>
        @endauth
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.login-form')}}">
                    <i class="far fa-user"></i>
                </a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link text-sm" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-tie"></i> {{auth()->user()->name_en ?? auth()->user()->name_bn}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">
                    <a href="{{route('admin.users.show', auth()->user()->id)}}">
                      <i class="fas fa-user-tie fa-5x"></i><br/>
                        <h4 class="text-dark">{{auth()->user()->name_en ?? auth()->user()->name_bn}}</h4>
                        <span class="d-block text-sm">
                        <i class="fas fa-user-tag ml-2"></i>
                        {{optional(auth()->user()->role)->title_en ?? optional(auth()->user()->role)->title_bn}}
                        </span>
                    </a>
                </span>
{{--                    <div class="dropdown-divider"></div>--}}
{{--                    <a href="#" class="dropdown-item">--}}
{{--                        <i class="fas fa-edit mr-2"></i> Edit Profile--}}
{{--                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.logout') }}" class="dropdown-item dropdown-footer"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>

<script>

</script>
