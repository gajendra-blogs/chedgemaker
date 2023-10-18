@if (count($fee))
@foreach ($fee as $feePlan)
@include('feePlan.partials.row')
@endforeach
@else
<tr>
    <td colspan="7"><em>@lang('No records found.')</em></td>
</tr>
@endif
