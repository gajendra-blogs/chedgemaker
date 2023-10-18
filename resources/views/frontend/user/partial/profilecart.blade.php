<table class="table table-sm">
    <tbody>
        <tr>
            <td> <strong>@lang('Name'):</strong></td>
            <td> {{ $current_user->first_name }} {{ $current_user->last_name}}</td>
        </tr>
        @if ($current_user->father_name)
        <tr>
            <td> <strong>@lang('Father Name'):</strong></td>
            <td> {{ $current_user->father_name }}</td>
        </tr>
        @endif
        @if ($current_user->guardian_contact)
        <tr>
            <td> <strong>@lang('Father Contact'):</strong></td>
            <td> {{ $current_user->guardian_contact }}</td>
        </tr>
        @endif

        @if ($current_user->id_proof_type)
        <tr>
            <td> <strong>@lang('Id Type'):</strong></td>
            <td> {{ $current_user->id_proof_type}}</td>
        </tr>
        @endif
        @if ($current_user->phone)
        <tr>
            <td> <strong>@lang('Phone'):</strong></td>
            <td> <a href="telto:{{ $current_user->phone }}">{{ $current_user->phone }}</a></td>
        </tr>
        @endif
        <tr>
            <td><strong>@lang('Birthday'):</strong></td>
            <td> {{ $current_user->present()->birthday }}</td>
        </tr>
        <tr>
            <td> <strong>@lang('Last Logged In'):</strong></td>
            <td>{{ $current_user->present()->lastLogin }}</td>
        </tr>

    </tbody>
</table>
