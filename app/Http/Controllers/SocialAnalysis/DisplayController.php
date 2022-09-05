<?php

namespace App\Http\Controllers\SocialAnalysis;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\TweetMostDomain;
use App\Models\TweetMostUser;
use App\Services\TweetService;
use App\Services\TwitterAPIService;

class DisplayController extends Controller
{
    private $tweetService;
    private $twitterAPIService;

    public function __construct(
        TweetService $tweetService,
        TwitterAPIService $twitterAPIService
    ) {
        $this->tweetService = $tweetService;
        $this->twitterAPIService = $twitterAPIService;
    }


    public function display()
    {
        $tweets = Tweet::all();
        $mostUser = TweetMostUser::orderBy('count','desc')->first();
        $mostDomains = TweetMostDomain::orderByDesc('count')->limit(3)->get();

        return view('tweets/display', compact('tweets', 'mostUser', 'mostDomains'));
    }

    public function refresh()
    {
        $data = $this->twitterAPIService->fetchDataFromTwitter();

        $this->tweetService->refreshTweetData($data);
        
        return redirect()->route('display');
    }
}