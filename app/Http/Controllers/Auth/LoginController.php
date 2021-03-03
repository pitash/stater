<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        // return $user->getEmail();
        // Find existing user.
        $existingUser = User::whereEmail($user->getEmail())->first();
        if ($existingUser)
        {
            Auth::login($existingUser);
        } else {
            // Create new user.
            $newUser = User::create([
                'role_id' => Role::where('slug','user')->first()->id,
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'status' => true
            ]);
            // upload images
            if ($user->getAvatar()) {
                $newUser->addMediaFromUrl($user->getAvatar())->toMediaCollection('avatar');
            }
            Auth::login($newUser);
        }
        // notify()->success('You have successfully logged in with '.ucfirst($provider).'!','Success');
        return redirect($this->redirectPath());
    }
}
