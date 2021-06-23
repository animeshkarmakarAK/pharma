@php
    $edit = !empty($theme->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

<div class="modal-header custom-bg-gradient-info">
    <h4 class="modal-title">
        <i class="fas fa-eye"></i> {{!$edit ? 'Add Theme': 'Update Theme'}}
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
                  action="{{$edit ? route('admin.themes.update', $theme->id) : route('admin.themes.store')}}"
                  enctype="multipart/form-data">
                @csrf
                @if($edit)
                    @method('put')
                @endif
                <div class="col-sm-6 col-md-4">
                    <label for="name_en">Name <span style="color: red"> * </span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{$edit ? $theme->name : ''}}"/>
                </div>

                <div class="col-sm-6 col-md-4">
                    <label for="name_en">Key <span style="color: red"> * </span></label>
                    <input type="text" class="form-control" name="key" value="{{$edit ? $theme->key : ''}}"/>
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
