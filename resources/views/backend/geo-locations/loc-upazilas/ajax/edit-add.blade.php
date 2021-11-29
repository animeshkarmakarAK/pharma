@php
    $edit = !empty($locUpazila->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{!$edit ? 'Add Upazila': 'Update Upazila'}}
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
                  action="{{$edit ? route('admin.loc-upazilas.update', $locUpazila->id) : route('admin.loc-upazilas.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif

                <div class="col-sm-6 col-md-4">
                    <label for="name_en">Title (En) <span style="color: red"> * </span></label>
                    <input type="text" class="form-control" name="title_en" value="{{$edit ? $locUpazila->title_en : ''}}"/>
                </div>
                <div class="col-sm-6 col-md-4">
                    <label for="name_en">BBS Code <span style="color: red"> * </span></label>
                    <input type="text" class="form-control" name="bbs_code" value="{{$edit ? $locUpazila->bbs_code : ''}}"/>
                </div>
                <div class="col-sm-6 col-md-4">
                    <label for="loc_division_id">{{ __('Division') }} <span
                            style="color: red"> * </span></label>
                    <select class="form-control select2-ajax-wizard"
                            name="loc_division_id"
                            data-model="{{base64_encode(App\Models\LocDivision::class)}}"
                            data-label-fields="{title} - {title_en}"
                            @if($edit)
                            data-preselected-option="{{json_encode(['text' =>  $locUpazila->division->title, 'id' =>  $locUpazila->division->id])}}"
                            @endif
                            data-placeholder="{{ __('generic.select_placeholder') }}"
                    >
                    </select>
                </div>
                <div class="col-sm-6 col-md-4">
                    <label for="loc_district_id">{{ __('District') }} <span
                            style="color: red"> * </span></label>
                    <select class="form-control select2-ajax-wizard"
                            name="loc_district_id"
                            data-model="{{base64_encode(App\Models\LocDistrict::class)}}"
                            data-label-fields="{title} - {title_en}"
                            data-depend-on="loc_division_id"
                            @if($edit)
                            data-preselected-option="{{json_encode(['text' =>  $locUpazila->district->title, 'id' =>  $locUpazila->district->id])}}"
                            @endif
                            data-placeholder="{{ __('generic.select_placeholder') }}"
                    >
                    </select>
                </div>

                <div class="col-sm-12 text-right mt-2">
                    <button type="submit" class="btn btn-success">{{$edit ? 'Update' : 'Create'}}</button>
                </div>
            </form>
        </div><!-- /.card-body -->
        <div class="overlay" style="display: none">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
    </div>
</div>
