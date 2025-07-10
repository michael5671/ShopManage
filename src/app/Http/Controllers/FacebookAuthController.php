<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\News;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
class FacebookAuthController extends Controller
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
        try {
            $fbUser = Socialite::driver('facebook')->user();
            $avatar = "https://graph.facebook.com/{$fbUser->getId()}/picture?type=normal&access_token={$fbUser->token}";

            $existingUser = User::where('facebook_id', $fbUser->id)->first();

            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->intended('home');
            } else {

                $user = User::create([
                    'facebook_id' => $fbUser->getId(),
                    'name' => $fbUser->getName(),
                    'password' => Hash::make(Str::random(16)),
                    'avatar' => $avatar,
                ]);
                Auth::login($user);
                return redirect()->intended('home');
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function shareToFacebook($id)
    {
        
        $news = News::findOrFail($id);
        $user = Auth::user();

        $postUrl = $news->post_url;
        dd($postUrl);
        $thumbnailResult = Cloudinary::upload($postUrl);
        $thumbnailPublicId = $thumbnailResult->getPublicId();

        $avatarResult = Cloudinary::upload($user->avatar);
        $avatarPublicId = $avatarResult->getPublicId();

        $mergedImageUrl = Cloudinary::cloudinary_url($thumbnailPublicId, [
            'transformation' => [
                [ 'width'=>1200, 'height'=>630, 'crop'=>'fill' ,
                    ['overlay'=> $avatarPublicId,
                    'width' => 100,
                    'height'=>100,
                    'gravity' => 'south_east',
                    'x' => 20,
                    'y' => 20
                    ]
                ]
            ]
        ]);

        $shareURL = route('news.share', ['id' => $news->id]);
        
        $hashtags = urlencode("#30thang4 #tuhaovietnam #giaiphongmiennam #tonvinhquehuong #lantoaniemtuhaoquehuong");

        // Redirect user tới Facebook Share Dialog
        return redirect("https://www.facebook.com/sharer/sharer.php?u={$shareURL}&hashtag={$hashtags}&display=popup");
    }
}
