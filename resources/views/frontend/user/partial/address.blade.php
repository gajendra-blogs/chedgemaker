<table class="table table-sm">
    <tbody>
        <tr>
            <td> <strong>@lang('Address'):</strong></td>
            <td> {{ $addresses ? $addresses->address1 : '' }} <span>{{$addresses ? $addresses->address2 : ''}}</span>
            </td>
        </tr>

        <tr>
            <td> <strong>@lang('City '):</strong></td>
            <td> {{ $addresses ? $addresses->city : '' }}</td>
        </tr>
        <tr>
            <td> <strong ong>@lang('State '):</strong></td>
            <td> {{ $addresses ? $addresses->state_name : '' }}</td>
        </tr>
        <tr>
            <td> <strong>@lang('Country '):</strong></td>
            <td> {{ $addresses ? $addresses->country_name : '' }}</td>
        </tr>
        <tr>
            <td> <strong>@lang('Pin Code '):</strong></td>
            <td> {{ $addresses ? $addresses->pin_code : '' }}</td>
        </tr>

    </tbody>
</table>
