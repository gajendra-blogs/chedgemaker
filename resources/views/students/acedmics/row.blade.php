<tr class="list-group-flush mt-3">
    @if($acedmic->certificate_id)
        <td class="align-middle"><a target="_blank" class="text-primary align-middle" href="{{ route('students.view.academic.doc'  , $acedmic->certificate_id) }}">@lang('View')</a></td>
     @else
     <td></td>
    @endif
    <td class="align-middle">{{ $acedmic->qualification}}</td>
    <td class="align-middle">{{ $acedmic->institute }}</td>
    <td class="align-middle">{{ $acedmic->university }}</td>
    <td class="align-middle">{{ $acedmic->passout_year }}</td>
    <td class="align-middle">{{ $acedmic->place }}</td>
    <td class="align-middle">{{ $acedmic->marks }}</td>
</tr>