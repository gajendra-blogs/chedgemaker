@if (count($students))
@foreach ($students as $student)
@include('students.partials.row')
@endforeach
@else
<tr>
    <td colspan="6"><em>@lang('No records found.')</em></td>
</tr>
@endif
