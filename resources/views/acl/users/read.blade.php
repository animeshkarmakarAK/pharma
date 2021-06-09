<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> View User
    </h4>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row user-profile">
        <div class="col-md-4">
            <div class="user-details card mb-3">
                <div class="card-body">
                    <div class="user-image text-center">
                        <img
                            src="https://t3.ftcdn.net/jpg/02/94/62/14/360_F_294621430_9dwIpCeY1LqefWCcU23pP9i11BgzOS0N.jpg"
                            height="100" width="100" class="rounded-circle" alt="Cinque Terre">
                    </div>
                    <div class="d-flex justify-content-center user-info normal-line-height mt-3">
                        <p class="header text-center">{{ $user->name_bn ?? "" }}</p>
                        <p class="text-center ml-2">({{ $user->name_en ?? ""}})</p>
                    </div>
                    <p class="designation text-center">{{ $user->userType->title ?? "" }}</p>
                </div>

                <div class="btn-group" role="group" aria-label="user action buttons">
                    @can('update', $user)
                        <a href="javascript:;"
                           data-url="{{ route('admin.users.edit', $user) }}"
                           class="btn btn-sm btn-outline-warning rounded-0 border-left-0 dt-edit button-from-view"><i
                                class="fas fa-edit"></i> {{ __('generic.edit_button_label') }}</a>
                    @endcan
                    @can('delete', $user)
                        <a href="javascript:;"
                           class="btn btn-sm btn-outline-danger delete rounded-0">
                            <i class="fas fa-trash"></i>
                            {{ __('generic.delete_button_label') }}
                        </a>
                    @endcan
                    @can('viewUserPermission', $user)
                        <a href="{{route('admin.users.permissions', $user)}}"
                           class="btn btn-sm btn-outline-info rounded-0 border-right-0">
                            <i class="fas fa-users-cog"></i>
                            {{ __('permission') }}
                        </a>
                    @endcan
                </div>
            </div>

            <div class="user-contact card bg-white mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="text-center">
                            <i class="fa fa-phone"></i>
                        </div>
                        <p class="medium-text ml-2">{{ __('generic.phone')  }}</p>
                    </div>
                    <div class="phone">
                        <p class="medium-text">{{ $user->mobile ? $user->mobile : "017585939" }}</p>
                    </div>
                </div>
                <div class="card-header">
                    <div class="row">
                        <div class="text-center">
                            <i class="fa fa-envelope text-primary"></i>
                        </div>
                        <p class="medium-text ml-2 text-primary">{{ __('generic.email') }}</p>
                    </div>
                    <div class="email">
                        <p class="medium-text">{{ $user->email ?? ""}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card bg-white">
                <div class="card-header custom-bg-gradient-info text-primary">
                    <h3 class="card-title font-weight-bold">{{ __('User Info') }}</h3>
                </div>

                <div class="card-body row">
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Name(EN)') }}</p>
                        <div class="input-box">
                            {{ $user->name_en ?? "" }}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Name(BN)') }}</p>
                        <div class="input-box">
                            {{ $user->name_bn ?? ""}}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Email)') }}</p>
                        <div class="input-box">
                            {{ $user->email ?? ""}}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('User Type)') }}</p>
                        <div class="input-box">
                            {{ $user->UserType->title ?? "" }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
