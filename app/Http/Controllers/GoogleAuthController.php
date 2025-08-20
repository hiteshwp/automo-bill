<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // Ask for offline access (refresh token) and explicit consent once
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/calendar.events',
                // or 'https://www.googleapis.com/auth/calendar' if you want full control + Meet
            ])
            ->with([
                'access_type' => 'offline',        // get refresh token
                'prompt'      => 'consent',        // force refresh token on first grant
                'include_granted_scopes' => 'true',
            ])
            ->redirect();
    }

    public function callback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = $request->user();
        $user->google_id = $googleUser->getId();

        // Socialite::user()->token is access token; refreshToken may be null if not granted again
        $user->google_refresh_token = $googleUser->refreshToken ?? $user->google_refresh_token;

        // Store the whole token payload for convenience (access_token, expires_in, etc.)
        $tokenPayload = [
            'access_token' => $googleUser->token,
            'expires_in'   => $googleUser->expiresIn,
            'created'      => time(),
        ];
        $user->google_json_string = json_encode($googleUser);
        $user->google_token = json_encode($tokenPayload);
        $user->google_token_expires_at = now()->addSeconds((int)($googleUser->expiresIn ?? 3600));
        $user->save();

        return redirect()->intended('/settings/view')->with('status', 'Google connected successfully.');
    }

    public function disconnect(Request $request)
    {
        $user = $request->user();

        // Optionally revoke token with Google; safe to just clear locally
        $user->google_id = null;
        $user->google_token = null;
        $user->google_refresh_token = null;
        $user->google_token_expires_at = null;
        $user->save();

        return back()->with('success', 'Disconnected from Google.');
    }
}
