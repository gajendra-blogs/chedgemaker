<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Invoice</title>
</head>

<body>
    <div class="">
        <span>{{$generated_at}}</span>
        <h3 class="text-center text-white bg-dark">Invoice</h3>
        <h2 class="text-center">{{ setting('app_name') }}</h2>
    </div>

    <div style="display: flex; margin-top: 4px">
        <div style="float: left;">
            <h4>Student Details</h4>
            <table class="table">
                <tr>
                    <td>Name </td>
                    <td>: {{ $invoice_details->first_name }} {{$invoice_details->last_name }}</td>
                </tr>
                <tr>
                    <td>Mobile No </td>
                    <td>: {{ $invoice_details->phone }}</td>
                </tr>
                <tr>
                    <td>Email </td>
                    <td>: {{ $invoice_details->email }}</td>
                </tr>
            </table>
        </div>
        <div style="float: right;">
            <h4>Course Details :</h4>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>: {{ $invoice_details->course_name }}</td>
                </tr>
                <tr>
                    <td>Center</td>
                    <td>: {{ $invoice_details->center_name }}</td>
                </tr>
                <tr>
                    <td>Total Fee</td>
                    <td>: {{ $invoice_details->total_bill_amount }}</td>
                </tr>
                <tr>
                    <td>Booking Status</td>
                    <td>: {{ ucfirst($invoice_details->registration_status) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mt-4 table-responsive" style="margin-top: 4px">
        <h4>Payment Details : -</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Selected Fee Type</th>
                    <th>Total Fee</th>
                    <th>Amount Paid</th>
                    <th>Amount Remaining</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$invoice_details->course_name}}</td>
                    <td>{{ucfirst($invoice_details->selected_fee_type)}}</td>
                    <td>{{$invoice_details->total_bill_amount}}</td>
                    <td>{{$invoice_details->amount}}</td>
                    <td>{{$invoice_details->total_due_amount}}</td>
                    <td>{{ucfirst($invoice_details->payment_method)}}</td>
                    <td>{{$invoice_details->payments_created_at}}</td>
                    <td class="{{$invoice_details->payments_status == 'captured' ? 'text-success' : 'text-danger' }}">{{$invoice_details->payments_status == 'captured' ? 'Success' : 'Pending'}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="display: flex;">
        <div>

        </div>
    </div>
</body>

</html>