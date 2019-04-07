<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OAuthProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\EmailTakenException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    public function __contruct()
    {
        config([
            'services.facebook.redirect' => route('oauth.callback', 'facebook'),
            'services.github.redirect' => route('oauth.callback', 'github'),
            'services.twitter.redirect' => route('oauth.callback', 'twitter'),
        ]);
    }
    
    public function redirectToProvider($provider)
    {
        try {
            return [
                //'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
                'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
            ];
        } catch (\InvalidArgumentException $e) {
            return [
                'error' => 'error for authenticated',
            ];
        }

    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $user = $this->findOrCreateUser($provider, $user);

        $this->guard()->settoken(
            $token = $this->guard()->login($user)
        );
        return view('oauth/callback',[
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ]);

    }

    protected function findOrCreateUser($provider, $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
                                        ->where('provider_user_id', $user->getId())
                                        ->first();
        if ($oauthProvider) {
            $oauthProvider->update([
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]);
            return $oauthProvider->user;
        }

        if (User::where('email', $user->getEmail())->exists()) {
            throw new EmailTakenException();
            
        }

        return $this->createUser($provider, $user);

    }

    protected function createUser($provider, $socialUser)
    {
        $user = User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $socialUser->getId(),
            'access_token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
        ]);

        return $user;
    }
}
