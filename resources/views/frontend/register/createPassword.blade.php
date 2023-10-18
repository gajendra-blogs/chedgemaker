@extends('layouts.auth')

@section('page-title', trans('Create Your Password'))

@section('content')

<div class="col-md-8 col-lg-6 col-xl-5 mx-auto my-10p" id="login">
    <div class="text-center">
        <!-- <img src="{{ url('assets/img/projectLogo.png') }}" alt="{{ setting('app_name') }}" height="100"> -->
        
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title text-center mt-4 text-uppercase">
                @lang('Create Your Password')
            </h5>

            <div class="p-4">

                <form action="{{ route('user.store.password' , Crypt::encrypt($user->id)) }}" method="POST" id="create-password-form" autocomplete="off" class="mt-3">

                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    @method('PUT')
                    <div class="form-group password-field">
                        <label for="password" class="sr-only">@lang('Password')</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control input-solid"
                               placeholder="@lang('Password')">
                    </div>

                    <div class="form-group password-field">
                        <label for="confirm-password" class="sr-only">@lang('Confirm Password')</label>
                        <input type="confirm-password"
                               name="confirm-password"
                               id="confirm-password"
                               class="form-control input-solid"
                               placeholder="@lang('Confirm Password')">
                    </div>




                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-create-password">
                            @lang('Create Password')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    {!! JsValidator::formRequest('Vanguard\Http\Requests\studentRegistration\CreatePassword', '#create-password-form') !!}
@stop
