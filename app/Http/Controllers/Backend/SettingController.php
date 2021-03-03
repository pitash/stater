<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateMailSettingsRequest;

class SettingController extends Controller
{
    public function general()
    {
        return view('backend.settings.general');
    }

    /**
     * Update General Settings
     * @param UpdateGeneralSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generalUpdate(Request $request)
    {
        $request->validate([
            'site_title'=> 'required|string|min:2|max:255',
            'site_description'=> 'required|string|min:2|max:255',
            'site_address'=> 'required|string|min:2|max:255'
          ]);

        // Setting::updateSettings($request->validated());
        Setting::updateOrCreate(['name'=>'site_title'],['value' => $request->get('site_title')]);
        Setting::updateOrCreate(['name'=>'site_description'],['value' => $request->get('site_description')]);
        Setting::updateOrCreate(['name'=>'site_address'],['value' => $request->get('site_address')]);
        // Update .env file
        Artisan::call("env:set APP_NAME='". $request->site_title ."'");
        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }

    /**
     * Show Appearance Settings Page
     * @return \Illuminate\View\View
     */
    public function appearance()
    {
        return view('backend.settings.appearance');
    }

    /**
     * Update Appearance
     * @param UpdateAppearanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function appearanceUpdate(Request $request)
    {
        $request->validate([
            'site_logo'=> 'nullable|image',
            'site_favicon'=> 'nullable|image'
          ]);


        if ($request->hasFile('site_logo')) {
            $this->deleteOldLogo(config('settings.site_logo'));
            // Setting::set('site_logo',Storage::disk('public')->putFile('logos', $request->file('site_logo')));
            Setting::updateOrCreate(
                ['name' => 'site_logo'],
                [
                    'value' => Storage::disk('public')->putFile('logos', $request->file('site_logo'))
                ]
            );
        }
        if ($request->hasFile('site_favicon')) {
            $this->deleteOldLogo(config('settings.site_favicon'));
            // Setting::set('site_favicon', Storage::disk('public')->putFile('logos', $request->file('site_favicon')));
            Setting::updateOrCreate(
                ['name' => 'site_favicon'],
                [
                    'value' => Storage::disk('public')->putFile('logos', $request->file('site_favicon'))
                ]
            );
        }
        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }

    /**
     * Delete old logos from storage
     * @param $path
     */
    private function deleteOldLogo($path)
    {
        Storage::disk('public')->delete($path);
    }

    /**
     * Show Mail Settings Page
     * @return \Illuminate\View\View
     */
    public function mail()
    {
        return view('backend.settings.mail');
    }

    /**
     * Update Mail Settings
     * @param UpdateMailSettingsRequest $request
     */
    public function mailUpdate(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'string|max:255',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|max:255',
            'mail_encryption' => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255'
          ]);

        // Update .env mail settings
        Setting::updateOrCreate(['name'=>'mail_mailer'], ['value' => $request->get('mail_mailer')]);
        Artisan::call("env:set MAIL_MAILER='". $request->mail_mailer ."'");

        Setting::updateOrCreate(['name'=>'mail_host'], ['value' => $request->get('mail_host')]);
        Artisan::call("env:set MAIL_HOST='". $request->mail_host ."'");

        Setting::updateOrCreate(['name'=>'mail_port'], ['value' => $request->get('mail_port')]);
        Artisan::call("env:set MAIL_PORT='". $request->mail_port ."'");

        Setting::updateOrCreate(['name'=>'mail_username'], ['value' => $request->get('mail_username')]);
        Artisan::call("env:set MAIL_USERNAME='". $request->mail_username ."'");

        Setting::updateOrCreate(['name'=>'mail_password'], ['value' => $request->get('mail_password')]);
        Artisan::call("env:set MAIL_PASSWORD='". $request->mail_password ."'");

        Setting::updateOrCreate(['name'=>'mail_encryption'], ['value' => $request->get('mail_encryption')]);
        Artisan::call("env:set MAIL_ENCRYPTION='". $request->mail_encryption ."'");

        Setting::updateOrCreate(['name'=>'mail_from_address'], ['value' => $request->get('mail_from_address')]);
        Artisan::call("env:set MAIL_FROM_ADDRESS='". $request->mail_from_address ."'");

        Setting::updateOrCreate(['name'=>'mail_from_name'], ['value' => $request->get('mail_from_name')]);
        Artisan::call("env:set MAIL_FROM_NAME='". $request->mail_from_name ."'");

        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }

    /**
     * Show Socialite Settings Page
     * @return \Illuminate\View\View
     */
    public function socialite()
    {
        return view('backend.settings.socialite');
    }

    /**
     * Update Socialite Settings
     *
     * @param UpdateSocialiteSettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialiteUpdate(Request $request)
    {
        $request->validate([
            'google_client_id' => 'string|nullable',
            'google_client_secret' => 'string|nullable',

            'github_client_id' => 'string|nullable',
            'github_client_secret' => 'string|nullable'
          ]);

        // Update .env file
        // Artisan::call("env:set FACEBOOK_CLIENT_ID='". $request->facebook_client_id ."'");
        // Artisan::call("env:set FACEBOOK_CLIENT_SECRET='". $request->facebook_client_secret ."'");
            
        //Google
        Setting::updateOrCreate(['name'=>'google_client_id'], ['value' => $request->get('google_client_id')]);
        Artisan::call("env:set GOOGLE_CLIENT_ID='". $request->google_client_id ."'");
        
        Setting::updateOrCreate(['name'=>'google_client_secret'], ['value' => $request->get('google_client_secret')]);
        Artisan::call("env:set GOOGLE_CLIENT_SECRET='". $request->google_client_secret ."'");

        //Github
        Setting::updateOrCreate(['name'=>'github_client_id'], ['value' => $request->get('github_client_id')]);
        Artisan::call("env:set GITHUB_CLIENT_ID='". $request->github_client_id ."'");
        
        Setting::updateOrCreate(['name'=>'github_client_secret'], ['value' => $request->get('github_client_secret')]);
        Artisan::call("env:set GITHUB_CLIENT_SECRET='". $request->github_client_secret ."'");

        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }
}
