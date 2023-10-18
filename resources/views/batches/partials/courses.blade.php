@foreach($assigned_courses as $assigned_course)
<li class="list-group-item">{{ $assigned_course->course_name }}</li>
@endforeach