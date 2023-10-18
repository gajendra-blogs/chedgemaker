<tr>
    <td style="width: 40px;">
        <a href="{{ route('students.show', $student) }}">
            <img class="rounded-circle img-responsive" width="40" src="{{ $student->present()->avatar }}"
                alt="{{ $student->present()->name }}">
        </a>
    </td>
    <td class="align-middle">{{ $student->email }}</td>
    <td class="align-middle">{{ $student->first_name . ' ' . $student->last_name }}</td>
    <!-- <td class="align-middle"> {{ $student->center_name }} </td> -->
    <td class="align-middle">{{ $student->created_at->format(config('app.date_format')) }}</td>
    <td class="align-middle">
        <span class="badge badge-lg {{ $student->status =='Active' ? 'bg-primary' : 'bg-danger' }}">
            {{ $student->status }}
        </span>
    </td>
    <td class="text-center align-middle">
        <a href="{{ route('students.show', $student) }}" class="btn btn-icon view">
            <i class="fas fa-eye mr-2"></i>
        </a>

        <a href="{{ route('students.edit', $student) }}" class="btn btn-icon edit" title="@lang('Edit Student')"
            data-toggle="tooltip" data-placement="top">
            <i class="fas fa-edit"></i>
        </a>

        <a href="{{ route('students.destroy', $student) }}" class="btn btn-icon" title="@lang('Delete Student')"
            data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('Please Confirm')"
            data-confirm-text="@lang('Are you sure that you want to delete this student?')"
            data-confirm-delete="@lang('Yes, delete him!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
