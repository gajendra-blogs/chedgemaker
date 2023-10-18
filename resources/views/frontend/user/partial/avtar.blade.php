<div class="avatar-wrapper">
    <div class="spinner">
        <div class="spinner-dot"></div>
        <div class="spinner-dot"></div>
        <div class="spinner-dot"></div>
    </div>
    <div id="avatar"></div>
    <div class="text-center">
        <div class="avatar-preview">
            <img class="avatar rounded-circle img-thumbnail img-responsive mt-5 mb-4" width="150" src="{{auth()->user()->present()->avatar}}">

            <h5 id="avtar-text" class="text-muted">{{ auth()->user()->present()->nameOrEmail }}</h5>
            <p id="avtar-text" class="text-muted">{{ auth()->user()->email }}</p>
        </div>
        <div id="change-picture" class="btn btn-outline-secondary btn-block mt-5" data-toggle="modal" data-target="#choose-modal">
            <i class="fa fa-camera"></i>
            @lang('Change Photo')
        </div>

        <div class="row avatar-controls d-none">
            <div class="col-md-6">
                <div id="cancel-upload" class="btn btn-block btn-outline-secondary text-center">
                    <i class="fa fa-times"></i> @lang('Cancel')
                </div>
            </div>
            <div class="col-md-6">
                <button type="submit" id="save-photo" class="btn btn-success btn-block text-center">
                    <i class="fa fa-check"></i> @lang('Save')
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="choose-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 avatar-source">
                        <form action="{{route('student.profile.update.avatar')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="btn btn-light btn-upload form-group">
                                <i class="fa fa-upload"></i>
                                <input type="file" name="avatar" id="avatar-upload" class="custom-input">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="mt-3 btn btn-primary">@lang('Upload Photo')</p>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="d-none">
    <input type="hidden" name="points[x1]" id="points_x1">
    <input type="hidden" name="points[y1]" id="points_y1">
    <input type="hidden" name="points[x2]" id="points_x2">
    <input type="hidden" name="points[y2]" id="points_y2">
</div>