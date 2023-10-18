@if (count($centers))
@foreach ($centers as $center)
    @include('center.row' , ['edit' => true])
@endforeach
@else
<tr>
    <td colspan="6"><em>@lang('No records found.')</em></td>
</tr>
@endif