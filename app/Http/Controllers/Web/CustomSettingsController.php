<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Vanguard\Events\Settings\Updated as SettingsUpdated;
use Vanguard\Events\Settings\Created as SettingsCreated;
use Illuminate\Http\Request;
use Vanguard\Repositories\Settings\SettingsRepository;
use Vanguard\Settings;
use Setting;
use Vanguard\Http\Controllers\Controller;

/**
 * Class SettingsController
 * @package Vanguard\Http\Controllers
 */
class SettingsController extends Controller
{
    public function __construct(private SettingsRepository $SettingsRepository )
    {
        $this->middleware('auth');
    }
   
    /**
     * Display general settings page.
     *
     * @return Factory|View
     */
    public function general()
    {   
        $allSettings=$this->SettingsRepository->all()->toArray();
       
        return view('settings.general',[
            'allSettings'=>$allSettings,
        ]);
    }

    /**
     * Display Authentication & Registration settings page.
     *
     * @return Factory|View
     */
    public function auth()
    {
        return view('settings.auth');
    }

    /**
     * Handle application settings update.
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {    
        
        $this->updatesetting($request->except("_token"));

        return back()->withSuccess(__('Settings updated successfully.'));
    }

    /**
     * Update settings and fire appropriate event.
     *
     * @param $input
     */
    private function updatesetting($input)
    {

        $this->SettingsRepository->truncate();
        foreach ($input as $key => $value) {
            $data = array(
                "key" => $key,
                "value" => $value
              );
            $this->SettingsRepository->create($data);
            Setting::set($key, $value);
        }
 
        // Setting::save();
        // echo "<pre>";
        // print_r($input);
        // die();
        // $Settings=new Settings ;
        event(new SettingsUpdated);
    }

    /**
     * Enable system 2FA.
     *
     * @return mixed
     */
    public function enableTwoFactor()
    {
        $this->updatesetting(['2fa.enabled' => true]);

        return back()->withSuccess(__('Two-Factor Authentication enabled successfully.'));
    }

    /**
     * Disable system 2FA.
     *
     * @return mixed
     */
    public function disableTwoFactor()
    {
        $this->updatesetting(['2fa.enabled' => false]);

        return back()->withSuccess(__('Two-Factor Authentication disabled successfully.'));
    }

    /**
     * Enable registration captcha.
     *
     * @return mixed
     */
    public function enableCaptcha()
    {
        $this->updatesetting(['registration.captcha.enabled' => true]);

        return back()->withSuccess(__('reCAPTCHA enabled successfully.'));
    }

    /**
     * Disable registration captcha.
     *
     * @return mixed
     */
    public function disableCaptcha()
    {
        $this->updatesetting(['registration.captcha.enabled' => false]);

        return back()->withSuccess(__('reCAPTCHA disabled successfully.'));
    }

    /**
     * Display notification settings page.
     *
     * @return Factory|View
     */
    public function notifications()
    {
        return view('settings.notifications');
    }
}
