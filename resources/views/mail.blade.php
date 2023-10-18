<h3>Hii {{$user->first_name}} {{$user->last_name}}</h3>
<p>You have due date for your intallment of Rs {{$installment['installment_amount']}} on {{$due_date->format('Y-m-d H:i:s')}} of {{$course->course_name}} Course</p>
<p>Please Pay Your Installment</p>