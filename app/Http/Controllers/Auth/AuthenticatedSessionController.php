<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Models\AllowedUser;
use App\Models\BlockedUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // LoginRequest $request
        // $request->authenticate();
        // $request->session()->regenerate();
        // dd($request, $request->email, $request->password);

        $email = strtolower( trim( request('email') ) );
        $pass  = trim( request('password'));

        if (strpos($email, '@') === false) {
            $email.=env('USER_DOMAIN');
        }

        $position = strpos($email, "@");
        $username = substr($email, 0, $position);// dd( request('email') );

        if($email != null && $pass != null){

            $server = env('LDAP_IP','203.156.141.222');

            // connect to active directory
            if( env('LDAP_SKIP')==true )
                $ad = true;
            else
                $ad = ldap_connect($server);
                
            if($ad) {
                if( env('LDAP_SKIP',false)==true )
                    $b = true;
                else
                    $b = @ldap_bind($ad, $email, $pass);

                $pass = Str::random(32);

                if($b) {
                    $getAccess   = false;

                    /*
                    * check if user has any permission
                    */
                    $user = User::where('email',$email)->get();
                    foreach( $user as $dat ){
                        $user = $dat;
                    }
                    if( count($user->role)>0 ){
                        $getAccess   = true;
                    }

                    /*
                    * check if user is blocked from access
                    */
                    $blocked_users   = BlockedUser::all();
                    foreach( $blocked_users as $person ){
                        if( $person->email==$email ){
                            $getAccess   = false;
                            break;
                        }
                    }

                    if( $getAccess ){
                        //create user
                        $user = User::where('username', $username)->first();
                        if (!$user) {
                            $user = User::where('email', $email)->first();
                            if ($user) {
                                $user->username = $username;
                                $user->save();
                            }
                        }

                        if( !$user )
                        {
                            request()['email']    = $email;
                            request()['username'] = $username;
                            request()['password'] = bcrypt( $pass );
                            $user = User::create(request()->all());
                        }

                        Auth::login( $user );

                        return redirect()->intended(RouteServiceProvider::HOME);
                    }
                    else
                    {
                        $message = "
                        Sorry, you don't have permission. Please contact ICT!!!
                        ";

                        return Inertia::render('Login/Error', [
                            'title' => 'Login Error',
                            'message' => $message ,
                            'url' => url('/login'),
                            'type' => 'danger'
                        ]);
                    }

                } else {
                    $message = "
                    Unrecognized username or password !!!
                    ";

                    return Inertia::render('Login/Error', [
                        'title' => 'Login Error',
                        'message' => $message ,
                        'url' => url('/login'),
                        'type' => 'danger'
                    ]);
                }
            } else {
                $message = "
                Connect not connect to {$server}...
                ";

                return Inertia::render('Login/Error', [
                    'title' => 'Login Error',
                    'message' => $message ,
                    'url' => url('/login'),
                    'type' => 'danger'
                ]);
            }
        }else{
            $message = "
            You neglected to fill out the Username or Password...
            ";

            return Inertia::render('Login/Error', [
                'title' => 'Login Error',
                'message' => $message ,
                'url' => url('/login'),
                'type' => 'danger'
            ]);
        }


        //get user

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        return redirect( url('/').'/' );
    }
}
