<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{__('View District')}}
    </h4>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white">
                <div class="card-header custom-bg-gradient-info text-primary">
                    <h3 class="card-title font-weight-bold">{{ __('District Info') }}</h3>
                </div>

                <div class="card-body row">
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Title') }}</p>
                        <div class="input-box">
                            {{ $locDistrict->title ?? "" }}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Title(BN)') }}</p>
                        <div class="input-box">
                            {{ $locDistrict->title_en ?? ""}}
                        </div>
                    </div>

                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('BBS Code') }}</p>
                        <div class="input-box">
                            {{ $locDistrict->bbs_code ?? ""}}
                        </div>
                    </div>
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Division') }}</p>
                        <div class="input-box">
                            {{ $locDistrict->division->title ?? ""}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-right">
            <a href="javascript:;"
               data-url="{{ route('admin.loc-districts.edit', $locDistrict) }}"
               class="btn btn-sm btn-outline-warning rounded-0 border-left-0 dt-edit button-from-view"><i
                    class="fas fa-edit"></i> {{ __('generic.edit_button_label') }}</a>
        </div>
    </div>
</div>
