<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SearchController extends BaseController
{
    const URI_SEARCH = 'api/search/photos';

    public function search(Request $request) {
        $user_id = 0;
        if (session()->get('authenticated')) {
            $user = session()->get('user');
            $user_id = $user->id;
            Log::debug($user_id);
        }
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . session()->get('access_token')
        ])->post(env('APP_API_URL'). self::URI_SEARCH,
        [
            'search_text' => $request->search_text,
            'per_page' => 350,
            'user_id' => $user_id
        ]);

        return view('search.index')->with(['data' => $response->json()['data']]);
    }
}