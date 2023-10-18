@extends('layouts.app')

@section('page-title', __('Student Registrations'))
@section('page-heading', __('Student Registrations'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Student Registrations')
</li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">
        <input type="hidden" id="approvedDiscountUrl" value="{{ route('approveDiscount') }}">
        <input type="hidden" id="cencelDiscountUrl" value="{{ route('cencelDiscount') }}">

        <form action="{{ route('userRegistrations.index') }}" method="GET" id="UserRegistrationList-form"
            class="pb-2 mb-3 border-bottom-light">

            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search"
                            value="{{ Request::get('search') }}" placeholder="@lang('Search for Registrations...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('userRegistrations.index') }}"
                                class="btn btn-light d-flex align-items-center text-muted" role="button">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            <button class="btn btn-light" type="submit" id="search-users-btn">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="searchStudents" class="form-control" id="searchStudents">
                        <option value="allStudents" {{$selectedStudentType == "allStudents"  ? 'selected' : ''}}>All
                            Students
                        </option>
                        <option value="bookedStudents" {{$selectedStudentType == "bookedStudents"  ? 'selected' : ''}}>
                            Booked Students</option>
                        <option value="registeredStudents"
                            {{$selectedStudentType == "registeredStudents"  ? 'selected' : ''}}>
                            Registered Students</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{Route('downloadExcelFileUrl',$selectedStudentType)}}"><i class="fa fa-download"
                            aria-hidden="true"></i>Download File</a>
                </div>


                <div class="col-md-3">
                    <a href="{{ route('userRegistrations.create') }}" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Register Student')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('users.id')}}">@lang('Student') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('email')}}">@lang('Student Email') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('first_name')}}">@lang('Student Phone') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('student_registration_code')}}">@lang('Enrollement No.') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Center Name') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('course_name')}}">@lang('Course Name') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Total Fee (in ₹)') <span
                                class="sort-icon"></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Payable Fee (in ₹)') <span
                                class="sort-icon"></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Fee Plan Type') <span
                                class="sort-icon"></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Amount Paid') <span
                                class="sort-icon"></span></th>
                        <th class="min-width-100">@lang('Status')</th>
                        <th class="min-width-100">@lang('Discount Status')</th>
                        <th class="text-center">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($registrationsList))
                    @foreach ($registrationsList as $registrationData)
                    @include('userRegistrations.partials.row')
                    @endforeach
                    @else
                    <tr>
                        <td colspan="14" class="text-center"><em>@lang('No records found.')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{!! $registrationsList->render() !!}


@stop
@section('scripts')
{!! HTML::script('assets/js/feePlan/studentFeePlan.js') !!}
<script>
    $("#searchStudents").change(() => {
        $("#UserRegistrationList-form").submit();
    });
    appySorting();

</script>
@stop
