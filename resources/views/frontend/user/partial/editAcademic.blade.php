
@if($edit)
<form action="{{route('student.academic.update' , $academic->id)}}" method="post" id="academic-form-edit" enctype="multipart/form-data">
@method('PUT')
@else
<form action="{{route('student.academic.add')}}" method="post" id="academic-form" enctype="multipart/form-data">
@endif
@csrf
    <div class="row">
        <div class="col-sm-12">
        <label for="qualification">Select Qualification</label>
            <div class="form-group mb-3">
                <select class="custom-select" name="qualification" id="qualification" {{$edit ? 'disabled' : ''}}>
                    <option value="">Select Qualification</option>
                    <option value="10" {{$edit ? $academic->qualification == '10' ? 'selected' : '' : ''}}>High School</option>
                    <option value="12" {{$edit ? $academic->qualification == '12' ? 'selected' : '' : ''}}>Higher Secondary</option>
                    <option value="graduation" {{$edit ? $academic->qualification == 'graduation' ? 'selected' : '' : ''}}>Graduation</option>
                    <option value="post_graduation" {{$edit ? $academic->qualification == 'post_graduation' ? 'selected' : '' : ''}}>Post Graduation</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label for="address1">Institue</label>
            <div class="form-group mb-3">
                <input type="text" name="institute" id="institute" class="form-control input-solid" placeholder="Institute" value="{{$edit ? $academic->institute : ''}}">
            </div>
            <label for="address1">University</label>
            <div class="form-group mb-3">
                <input type="text" name="university" id="university" class="form-control input-solid" placeholder="Board" value="{{$edit ? $academic->university : ''}}">
            </div>
            <label for="address1">Passout Year</label>
            <div class="form-group mb-3">
                <input type="text" name="passout_year" id="passout_year" class="form-control input-solid" placeholder="Passout Year" value="{{$edit ? $academic->passout_year : ''}}">
            </div>
        </div>
        <div class="col-md-6">
            <label for="address1">Marks</label>
            <div class="form-group mb-3">
                <input type="text" name="marks" id="marks" class="form-control input-solid" placeholder="Total Marks" value="{{$edit ? $academic->marks : ''}}">
            </div>
            <label for="address1">Place</label>
            <div class="form-group mb-3">
                <input type="text" name="place" id="place" class="form-control input-solid" placeholder="Place" value="{{$edit ? $academic->place : ''}}">
            </div>
            <div class="form-group mb-3">
            <label for="address1">Marksheet</label>

                <label for="marksheet_file">
                    <!-- <svg height="2em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z" />
                    </svg> -->
                    <input type="file" name="marksheet_file" id="marksheet_file" class="form-control input-solid form-control-file" placeholder="Documents">
            </div>
        </div>
        @if($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                Update Details
            </button>
        </div>

        @else
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                Add Academics
            </button>
        </div>
        @endif

    </div>

</form>

