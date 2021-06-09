@extends('master::main.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="http://lorempixel.com/400/400"
                                 alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                        <p class="text-muted text-center">{{$user->email}}</p>
                        <ul class="nav flex-column">
                            <li class="active nav-item">
                                <a href="{{route('admin.users.show', $user->id)}}" class="nav-link active">
                                    <i class="fa fa-home"></i>
                                    Overview </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="https://codepen.io/jasondavis/pen/jVRwaG?editors=1000">
                                    <i class="fa fa-user"></i>
                                    Account Settings </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fa fa-check"></i>
                                    Tasks </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fa fa-flag"></i>
                                    Help </a>
                            </li>
                        </ul>
                        <hr class="m-0 mb-3"/>
                        <div class="row d-flex">
                            <a href="{{route('admin.users.edit', $user->id)}}"
                               class="btn btn-outline-warning flex-fill"><b>Edit</b></a>
                            <a href="#" class="btn btn-outline-danger flex-fill ml-1"><b>Delete</b></a>
                            <a href="#" class="btn btn-outline-info flex-fill ml-1"><b>Sync Role</b></a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
            @yield('profile-content')
            <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
