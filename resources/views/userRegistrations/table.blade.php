@if (count($registrationsList))
@foreach ($registrationsList as $registrationData)
@include('userRegistrations.partials.row')
@endforeach
@else
<tr>
    <td colspan="14" class="text-center"><em>@lang('No records found.')</em></td>
</tr>
@endif
