<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccount;
use App\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use League\Flysystem\Exception;

use Google_Client;
use Google_Service_People;


class SocialAccountController extends Controller
{
    public function redirectToProvider($provider)
    {

        //return Socialite::driver($provider)->redirect();

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try
        {
            $user = Socialite::driver($provider)->stateless()->user();
        }
        catch (Exception $e)
        {
            session()->put('error','something wrong due Socialite');
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user,$provider);
        auth()->login($authUser,true);
        return redirect('/home');
    }

    public function findOrCreateUser($socialUser,$provider)
    {
        $account = SocialAccount::where('provider_name',$provider)
                                ->where('provider_id',$socialUser->getId())
                                ->first();

        if($account)
        {
            //user has loged in before by his social account
            return $account->user;
        }
        else
        {
            //user has account
            $user = User::where('email',$socialUser->getEmail())
                        -> first();

            //user has not account and not loged in before by social account
            if(!$user)
            {
                $user = User::create([
                    'email' => $socialUser->getEmail(),
                    'name'  => $socialUser->getName(),
                    'password' => ""
                ]);
            }


            $user->accounts()->create([
                'provider_name' => $provider,
                'provider_id'   => $socialUser->getId(),
            ]);

            return $user;
        }
    }
}
