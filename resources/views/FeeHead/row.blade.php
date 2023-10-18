<tr>
    <td>{{ $oneFeeHead->fee_heads_title }}</td>
    <td>{{ $oneFeeHead->fee_heads_sequence }}</td>
    <!-- <td>{{ $oneFeeHead->charges_type}}</td> -->
    <td>
        @if(auth()->user()->role_id != 1)
        @if ($oneFeeHead->status==1)
        <a href="" class="badge badge-success">active</a>
        @else
        <a href="" class="badge badge-warning">inactive</a>
        @endif
        @else
        @if ($oneFeeHead->status==1)
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $oneFeeHead->id }}" onclick="changeStatus('{{ Crypt::encrypt($oneFeeHead->id)  }}'  ,'{{ $oneFeeHead->status }}','{{ Crypt::encrypt('fee_heads')  }}' , this)" checked>
            <label class="custom-control-label" for="{{ $oneFeeHead->id }}"></label>
        </div>

        @else
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $oneFeeHead->id }}" onclick="changeStatus('{{ Crypt::encrypt($oneFeeHead->id)  }}' ,'{{ $oneFeeHead->status }}','{{ Crypt::encrypt('fee_heads')  }}' , this)">
            <label class="custom-control-label" for="{{ $oneFeeHead->id }}"></label>
        </div>
        @endif
        @endif
    </td>
    <td class="text-center">
        <a href="" data-row="{{$edit ? $loop->iteration : $row_count}}" data-href="{{ route('feehead.edit', Crypt::encrypt($oneFeeHead->id))}}" type="button" class="btn btn-icon edit" title="@lang('Edit Fee Head')" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('feehead.destroy',Crypt::encrypt($oneFeeHead->id)) }}" class="btn btn-icon" title="@lang('Delete Fee Head')" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('Please Confirm')" data-confirm-text="@lang('Are you sure that you want to delete this Fee Head?')" data-confirm-delete="@lang('Yes, delete it!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>