<div class="modal fade" id="AddAcademicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="add-academic">
                    @include('frontend.user.partial.editAcademic' , ['edit' => false])
                </div>
                <div id="edit-academic">

                </div>
            </div>
        </div>
    </div>
</div>
