@if (count($modules))
@foreach ($modules as $module)
@include('module.partials.row' , ['edit' => true])
@endforeach
@else
<tr>
    <td colspan="7"><em>@lang('No records found.')</em></td>
</tr>
@endif