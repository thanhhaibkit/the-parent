<?php

namespace App\Services;

use App\Models\User;

interface UserService
{
    /**
     * @param  $socialUser Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateSocialUser($socialUser, $provider) : User;
}