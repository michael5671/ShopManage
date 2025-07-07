<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = User::create([
            "name" => $request->name,

            "password" => Hash::make($request->password),
        ]);

        return response()->json($user);
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->scopes(['public_profile'])->user();
        $avatar = "https://graph.facebook.com/{$fbUser->getId()}/picture?type=large&access_token={$fbUser->token}";
        $user = User::updateOrCreate([
            'facebook_id' => $fbUser->getId(),
        ], [
            'name' => $fbUser->getName(),
            'password' => Hash::make(Str::random(16)),
            'avatar' => $fbUser->getAvatar(),
        ]);
        dd($fbUser);

        // Return user info for testing
        return response()->json($fbUser);
    }
}
