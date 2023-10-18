@if (count($batches))
    @foreach ($batches as $batch)
        @include('batches.partials.row')
    @endforeach
@else
<tr>
    <td colspan="7"><em>@lang('No records found.')</em></td>
</tr>
@endif