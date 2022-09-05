<?php

namespace App\Services;

interface TweetService
{
    /**
     * Refresh data in DB with new data from Twitter
     */
    public function refreshTweetData(array $data);
}
