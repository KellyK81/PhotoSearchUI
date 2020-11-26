<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\AuthenticationRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ApiAuthController extends BaseController
{
    const URI_USER_LOGIN = 'api/user/login';
    const URI_USER_LOGOUT = 'api/user/logout';
    const URI_USER_CREATE = 'api/user/create';
    const URI_USER_RESETPASSWORD = 'api/user/resetpassword';
    const URI_USER_VALIDATE_TOKEN = 'api/user/validate/token';
    const URI_OAUTH_TOKEN = 'oauth/token';


    /**
     * Show the login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm() {
        return view("login.index");
    }

    /**
     * Authenticate against the  API
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AuthenticationRequest $request) {
        try {
            $oauth_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNmY2MjVlY2JkOGVhOGYwODg3ZGU0Nzc5MmRlMDBjZTZjZjZlM2NjMjQ2ODZmNjVjM2QzNTMwZjY3MWI1NWE3ODE1MTgxY2QzNzRlNmQ5MzIiLCJpYXQiOjE2MDU1MzQyOTAsIm5iZiI6MTYwNTUzNDI5MCwiZXhwIjoxNjM3MDcwMjkwLCJzdWIiOiIiLCJzY29wZXMiOltdfQ.Kk7DgNo3rrdH8ZPeN6PscYUc7qJ_KLsMqo5jInksHHEwgakaYm7qO6rcZe-Dp-MG7NCC1dGLMF7lXrbZFBie9WAcB1FyMffl2rA69CgrytHOUsAZaILGUeuv3gTmHW1Un0adc9qQH2iAScJU2C7qpBEvQvzoTCyZDztiEQIL_vEhu9B0CYMtWSYTmC_JhOMXlg_9_uvQMLAdeq2Q_JDoDBuzLcTqulqmN6tsV1crtIKymzindZfGAR426xZB5M1Hw0XD2dOaia4VFEMycW-RT-ASBm8jkJUhgUr--kGFZ1w5VjuKJvqyqbobsj3dNVdDkUeMfT4tRhYXwsnC-NPdCndD7ERb33IUXS_R6GzFcWMa0K1T_Bx5NOUruVSu3Pip-_X7gTIVjb26TXMKT7ywHOUkqWS02y4f2TLohe-KbdW4npZ_2nV2wL0SbI7aHTjI44Sf7JZGL7SYx_50zrf3yWp5GT5ntJLWCzmHrigHqB9azv0TRLjcVRVM2b6hU0X4RI0DCqjlZVNPZ3NfdZa1qfGztV4bPllqWA7p77sbU1D2etYeizQWEy22f2jG7sRmvhJ6JyfHdUORKaziYHxweeM4ZvYjHGHNeGAQo79wkQJeU_f3f4JsvegXlwlerf9Bnk6yApm08tkmUCadEvDirxV8-kgakEwEdX-i4hqN5Q4';

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . session()->get('access_token')
            ])->post(env('APP_API_URL'). self::URI_USER_LOGIN,
            [
                'email' => $request->email,
                'password' => $request->password
            ]);
            
            if ($response->successful() && $response->json()['success']) {
                $user = new User();
                
                $user->email = $request->email;
                $user->id = $response->json()['data']['user_id'];
                
                //Store authenticated and user in session to be checked by authentication middleware
                $request->session()->put('authenticated',true);
                $request->session()->put('user_token',$response->json()['data']['user_token']);
                
                $request->session()->put('user', $user);
            } else if ($response->failed()) { //400 Bad parameters
                return redirect()->back()->withErrors([$response->json()['errors']]);
            }

            $response->throw();
            
        } catch(\GuzzleHttp\Exception\ClientException $ex) {          
            //Remove user and authenticated from session
            $request->session()->forget('authenticated');
            $request->session()->forget('user');
            $request->session()->forget('user_token');
            
            //Redirect back with error
            return redirect()->back()->with('error', 'The credentials do not match our records');
        }
    
        return redirect()->route('home');
    }
    

    /**
     * Log user out
     * @param Request $request 
     * @return type
     */
    public function logout(AuthenticationRequest $request) {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.session()->get('user_token')
            ])->post(env('APP_API_URL'). self::URI_USER_LOGOUT);
        } catch(\GuzzleHttp\Exception\ClientException $ex) {
            Log::info('Unable to logout a user');
            return redirect()->route('home');
        }

        $request->session()->forget('authenticated');
        $request->session()->forget('user_token');
        $request->session()->forget('user');
        return redirect()->route('login');
    }
}
