<tr>

    <td class="align-middle">
        <a href="">
            {{ $course->course_name ?: __('N/A') }}
        </a>
    </td>
    <td class="align-middle">{{ $course->course_description}}</td>
    <td class="align-middle">{{ $course->course_duration }} @lang('Days')</td>
    <td class="align-middle">
        {{$course->center_name}}
    </td>
    <td class="align-middle">
        {{$course->center_location}}
    </td>
    <td class="align-middle">
        {{$course->contact_person}}
    </td>
    <td class="align-middle">
        {{$course->contact_number}}
    </td>
   
    <td class="align-middle">
        @if ($course->status==1)
        <span href="" class="badge badge-success">Active</span>
        @else
        <span href="" class="badge badge-warning">Inactive</span>
        @endif
    </td>

    <td class="align-middle">
        Entroll Now
    </td>

</tr>