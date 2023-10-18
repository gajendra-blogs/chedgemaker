@extends('layouts.auth')
@section('page-title', __('Login'))



@section('content')

<div class="col-md-8 col-lg-6 col-xl-5 mx-auto my-10p"  id="login">
    <div class="text-center">
        <!-- <img src="{{ url('assets/img/projectLogo.png') }}" alt="{{ setting('app_name') }}" height="100"> -->
    </div>
    <div class="card mt-5" style="background-color: #f5f8fa;box-shadow: 0 0 8px 0 rgb(0 0 0 / 6%), 0 1px 0px 0 rgb(0 0 0 / 2%);">
        <div class="card-body">

            <h5 class="card-title text-center mt-4 text-uppercase">
                @lang('Login')
            </h5>

            <div class="p-4">
                @include('auth.social.buttons')

                @include('partials.messages')

                <form role="form" action="<?= url('login') ?>" method="POST" id="login-form" autocomplete="off" class="mt-3">

                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">

                    @if (Request::has('to'))
                        <input type="hidden" value="{{ Request::get('to') }}" name="to">
                    @endif

                    <div class="form-group m-3">
                        <label for="username" class=" sr-only">@lang('Email or Username')</label>
                        <input type="text"
                                name="username"
                                id="username"
                                class="form-control input-solid"
                                placeholder="@lang('Email or Username')"
                                value="{{ old('username') }}">
                    </div>

                    <div class="form-group m-3 password-field">
                        <label for="password" class="sr-only">@lang('Password')</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control input-solid"
                               placeholder="@lang('Password')">
                    </div>


                    @if (setting('remember_me'))
                        <div class="custom-control custom-checkbox m-3">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" value="1"/>
                            <label class="custom-control-label font-weight-normal" for="remember">
                                @lang('Remember me?')
                            </label>
                        </div>
                    @endif


                    <div class="form-group mt-4 m-3">
                        <button type="submit" data-animation="fadeInUp" data-delay="1.6s" class="main-btn btn-lg w-100"  id="btn-login">
                            @lang('Log In')
                        </button>
                    </div>
                </form>

                @if (setting('forgot_password'))
                    <a href="<?= route('password.request') ?>" class="forgot m-3" style="color: #07294d;">@lang('I forgot my password')</a>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center text-muted">
   
            <br>
        @if (setting('reg_enabled'))
            @lang("Don't have an account?")
            <a class="font-weight-bold" href="<?= url("user/register") ?>">@lang('Enroll Now')</a>
        @endif
    </div>
</div>



@section('scripts')
    {!! HTML::script('assets/js/as/login.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Auth\LoginRequest', '#login-form') !!}
@stop

@stop