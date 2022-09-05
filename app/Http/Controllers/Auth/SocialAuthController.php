<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Auth, Socialite;

class SocialAuthController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }
    /**
     * Redirect to OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }  

    /**
     * Get info from Provider and create new user 
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $authUser = $this->userService->findOrCreateSocialUser($socialUser, $provider);
        Auth::login($authUser, true);
        
        return redirect()->route('display');
    }
}
