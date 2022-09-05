<?php

namespace App\Services\Impls;

use App\Models\Tweet;
use App\Models\TweetMostDomain;
use App\Models\TweetMostUser;
use App\Services\TweetService;
use App\Utils\UrlUtil;
use Exception;
use Illuminate\Support\Facades\DB;

class TweetServiceImpl implements TweetService
{
    /**
     * Refresh data in DB with new data from Twitter
     */
    public function refreshTweetData(array $data)
    {
        DB::beginTransaction();

        try {
            $domains = [];
            $mostUsers = [];

            // truncate db
            Tweet::getQuery()->delete();
            TweetMostUser::getQuery()->delete();
            TweetMostDomain::getQuery()->delete();

            foreach ($data as $tweet) {
                $authorId = $tweet['author_id'];
                Tweet::create([
                    'tweet_id' => $tweet['id'],
                    'author_id' => $authorId,
                    'text' => $tweet['text'],
                ]);

                $urls = isset($tweet['entities']['urls']) ? $tweet['entities']['urls'] : null;
                foreach ($urls as $url) {
                    // Update the count number of domain
                    $domain = UrlUtil::getUrlDomain($url['display_url']);
                    if ($domain) {
                        $domains[$domain] = isset($domains[$domain]) ? $domains[$domain] + 1 : 1;
                    }

                    // Update the count number of (most) user
                    $mostUsers[$authorId] = isset($mostUsers[$authorId]) ? $mostUsers[$authorId] + 1 : 1;
                }
            }

            // Insert most user
            foreach ($mostUsers as $key => $value) {
                TweetMostUser::create([
                    'user_id' => $key,
                    'count' => $value
                ]);
            }

            // Insert most domains
            foreach ($domains as $key => $value) {
                TweetMostDomain::create([
                    'domain' => $key,
                    'count' => $value
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
