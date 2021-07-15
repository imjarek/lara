<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));
        $query = http_build_query([
            'client_id' => env('CLIENT_ID'),
            'redirect_uri' => env('APP_URL') . '/auth/callback',
            'response_type' => 'code',
            'scope' => 'openid profile email phone address',
            'state' => $state,
        ]);

        return redirect(env('AUTH_API_CODE_ENDPOINT') . '?' . $query, '302');
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

//        throw_unless(
//            strlen($state) > 0 && $state === $request->get('state'),
//            InvalidArgumentException::class
//        );

        $response = $this->client->post(env('AUTH_API_TOKEN_ENDPOINT'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'redirect_uri' => env('APP_URL') . '/auth/callback',
                'code' => $request->get('code'),
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return $data;
    }

    public function refresh(Request $request)
    {
        $this->client = new GuzzleHttp\Client;

        throw_unless(
            $request->get('refresh_token'),
            InvalidArgumentException::class
        );

        $response = $this->client->post(env('AUTH_API_TOKEN_ENDPOINT'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->get('refresh_token'),
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function password(Request $request)
    {
        $http = new GuzzleHttp\Client;

        $response = $http->post(env('AUTH_API_TOKEN_ENDPOINT'), [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'username' => 'test@mail.com',
                'password' => 'pass',
                'scope' => '*',
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    }
}
