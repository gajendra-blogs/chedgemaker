@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@section('page-title', __('Centers'))
@section('page-heading', __('Centers'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Centers')
</li>
@stop

@section('content')

@include('partials.messages')
<div id="notification-logging">

</div>

<div class="card">
    <div class="card-body">
        <table class="table  table-striped">
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Total Students</th>
                <th>Download Excel</th>
            </tr>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>All Students</td>
                    <td>{{$allStudentCount}}</td>

                    <td>
                        <a href="{{Route('downloadExcelFileUrl','allStudents')}}"><i class="fa fa-download"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Booked Students</td>
                    <td>{{$allBookedStudentsCount}}</td>

                    <td>
                        <a href="{{Route('downloadExcelFileUrl','bookedStudents')}}"><i class="fa fa-download"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Registered Students</td>
                    <td>{{$registeredStudentsCount}}</td>
                    <td>
                        <a href="{{Route('downloadExcelFileUrl','registeredStudents')}}"><i class="fa fa-download"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Down Payment Students</td>
                    <td>{{$downPaymentStudentCounts}}</td>
                    <td>
                        <a href="{{Route('downloadExcelFileUrl','downPaymentStudents')}}"><i class="fa fa-download"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Center Wise Students</td>
                    <td>{{$centerWiseStudentCount}}</td>
                    <td>
                        <a href="{{Route('downloadExcelFileUrl','centerWiseStudents','1')}}"><i class="fa fa-download"
                                aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!--Add or Update Modal -->



@stop


@section('scripts')
{!! HTML::script('assets/js/center/center.js') !!}
@stop
