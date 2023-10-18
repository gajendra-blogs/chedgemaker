
<tr>
  
    <td class="align-middle">
        <a href="">
            {{ $course->course_name ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">{{ $course->course_description}}</td>
    <td class="align-middle">{{ $course->course_duration }} @lang('Days')</td>
    <td>
        @if(auth()->user()->role_id != 1)
            @if ($course->status==1)
            <a href="" class="badge badge-success">active</a>
            @else
            <a href="" class="badge badge-warning">inactive</a>
            @endif
            @else
            @if ($course->status==1)
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="{{ $course->id }}" onclick="changeStatus('{{ Crypt::encrypt($course->id)  }}' ,'{{ $course->status }}','{{ Crypt::encrypt('courses')  }}',this)"  checked>
                <label class="custom-control-label" for="{{ $course->id }}"></label>
                </div>
        
        @else
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $course->id }}" onclick="changeStatus('{{ Crypt::encrypt($course->id)  }}' ,'{{ $course->status }}','{{ Crypt::encrypt('courses')  }}' ,this)" >
            <label class="custom-control-label" for="{{ $course->id }}"></label>
            </div>
        @endif
        @endif
    </td>
    @if (auth()->user()->hasRole('Admin'))
    <td class="text-center align-middle">   
        <a href=""
            type="button"
            data-href="{{ route('course.edit', $course)}}"
            data-row="{{$edit ? $loop->iteration : $row_count}}"
           class="btn btn-icon edit"
           title="@lang('Edit Course')"
           data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('course.destroy', $course) }}"
           class="btn btn-icon"
           title="@lang('Delete Course')"
           data-toggle="tooltip"
           data-placement="top"
           data-method="DELETE"
           data-confirm-title="@lang('Please Confirm')"
           data-confirm-text="@lang('Are you sure that you want to delete this Course?')"
           data-confirm-delete="@lang('Yes, delete this!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
    @endif
</tr>