@if (count($courses))
@foreach ($courses as $course)
@include('courses.partials.row' , ['edit' => true])
@endforeach
@else
<tr>
    <td colspan="7"><em>@lang('No records found.')</em></td>
</tr>
@endif