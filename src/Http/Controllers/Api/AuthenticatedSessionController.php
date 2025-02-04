<?php

namespace Newnet\Customer\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newnet\Customer\Http\Requests\Api\LoginRequest as ApiLoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(ApiLoginRequest $request)
    {
        $token_name = $request->token_name ?: 'api';

        $request->authenticate();

        $customer = $request->user('customer');

        if (config('cms.customer.api.revoke_old_token')) {
            $customer->tokens()->where('name', $token_name)->delete();
        }

        $token = $customer->createToken($token_name);

        return [
            'token' => $token->plainTextToken,
        ];
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $customer = $request->user();
        $customer->currentAccessToken()->delete();

        return [
            'success' => true,
        ];
    }
}
