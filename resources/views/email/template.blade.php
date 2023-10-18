
<h2>Hello, {{$user->first_name}} {{$user->last_name}} </h2>
<p style="margin-top: 2px;"> Your payment of Rs {{$payments_details['amount']}} has been successfull</p>

<div style="margin-top:8px;">
    <p>Thank You</p>
    <p>Team - {{setting('app_name')}}</p>
</div>