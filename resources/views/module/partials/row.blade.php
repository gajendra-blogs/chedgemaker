
<tr>
  
  <td class="align-middle">
      <a href="">
          {{ $module->name ?: __('N/A') }}
      </a>
  </td>
  <td class="align-middle">{{ $module->description}}</td>
  <td class="align-middle">{{ $module->duration }} @lang('Days')</td>
  <td>
      @if(auth()->user()->role_id != 1)
          @if ($module->status==1)
          <a href="" class="badge badge-success">active</a>
          @else
          <a href="" class="badge badge-warning">inactive</a>
          @endif
          @else
          @if ($module->status==1)
          <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="{{ $module->id }}" onclick="changeStatus('{{ Crypt::encrypt($module->id)  }}' ,'{{ $module->status }}','{{ Crypt::encrypt('modules')  }}',this)"  checked>
              <label class="custom-control-label" for="{{ $module->id }}"></label>
              </div>
      
      @else
      <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input" id="{{ $module->id }}" onclick="changeStatus('{{ Crypt::encrypt($module->id)  }}' ,'{{ $module->status }}','{{ Crypt::encrypt('modules')  }}' ,this)" >
          <label class="custom-control-label" for="{{ $module->id }}"></label>
          </div>
      @endif
      @endif
  </td>
  @if (auth()->user()->hasRole('Admin'))
  <td class="text-center align-middle">
      

      <a href=""
          type="button"
          data-href="{{ route('module.edit', $module)}}"
          data-row="{{$edit ? $loop->iteration : $row_count}}"
         class="btn btn-icon edit"
         title="@lang('Edit module')"
         data-toggle="tooltip" data-placement="top">
          <i class="fas fa-edit"></i>
      </a>

      <a href="{{ route('module.destroy', $module) }}"
         class="btn btn-icon"
         title="@lang('Delete module')"
         data-toggle="tooltip"
         data-placement="top"
         data-method="DELETE"
         data-confirm-title="@lang('Please Confirm')"
         data-confirm-text="@lang('Are you sure that you want to delete this module?')"
         data-confirm-delete="@lang('Yes, delete this!')">
          <i class="fas fa-trash"></i>
      </a>
  </td>
  @endif
</tr>