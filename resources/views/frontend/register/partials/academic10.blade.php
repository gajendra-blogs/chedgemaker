<h5 style="color:#07294d">10th Marksheet</h5>
<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <input type="text" name="10_th_marksheet[]" id="institute" class="form-control input-solid"
                placeholder="@lang('Institute')" value="{{$edit ? $academic10->institute  : ''}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <input type="text" name="10_th_marksheet[]" id="university" class="form-control input-solid"
                placeholder="@lang('Board')" value="{{$edit ? $academic10->university  : ''}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <input type="text" name="10_th_marksheet[]" id="passout_year" class="form-control input-solid"
                placeholder="@lang('Passout Year')" value="{{$edit ? $academic10->passout_year  : ''}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <input type="text" name="10_th_marksheet[]" id="marks" class="form-control input-solid"
                placeholder="@lang('Total Marks / CGPA')" value="{{$edit ? $academic10->marks  : ''}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <input type="text" name="10_th_marksheet[]" id="place" class="form-control input-solid"
                placeholder="@lang('Place')" value="{{$edit ? $academic10->place  : ''}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="10_th_marksheet_file">
                <svg height="2em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z" />
                </svg>
            </label>&nbsp;&nbsp;<span>upload file</span>
            <input type="file" style="display: none" name="10_th_marksheet_file[]" id="10_th_marksheet_file"
                class="form-control input-solid form-control-file" placeholder="@lang('Documents')">
                    <span id="10_th_marksheet_File_preview"></span>&nbsp;&nbsp;
                                            <i id="10_th_icon_cancle" class="fa fa-times text-danger"
                                                aria-hidden="true"></i>
        </div>
    </div>
    @if($edit)
    <input type="hidden" name="academic_id" value="{{$academic10->id}}">
    @endif
</div>
