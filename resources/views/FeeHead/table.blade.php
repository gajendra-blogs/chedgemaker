@if (count($feehead))
    @foreach ($feehead as $oneFeeHead)
        @include('FeeHead.row' , ['edit' => true , 'oneFeeHead' => $oneFeeHead])
    @endforeach
@else
<tr>
    <td colspan="4"><em>@lang('No records found.')</em></td>
</tr>
@endif