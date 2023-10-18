@extends('layouts.app')



@section('page-title', __('Students'))
@section('page-heading', __('Students'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Students')
</li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">
        <form action="{{ route('students.index') }}" method="GET" id="students-form"
            class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search"
                            value="{{ Request::get('search') }}" placeholder="@lang('Search for students...')">
                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('students.index') }}"
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
                <div class="col-md-8">
                    <div class="col-md-2 mt-2 mt-md-0">
                        {!!
                        Form::select(
                        'status',
                        $statuses,
                        Request::get('status'),
                        ['id' => 'status', 'class' => 'form-control input-solid']
                        )
                        !!}
                    </div>
                </div>

            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('email')}}"> @lang('Email') <span class="sort-icon"> <i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('first_name')}}">@lang('Full Name') <span class="sort-icon">
                                <i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('registration_date')}}">@lang('Registration Date') <span
                                class="sort-icon"> <i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-80">@lang('Status')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($students))
                    @foreach ($students as $student)
                    @include('students.partials.row')
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7"><em>@lang('No records found.')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{!! $students->render() !!}
@section('scripts')
<script>
    appySorting();
    $("#status").change(function () {
        $("#students-form").submit();
    });

</script>
@stop

@stop
