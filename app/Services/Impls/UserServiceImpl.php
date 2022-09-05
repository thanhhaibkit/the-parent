<?php

namespace App\Services\Impls;

use App\Models\User;
use App\Services\UserService;

class UserServiceImpl implements UserService
{

    /**
     * @param  $socialUser Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateSocialUser($socialUser, $provider) : User
    {
        $user = User::where('provider_id', $socialUser->id)->first();

        if ($user) {
            return $user;
        }

        return User::create([
            'name'     => $socialUser->name,
            'email'    => $socialUser->email,
            'provider' => $provider,
            'provider_id' => $socialUser->id,
            'provider_nickname' => $socialUser->nickname
        ]);
    }
}