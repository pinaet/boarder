<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
                if( env('LDAP_SKIP')==true )
                    $b = true;
                else
                    $b = @ldap_bind($ad, $email, $pass);

                $pass = Str::random(32);

                if($b) {
                    $getAccess   = false;
                    $staff       = (new Staff)->getCurrentStaff();
                    foreach( $staff as $person ){
                        if( $person->Email==$email ){
                            $getAccess   = true;
                            break;
                        }
                    }

                    if(!$getAccess){

                        $sql = "select user_id from OSUser where user_id = '".$username."';";
                        $rows = DB::connection('staff-portal-bk')->select( $sql );

                        if( count( $rows ) > 0){
                            $getAccess = true;
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

                        if( $user )
                        {
                            $session_info['user']=$username;
                            $session_info['current_user'] = $username;
                            $session_info['user_role']=$user->user_role;
                            $session_info['user_name']= $user->username;
                            $session_info['password']= bcrypt( $pass );
                            $session_info['last_login']= date('M d Y g:i A');
                            Session::put($session_info);
                            Auth::login( $user );
                        }
                        else {
                            request()['email']    = $email;
                            request()['username'] = $username;
                            request()['password'] = bcrypt( $pass );

                            $session_info['user']=$username;
                            $session_info['current_user'] = $username;
                            $session_info['user_role']='';
                            $session_info['user_name']= $username;
                            $session_info['password']= bcrypt( $pass );
                            $session_info['last_login']= date('M d Y g:i A');
                            Auth::login( $user = User::create(request()->all()) );
                            Session::put($session_info);
                        }

                        if( session()->has( 'url.intended' ) )
                        {
                            $intended_url =  session('url.intended' );
                            session()->forget( 'url.intended' );

                            $base_url     =  url('/');
                            $sub_url      =  substr( $intended_url, 0, strlen($base_url) );

                            if( $base_url==$sub_url ){
                                return redirect( $intended_url );
                            }
                        }

                        return redirect('home');

                    }else{
                        $message = "
                        Sorry, you don't have permission. Please contact ICT!!!
                        ";

                        return view( 'login_error', [
                            'message' => $message,
                            'username' => $username
                        ] );
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
                Connect not connect to {$server}
                ";

                return view( 'login_error', compact('message') );
            }
        }else{
            $message = "
            You neglected to fill out the
            <b><font color='red' >Username</font></b> or
            <b><font color='red' >Password</font></b> <br>
            Please use the back button to fill in reqired info.
            ";

            return view( 'login_error', compact('message') );
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
