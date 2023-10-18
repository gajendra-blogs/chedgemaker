@extends('layouts.home')


@section('page-title', __('Reset Password'))

@section('content')

<div class="col-md-8 col-lg-6 col-xl-5 mx-auto my-10p">

    <div class="card mt-5 mb-5"
        style="background-color: #f5f8fa;box-shadow: 0 0 8px 0 rgb(0 0 0 / 6%), 0 1px 0px 0 rgb(0 0 0 / 2%);">
        <div class="card-body">
            <h5 class="card-title text-center mt-4 mb-2 text-uppercase">
                @lang('Forgot Your Password?')
            </h5>

            <div class="p-4">
                <form role="form" action="<?= route('password.email') ?>" method="POST" id="remind-password-form"
                    autocomplete="off">
                    {{ csrf_field() }}

                    <p class="text-muted mb-4 text-center font-weight-light">
                        @lang('Please provide your email below and we will send you a password reset link.')
                    </p>

                    @include('partials.messages')

                    <div class="form-group password-field my-3">
                        <label for="password" class="sr-only">@lang('Email')</label>
                        <input type="email" name="email" id="email" class="form-control input-solid"
                            placeholder="@lang('Your E-Mail')">
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" data-animation="fadeInUp" data-delay="1.6s" class="main-btn btn-lg w-100"
                            id="btn-reset-password">
                            @lang('Reset Password')
                        </button>


                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@stop

@section('scripts')
{!! JsValidator::formRequest('Vanguard\Http\Requests\Auth\PasswordRemindRequest', '#remind-password-form') !!}
@stop
