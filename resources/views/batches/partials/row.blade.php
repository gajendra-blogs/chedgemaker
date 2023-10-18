
<tr>
    <td class="align-middle">{{ $batch->center_name }}</td>
    <td class="align-middle">{{ $batch->course_name }}</td>
    <td class="align-middle">
        <!-- <a href="{{ route('batches.show', $batch->id) }}"> -->
            {{ $batch->batch_name ?: __('N/A') }}
        <!-- </a> -->
    </td>
    <td class="align-middle">{{ $batch->batch_duration }} Days</td>
    <td class="align-middle">{{ $batch->batch_start }}</td>
    <td class="align-middle">{{ $batch->batch_end }}</td>
    @if (auth()->user()->hasRole('Admin'))
    <td>
        @if(auth()->user()->role_id != 1)
            @if ($batch->status==1)
            <a href="" class="badge badge-success">active</a>
            @else
            <a href="" class="badge badge-warning">inactive</a>
            @endif
            @else
            @if ($batch->status==1)
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="{{ $batch->id }}" onclick="changeStatus('{{ Crypt::encrypt($batch->id)  }}' ,'{{  $batch->status }}','{{ Crypt::encrypt('batches')  }}',this)"  checked>
                <label class="custom-control-label" for="{{ $batch->id }}"></label>
            </div>
        @else
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $batch->id }}" onclick="changeStatus('{{ Crypt::encrypt($batch->id) }}' ,'{{ $batch->status }}','{{ Crypt::encrypt('batches')  }}',this)" >
            <label class="custom-control-label" for="{{ $batch->id }}"></label>
            </div>
        @endif
        @endif
    </td>
    <td class="text-center align-middle">
        <div class="dropdown show d-inline-block">
            <a class="btn btn-icon"
               href="#" role="button" id="dropdownMenuLink"
               data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-h"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                <a href="{{ route('batches.show', Crypt::encrypt($batch->id)) }}" class="dropdown-item text-gray-500">
                    <i class="fas fa-eye mr-2"></i>
                    @lang('View Batch')
                </a>
            </div>
        </div>

        <a href="{{ route('batches.edit', Crypt::encrypt($batch->id)) }}"
           class="btn btn-icon edit"
           title="@lang('Edit Batch')"
           data-row="{{ $edit ? $row_count : $loop->iteration }}"
           data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('batches.destroy', Crypt::encrypt($batch->id)) }}"
           class="btn btn-icon"
           title="@lang('Delete Batch')"
           data-toggle="tooltip"
           data-placement="top"
           data-method="DELETE"
           data-confirm-title="@lang('Please Confirm')"
           data-confirm-text="@lang('Are you sure that you want to delete this batch?')"
           data-confirm-delete="@lang('Yes, delete him!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
    @endif
</tr>