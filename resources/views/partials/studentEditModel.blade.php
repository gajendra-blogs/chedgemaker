<div class="modal fade" id="StudentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{$form_action}}" method="post" id="update10" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="row_count" id="rowCount">
                    <div id="edit">

                    </div>
                    <div class="col-md-12 mt-2">
                        <button type="submit" class="btn btn-primary" id="update-details-btn">
                            <i class="fa fa-refresh"></i>
                            @lang('Update')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>