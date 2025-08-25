<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Google
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Handle avatar (download & store locally)
        $avatarPath = $this->storeAvatar($googleUser->getAvatar());

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'user_profile_pic' => $avatarPath,
                'password' => bcrypt(str()->random(16)), // dummy password
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard')
            ->with('status', 'Welcome back, ' . Auth::user()->name . '!');
    }

    // Facebook
    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook()
    {
        $fbUser = Socialite::driver('facebook')->stateless()->user();

        // Handle avatar (download & store locally)
        $avatarPath = $this->storeAvatar($fbUser->getAvatar());

        $user = User::updateOrCreate(
            ['email' => $fbUser->getEmail()],
            [
                'name' => $fbUser->getName(),
                'facebook_id' => $fbUser->getId(),
                'user_profile_pic'=> $avatarPath,
                'password' => bcrypt(str()->random(16)),
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard')
            ->with('status', 'Welcome back, ' . Auth::user()->name . '!');
    }

    /**
     * Store avatar locally instead of keeping social URL
     */
    private function storeAvatar($avatarUrl)
    {
        if (!$avatarUrl) {
        return 'uploads/profiles/garage-owner/default-avatar.png';
        }

        try {
            $avatarContents = file_get_contents($avatarUrl);

            // Ensure the folder exists
            $uploadPath = public_path('uploads/profiles/garage-owner');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $avatarName = uniqid() . '.jpg';

            // Save file in public/uploads/profiles/garage-owner
            file_put_contents($uploadPath . '/' . $avatarName, $avatarContents);

            // Return relative path to store in DB
            return $avatarName;

        } catch (\Exception $e) {
            return 'uploads/profiles/garage-owner/default-avatar.png';
        }
    }
}
