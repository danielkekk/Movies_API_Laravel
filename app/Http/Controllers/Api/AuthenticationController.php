<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthenticationController extends Controller
{
    /**
    * Handle an incoming authentication request.
    */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = User::find(Auth::user()->id);

            $token = $user->createToken('appToken');

            return response()->json([
                'success' => true,
                'token' => $token->accessToken,
                'expires_at' => Carbon::parse($token->token->expires_at)->format('Y-m-d H:i:s'),
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }

    /**
   * Destroy an authenticated session.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Request $request)
  {
      if (Auth::user()) {
          $request->user()->token()->revoke();

          return response()->json([
              'success' => true,
              'message' => 'Logged out successfully',
          ], 200);
      }
  }
}
