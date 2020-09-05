<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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

    /**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }   

    public function handleProviderCallback($provider)
    {
        
        try {
            $user = Socialite::driver($provider)->stateless()->user();
           
        } catch (\Exception $e) {
            return redirect()->to('/login');
        }       
        
        $existingUser = User::where([
            'email'=> $user->email,
            'provider'=>$provider
            ])->first();        
            if($existingUser){
            // log them in
            auth()->login($existingUser, true);
            } else {
                // create a new user
                $newUser                  = new User;
                $newUser->name            = $user->name;
                $newUser->email           = $user->email;
                $newUser->app_id          = $user->id;
                $newUser->avatar          = $user->avatar;
                $newUser->provider        = $provider;
                $newUser->save();            auth()->login($newUser, true);
            }
        return redirect()->to('/home');
    }
    
}
