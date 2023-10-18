<?php

use App\Http\Controllers\CenterController;

use Vanguard\Http\Controllers\Web\CourseController;
use Vanguard\Http\Controllers\Web\AssignCourseCenterController;
use Doctrine\DBAL\Driver\Middleware;
use Vanguard\Http\Controllers\Web\Courses\CoursesController;
use Vanguard\Http\Controllers\Web\LoggingController;
use Vanguard\Http\Controllers\Web\UsersCourseController;
use Vanguard\Http\Controllers\Web\PaymentController;




Route::group(['middleware' => 'prevent-back-history'], function () {
    /**
     * frontend
     */

    Route::get('/', 'Frontend\StudentRegistrationController@index')->name('home');

    /**
     * Authentication
     */
    Route::get('login', 'Auth\LoginController@show');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');


    //  Center Management


    Route::group(
        ['middleware' => ['auth', 'permission:centers.manage']],
        function () {
            Route::get('center', 'CenterController@index')->name('center.index');
            Route::get('center/create', 'CenterController@create')->name('center.create');
            Route::post('center/store', 'CenterController@store')->name('center.store');
            Route::get('center/edit/{id}', 'CenterController@edit')->name('center.edit');
            Route::post('center/update/{id}', 'CenterController@update')->name('center.update');
            Route::delete('center/destroy/{id}', 'CenterController@destroy')->name('center.destroy');
        }
    );


    Route::group(
        ['middleware' => ['registration', 'guest']],
        function () {
            Route::get('register', 'Auth\RegisterController@show');
            Route::post('register', 'Auth\RegisterController@register');
        }
    );

    Route::emailVerification();

    Route::group(
        ['middleware' => ['password-reset', 'guest']],
        function () {
            Route::resetPassword();
        }
    );

    /**
     * Two-Factor Authentication
     */
    Route::group(
        ['middleware' => 'two-factor'],
        function () {
            Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
            Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
        }
    );

    /**
     * Social Login
     */
    Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
    Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

    /**
     * Impersonate Routes
     */
    Route::group(
        ['middleware' => 'auth'],
        function () {
            Route::impersonate();
        }
    );

    Route::group(
        ['middleware' => ['auth', 'verified', 'permission:access.adminpanal']],
        function () {

            /**
             * Dashboard
             */

            Route::get('/admin', 'DashboardController@index')->name('dashboard')
            ;

            /**
             * User Profile
             */

            Route::group(
                ['prefix' => 'profile', 'namespace' => 'Profile'],
                function () {
                        Route::get('/admin', 'ProfileController@show')->name('profile');
                        Route::get('activity', 'ActivityController@show')->name('profile.activity');
                        Route::put('details', 'DetailsController@update')->name('profile.update.details');

                        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
                        Route::post('avatar/external', 'AvatarController@updateExternal')
                            ->name('profile.update.avatar-external');

                        Route::put('login-details', 'LoginDetailsController@update')
                            ->name('profile.update.login-details');

                        Route::get('sessions', 'SessionsController@index')
                            ->name('profile.sessions')
                            ->middleware('session.database');

                        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
                            ->name('profile.sessions.invalidate')
                            ->middleware('session.database');
                    }
            );

            /**
             * Two-Factor Authentication Setup
             */

            Route::group(
                ['middleware' => 'two-factor'],
                function () {
                        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

                        Route::get('two-factor/verification', 'TwoFactorController@verification')
                            ->name('two-factor.verification')
                            ->middleware('verify-2fa-phone');

                        Route::post('two-factor/resend', 'TwoFactorController@resend')
                            ->name('two-factor.resend')
                            ->middleware('throttle:1,1', 'verify-2fa-phone');

                        Route::post('two-factor/verify', 'TwoFactorController@verify')
                            ->name('two-factor.verify')
                            ->middleware('verify-2fa-phone');

                        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
                    }
            );



            /**
             * User Management
             */
            Route::resource('users', 'Users\UsersController')
                ->except('update')->middleware('permission:users.manage');

            Route::group(
                ['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'],
                function () {
                        Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
                        Route::put('update/login-details', 'Users\LoginDetailsController@update')
                            ->name('users.update.login-details');

                        Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
                        Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
                            ->name('user.update.avatar.external');

                        Route::get('sessions', 'Users\SessionsController@index')
                            ->name('user.sessions')->middleware('session.database');

                        Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
                            ->name('user.sessions.invalidate')->middleware('session.database');

                        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
                        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');

                        Route::get('acedmic/edit/{acedmic}', 'Users\AcedmicController@edit')->name('acedmic.edit.student');
                        Route::put('acedmic/update', 'Users\AcedmicController@update')->name('acedmic.update.student');
                    }
            );

            /**
             * Roles & Permissions
             */
            Route::group(
                ['namespace' => 'Authorization'],
                function () {
                        Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

                        Route::post('permissions/save', 'RolePermissionsController@update')
                            ->name('permissions.save')
                            ->middleware('permission:permissions.manage');

                        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
                    }
            );


            /**
             * Settings
             */

            Route::get('settings', 'SettingsController@general')->name('settings.general')
                ->middleware('permission:settings.general');

            Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
                ->middleware('permission:settings.general');

            Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
                ->middleware('permission:settings.auth');

            Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
                ->middleware('permission:settings.auth');

            Route::post('center/changeStatus', 'CenterController@changeStatus')->name('center.changeStatus');


            if (config('services.authy.key')) {
                Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
                    ->name('settings.auth.2fa.enable')
                    ->middleware('permission:settings.auth');

                Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
                    ->name('settings.auth.2fa.disable')
                    ->middleware('permission:settings.auth');
            }

            Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
                ->name('settings.registration.captcha.enable')
                ->middleware('permission:settings.auth');

            Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
                ->name('settings.registration.captcha.disable')
                ->middleware('permission:settings.auth');

            Route::get('settings/notifications', 'SettingsController@notifications')
                ->name('settings.notifications')
                ->middleware('permission:settings.notifications');

            Route::post('settings/notifications', 'SettingsController@update')
                ->name('settings.notifications.update')
                ->middleware('permission:settings.notifications');

            /**
             * Activity Log
             */

            Route::get('activity', 'ActivityController@index')->name('activity.index')
                ->middleware('permission:users.activity');

            Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
                ->middleware('permission:users.activity');

            /* Student Profile on Admin */
            Route::get('students', 'StudentController@index')->name('students.index');
            Route::get('students/show/{student}', 'StudentController@show')->name('students.show');
            Route::get('students/edit/{student}', 'StudentController@edit')->name('students.edit');
            Route::delete('students/delete/{student}', 'StudentController@destroy')->name('students.destroy');
            Route::put('students/update/{student}', 'StudentController@update')->name('students.update');
            Route::put('students/loginupdate/{student}', 'StudentController@loginupdate')->name('students.update.login-details');
            Route::put('students/academicupdate/{student}', 'StudentController@academicupdate')->name('students.update.academic');
            Route::put('students/addressupdate/{student}', 'StudentController@addressupdate')->name('students.update.address');
            Route::post('students/avatarupdate/{student}', 'StudentController@avatarupdate')->name('students.update.avatar');
            Route::get('students/view/academics/doc/{academic_id}', 'StudentController@viewAcademicDoc')->name('students.view.academic.doc');
        }
    );


    /**
     * Installation
     */

    Route::group(
        ['prefix' => 'install'],
        function () {
            Route::get('/', 'InstallController@index')->name('install.start');
            Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
            Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
            Route::get('database', 'InstallController@databaseInfo')->name('install.database');
            Route::get('start-installation', 'InstallController@installation')->name('install.installation');
            Route::post('start-installation', 'InstallController@installation')->name('install.installation');
            Route::post('install-app', 'InstallController@install')->name('install.install');
            Route::get('complete', 'InstallController@complete')->name('install.complete');
            Route::get('error', 'InstallController@error')->name('install.error');
        }
    );

    Route::group(
        ['middleware' => ['auth', 'permission:batches.manage']],
        function () {

            Route::get('batches/create', [AssignCourseCenterController::class, 'create'])->name('batches.create');
            Route::post('batches/store', [AssignCourseCenterController::class, 'store'])->name('batches.store');
            Route::get('batches/edit/{batch}', [AssignCourseCenterController::class, 'edit'])->name('batches.edit');
            Route::put('batches/update/{batch}', [AssignCourseCenterController::class, 'update'])->name('batches.update');
            Route::get('batches/view/{batch}', [AssignCourseCenterController::class, 'show'])->name('batches.show');
            Route::delete('batches/delete/{batch}', [AssignCourseCenterController::class, 'destroy'])->name('batches.destroy');
        }
    );
    Route::get('batches', [AssignCourseCenterController::class, 'index'])->name('batches.index');
    // Route::get('courses', [CourseController::class , 'show']);

    Route::group(
        ['middleware' => ['auth', 'verified']],
        function () {
            /**
             * Course Management
             */
            Route::resource('course', 'Courses\CoursesController')->middleware('permission:course.manage');

            /**
             * Student Registration Management
             */
            Route::resource('userRegistrations', 'userRegistrations\UserRegistration')->middleware('permission:userRegistration.manage');
            Route::group(
                ['middleware' => ['auth', 'permission:userRegistration.manage']],
                function () {
                        Route::post('userRegistrations/update/{id}', 'userRegistrations\UserRegistration@update')->name('userRegistrations.update');

                    }
            );


            /**
             * Module Management
             */
            Route::resource('module', 'Module\ModuleController')->middleware('permission:module.manage');


            /**
             * Fee Plan Details Management
             */
            Route::resource('feePlanDetails', 'FeeManagement\FeePlanDetailsController')->middleware('permission:feeHead.manage');
        }
    );


    /**
     * Status Change Toggle
     */
    Route::group(
        ['middleware' => 'auth'],
        function () {
            Route::post('/changeStatus', 'StatusChangeController@changeStatus')->name('changeStatus');
            Route::post('/updateDiscount', 'userRegistrations\UserRegistration@updateDiscount')->name('updateDiscount');
            Route::post('/approveDiscount', 'userRegistrations\UserRegistration@ApproveDiscount')->name('approveDiscount');
            Route::post('/cencelDiscount', 'userRegistrations\UserRegistration@CencelDiscount')->name('cencelDiscount');
            Route::post('/updateStatus', 'userRegistrations\UserRegistration@updateStudentPaymentStatus')->name('updateStatus');
        }
    );



    /**
     * Fees Management
     */
    Route::group(
        ['middleware' => ['auth', 'permission:feeHead.manage']],
        function () {
            Route::get('feehead', 'FeeController@index')->name('feehead.index');
            Route::get('feeHead/create', 'FeeController@create')->name('feeHead.create');
            Route::post('feehead/store', 'FeeController@store')->name('feehead.store');
            Route::get('feehead/edit/{id}', 'FeeController@edit')->name('feehead.edit');
            Route::post('feehead/update/{id}', 'FeeController@update')->name('feehead.update');
            Route::delete('feehead/destroy/{id}', 'FeeController@destroy')->name('feehead.destroy');
        }
    );


    Route::group(
        ['middleware' => ['auth', 'permission:feeplan.manage']],
        function () {
            Route::get('feemanagement', 'FeeController@getFeePlan')->name('feemanagement.index');
            Route::post('feemanagement/view', 'FeeController@viewFeePlan')->name('feemanagement.view');
            Route::post('getCourseAndCenterName', 'FeeController@getCourseAndCenterName')->name('feePlan.getCourseAndCenterName');
            Route::post('getFeeHeads', 'FeeController@getFeeHeads')->name('feePlan.getFeeHeads');
            Route::post('storeFeePlan', 'FeeController@storeFeePlan')->name('feePlan.storeFeePlan');
            Route::get('feeplan/edit', 'FeeController@edit_feeplan')->name('feePlan.edit');
            Route::post('update', 'FeeController@update_feePlan')->name('feePlan.update_feePlan');
            Route::delete('feePlan/destroy/{id}', 'FeeController@feePlanDestroy')->name('feePlan.destroy');
            Route::get('feePlan/getCoursesByCenter/{center_id}', 'FeeController@getCoursesByCenter')->name('feePlan.getcourses');

        }
    );


    Route::group(
        ['prefix' => 'user'],
        function () {
            Route::get('register', 'Frontend\StudentRegistrationController@createRegister')->name('user.createRegister');
            Route::post('register', 'Frontend\StudentRegistrationController@postRegister')->name('user.postRegister');
            Route::get('create/password/{user_id}', 'Frontend\StudentRegistrationController@showCreatePassword')->name('user.create.password');
            Route::put('store/password/{user_id}', 'Frontend\StudentRegistrationController@updatePassword')->name('user.store.password');

        }
    );

    Route::get(
        'student/email/verify',
        function () {
            return view('auth.student.verify');
        }
    )->name('student.verification.notice')->middleware(['auth', 'student.verified.check']);
    //Student
    Route::group(
        ['middleware' => ['auth', 'student.verified']],
        function () {
            Route::group(
                ['prefix' => 'student', 'middleware' => 'auth'],
                function () {
                        Route::get('edit/{id}', 'Frontend\StudentRegistrationController@editRegister')->name('user.editRegister');
                        Route::get('myaccount', 'Frontend\StudentController@index')->name('user.myaccount');
                        Route::get('mycourse', 'Frontend\StudentController@myCourse')->name('user.mycourse')->middleware('auth');
                        Route::get('paymenthistory', 'Frontend\StudentController@paymentHistory')->name('user.paymentHistory')->middleware('auth');
                        Route::post('orderid-generate', 'PaymentController@orderIdGenerate')->name('orderid.generate')->middleware('auth');
                        Route::post('payment-submit', 'PaymentController@payment')->name('payment-submit')->middleware('auth');
                        Route::post('total-payment-submit', 'PaymentController@totalPaymentSubmit')->name('total-payment-submit')->middleware('auth');
                        Route::get('edit/studentdetails/{student}', 'Frontend\StudentController@editStudentDetails')->name('student.edit.details');
                        Route::put('update/studentdetails/{student}', 'Frontend\StudentController@updateStudentDetails')->name('student.update.details');
                        Route::get('edit/studentAddress/{address}', 'Frontend\StudentController@editStudentAddress')->name('student.edit.address');
                        Route::put('update/studentAddress/{address}', 'Frontend\StudentController@updateStudentAddress')->name('student.update.address');
                        Route::get('edit/studentAcademic/{academic}', 'Frontend\StudentController@editStudentAcademic')->name('student.edit.academic');
                        Route::put('update/studentAcademic/{academic}', 'Frontend\StudentController@updateStudentAcademic')->name('student.update.academic');
                        Route::post('avatar/update', 'Users\AvatarController@update')->name('student.profile.update.avatar');

                        // Academic Route
                        Route::post('add/academic', 'Frontend\StudentController@addStudentAcademics')->name('student.academic.add');
                        Route::put('update/academic/{academic}', 'Frontend\StudentController@updateStudentAcademics')->name('student.academic.update');

                        //Student Courses
                        Route::get('courses', 'Frontend\StudentController@getAvailableCourses')->name('available.courses');

                        //Invoice Route
                        Route::get('payment/invoice/download/{payment_id}', 'InvoiceController@getPaymentInvoice')->name('payment.invoice.download');

                    }
            );
        }
    );
    /* Payment online and offline methods */
    Route::post('razorpaypayment', [PaymentController::class, 'payment'])->name('payment');
    Route::post('offlinepayment', [PaymentController::class, 'offlinePayment'])->name('offlinePayment');
    Route::get('transactions', [PaymentController::class, 'alltransactions'])->name('alltransactions');
    // });

    Route::get('getFeePlan', 'Frontend\StudentRegistrationController@getFeePlan')->name('student.getFeePlan');
    Route::get('getCourse', 'Frontend\StudentRegistrationController@getCourseById')->name('student.getCourseById');

    Route::get('states', 'Frontend\countryStateCity@getStates')->name('states.getStates');
    Route::get('cities', 'Frontend\countryStateCity@getCities')->name('city.getCities');

    Route::get('coursesByCenter', 'Frontend\StudentRegistrationController@getCourseByCenterId')->name('student.getCourseByCenterId');
    Route::get('students', 'StudentController@index')->name('students.index');
    Route::get('students/show/{student}', 'StudentController@show')->name('students.show');
    Route::get('students/edit/{student}', 'StudentController@edit')->name('students.edit');
    Route::delete('students/delete/{student}', 'StudentController@destroy')->name('students.destroy');
    Route::put('students/update/{student}', 'StudentController@update')->name('students.update');
    Route::put('students/loginupdate/{student}', 'StudentController@loginupdate')->name('students.update.login-details');
    Route::put('students/academicupdate/{student}', 'StudentController@academicupdate')->name('students.update.academic');
    Route::put('students/addressupdate/{student}', 'StudentController@addressupdate')->name('students.update.address');


    // Routes for excel file download
    // Route for Error Log on ADMIN
    Route::group(
        ['middleware' => ['auth', 'permission:manage.error.log']],
        function () {

            Route::get('logs', [LoggingController::class, 'show'])->name('log.show');
        }
    );
});

Route::get('downloadExcelFileUrl/{query}/{id?}', 'CommonController@reports')->name('downloadExcelFileUrl');
Route::get('test' , function(){
    return view('test-opt');
});
