<tr>
    <td>{{ $center->center_name }}</td>
    <td>{{ $center->center_code }}</td>
    <td>{{ $center->center_location }}</td>
    <td>{{ $center->contact_person }}</td>
    <td>{{ $center->center_email }}</td>
    <td>{{ $center->contact_number }}</td>
    <td>
        @if(auth()->user()->role_id != 1)
        @if ($center->status==1)
        <a href="" class="badge badge-success">active</a>
        @else
        <a href="" class="badge badge-warning">inactive</a>
        @endif
        @else
        @if ($center->status==1)
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $center->id }}" onclick="changeStatus('{{ Crypt::encrypt($center->id)  }}' ,'{{ $center->status }}','{{ Crypt::encrypt('centers')  }}',this)" checked>
            <label class="custom-control-label" for="{{ $center->id }}"></label>
        </div>
        @else
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $center->id }}" onclick="changeStatus('{{ Crypt::encrypt($center->id)  }}' ,'{{ $center->status }}','{{ Crypt::encrypt('centers')  }}',this)">
            <label class="custom-control-label" for="{{ $center->id }}"></label>
        </div>
        @endif
        @endif
    </td>
    <td class="text-center">
        <a href="{{ route('center.edit', Crypt::encrypt($center->id))}}" data-row="{{$edit ? $loop->iteration : $row_count}}" class="btn btn-icon edit" title="@lang('Edit Center')" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('center.destroy',Crypt::encrypt($center->id)) }}" class="btn btn-icon" title="@lang('Delete Center')" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('Please Confirm')" data-confirm-text="@lang('Are you sure that you want to delete this Center?')" data-confirm-delete="@lang('Yes, delete it!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>