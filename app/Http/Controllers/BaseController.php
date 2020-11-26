<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    const URI_OAUTH_TOKEN = 'oauth/token';

    public function __construct() {
        // Check if the APP has oauth_token
        if (!session()->get('oauth_token')) {
            Log::debug('Calling an API to get a new Access token');
            // Acquire a new token to be used by subsequent API calls
            $response = Http::post(env('APP_API_URL'). self::URI_OAUTH_TOKEN,
            [
                'grant_type' => 'client_credentials',
                'client_id' => env('APP_API_CLIENT_ID'),
                'client_secret' => env('APP_API_CLIENT_SECRET')
            ]);

            if ($response->successful()) {
                $access_token = $response->json()['access_token'];
                session()->put('access_token', $access_token);
                Log::debug('Received new Access token');
            } else {
                Log::debug('Unable to authenticate the Application.');
            }
        }
    }
}