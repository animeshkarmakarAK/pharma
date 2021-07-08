@php
    $edit = !empty($user->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{!$edit ? 'Add User': ($authUser->id == $user->id ? 'Update Profile' : 'Update User')}}
    </h4>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card card-outline">
        <div class="card-body">
            <form class="row edit-add-form" method="post"
                  action="{{$edit ? route('admin.users.update', $user->id) : route('admin.users.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif
                <div class="col-md-12">
                    <div class="row justify-content-center align-content-center">
                        <div class="form-group" style="width: 200px; height: 200px">
                            <div class="input-group">
                                <div class="profile-upload-section">
                                    <div class="avatar-preview text-center">
                                        <label for="profile_pic">
                                            <img class="img-thumbnail rounded-circle"
                                                 src="{{$edit && $user->profile_pic ? asset('storage/'.$user->profile_pic) : 'https://via.placeholder.com/350x350?text=Profile+Picture'}}"
                                                 style="width: 200px; height: 200px"
                                                 alt="Profile pic"/>
                                            <span class="p-1 bg-gray"
                                                  style="position: absolute; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                        </label>
                                    </div>
                                    <input type="file" name="profile_pic" style="display: none"
                                           id="profile_pic">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name_en">Name (English) <span style="color: red"> * </span></label>
                        <input type="text" class="form-control" id="name_en"
                               name="name_en"
                               value="{{$edit ? $user->name_en : old('name_en')}}"
                               placeholder="Name (English)">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name_bn">Name (বাংলা) <span style="color: red"> * </span></label>
                        <input type="text" class="form-control" id="name_bn"
                               name="name_bn"
                               value="{{$edit ? $user->name_bn : old('name_bn')}}"
                               placeholder="Name (বাংলা)">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="email">{{ __('Email') }} <span style="color: red"> * </span></label>
                        <input type="email" class="form-control" id="email"
                               name="email"
                               value="{{$edit ? $user->email : old('email')}}"
                               placeholder="{{ __('Email') }}">
                    </div>
                </div>

                @if($edit && $authUser->can('changeUserType', $user))
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_type_id">{{ __('User Type') }} <span
                                    style="color: red"> * </span></label>
                            <select class="form-control select2-ajax-wizard"
                                    name="user_type_id"
                                    id="user_type_id"
                                    data-model="{{base64_encode(App\Models\UserType::class)}}"
                                    data-label-fields="{title}"
                                    @if($edit)
                                    data-preselected-option="{{json_encode(['text' =>  $user->userType->title, 'id' =>  $user->userType->code])}}"
                                    @endif
                                    data-placeholder="নির্বাচন করুন"
                            >
                            </select>
                        </div>
                    </div>
                    @elseif(!$edit)
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_type_id">{{ __('User Type') }} <span
                                    style="color: red"> * </span></label>
                            <select class="form-control select2-ajax-wizard"
                                    name="user_type_id"
                                    id="user_type_id"
                                    data-model="{{base64_encode(App\Models\UserType::class)}}"
                                    data-label-fields="{title}"
                                    data-placeholder="নির্বাচন করুন"
                            >
                            </select>
                        </div>
                    </div>
                @endif

                <div class="col-sm-6" style="display: none;">
                    <div class="form-group">
                        <label for="institute_id">{{ __('Institute') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control select2-ajax-wizard"
                                name="institute_id"
                                id="institute_id"
                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                data-label-fields="{title_en}"
                                @if($edit && $user->institute)
                                data-preselected-option="{{json_encode(['text' =>  $user->institute->title_en, 'id' =>  $user->institute->id])}}"
                                @endif
                                data-placeholder="Select Institute"
                        >
                            <option selected disabled>Select Institute</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6" style="display: none;">
                    <div class="form-group">
                        <label for="organization_id">{{ __('Organization') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control select2-ajax-wizard"
                                name="organization_id"
                                id="organization_id"
                                data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Organization::class)}}"
                                data-label-fields="{title_en}"
                                @if($edit && $user->organization)
                                data-preselected-option="{{json_encode(['text' =>  $user->organization->title_en, 'id' =>  $user->organization->id])}}"
                                @endif
                                data-placeholder="Select Organization"
                        >
                            <option selected disabled>Select Organization</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6" style="display: none;">
                    <div class="form-group">
                        <label for="loc_district_id">{{ __('District') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control select2-ajax-wizard"
                                name="loc_district_id"
                                id="loc_district_id"
                                data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                data-label-fields="{title_en}"
                                @if($edit && $user->locDistrict)
                                data-preselected-option="{{json_encode(['text' =>  $user->locDistrict->title_en, 'id' =>  $user->locDistrict->id])}}"
                                @endif
                                data-placeholder="Select District"
                        >
                            <option selected disabled>Select District</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6" style="display: none;">
                    <div class="form-group">
                        <label for="loc_division_id">{{ __('Division') }} <span
                                style="color: red"> * </span></label>
                        <select class="form-control select2-ajax-wizard"
                                name="loc_division_id"
                                id="loc_division_id"
                                data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                data-label-fields="{title_en}"
                                @if($edit && $user->locDivision)
                                data-preselected-option="{{json_encode(['text' =>  $user->locDivision->title_en, 'id' =>  $user->locDivision->id])}}"
                                @endif
                                data-placeholder="Select Division"
                        >
                            <option selected disabled>Select Division</option>
                        </select>
                    </div>
                </div>

                @if($edit && $authUser->id == $user->id && $authUser->can('changePassword', $user))
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="old_password">{{ __('Old Password') }}<span
                                    style="color: red"> * </span></label>
                            <input type="password" class="form-control" id="old_password"
                                   name="old_password"
                                   value=""
                                   placeholder="{{ __('Old Password') }}">
                        </div>
                    </div>
                @endif

                @if(!$edit || $authUser->can('changePassword', $user))
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">{{ __($edit ? 'New Password' : 'Password') }} <span
                                    style="color: red"> * </span></label>
                            <input type="password" class="form-control" id="password"
                                   name="password"
                                   value=""
                                   placeholder="{{ __($edit ? 'New Password' : 'Password') }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label
                                for="password_confirmation">{{ __($edit ? 'Retype New Password' : 'Retype Password') }}
                                <span style="color: red"> * </span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation"
                                   value=""
                                   placeholder="{{ __($edit ? 'Retype New Password' : 'Retype Password') }}">
                        </div>
                    </div>

                @endif
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-success">{{$edit ? 'Update' : 'Create'}}</button>
                </div>
            </form>
        </div><!-- /.card-body -->
        <div class="overlay" style="display: none">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
    </div>
</div>

