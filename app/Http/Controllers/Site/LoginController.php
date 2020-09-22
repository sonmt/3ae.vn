<?php

namespace App\Http\Controllers\Site;

use App\Entity\Post;
use App\Entity\User;
use App\Mail\Mail;
use App\Ultility\Facebook;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends SiteController
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            'required' => 'Trường :attribute không được để trống'
        ]);
    }

    public function callbackLogin(Request $request) {
        $app = new Facebook();

        $fb = new \Facebook\Facebook([
            'app_id' => $app->getAppId(),
            'app_secret' => $app->getAppSecret(),
            'default_graph_version' => $app->getDefaultGraphVersion()
        ]);

        $helper = $fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $accessToken = $helper->getAccessToken();
            $response = $fb->get('/me', $accessToken);
            $userFacebook = $response->getDecodedBody();
            $user = User::where('email', $userFacebook['id'].'@kidandmom.com')->first();
            if (!empty($user)) {
                Auth::login($user);

                return redirect(URL::to('/'));
            }

            $user = new User();
            $user->insert([
                'name' => $userFacebook['name'],
                'role' => 1,
                'email' => $userFacebook['id'].'@kidandmom.com',
                'password' => bcrypt($userFacebook['id'].$userFacebook['name']),
                'remember_token' => str_random(10),
            ]);

            $userNew = User::where('email', $userFacebook['id'].'@kidandmom.com')->first();
            Auth::login($userNew);

            return redirect(URL::to('/'));

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        $userGoogle = Socialite::driver('google')->user();

        $user = User::where('email',  $userGoogle->getEmail())->first();
        if (!empty($user)) {
            Auth::login($user);

            return redirect(URL::to('/'));
        }

        $user = new User();
        $user->insert([
            'name' => $userGoogle->getName(),
            'role' => 1,
            'email' => $userGoogle->getEmail(),
            'password' => bcrypt(str_random(10)),
            'remember_token' => str_random(10),
        ]);

        $userNew = User::where('email', $userGoogle->getEmail())->first();
        Auth::login($userNew);

        return redirect(URL::to('/'));
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
    
}
