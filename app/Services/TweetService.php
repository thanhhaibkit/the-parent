<?php

namespace App\Services;

use Auth;
use App\Models\Tweet;
use App\Models\TweetMostDomain;
use App\Models\TweetMostUser;
use App\Utils\UrlUtil;
use Exception;
use Illuminate\Support\Facades\DB;
use Twitter;

class TweetService
{
    /**
     * Fetch Data from Twitter
     */
    public function fetchDataFromTwitter()
    {
        $user = Auth::user();

        $query = sprintf("from:%s has:links", $user->provider_nickname);

        $params = [
            'tweet.fields' => 'author_id,entities',
            'response_format' => 'array'
        ];

        $result = Twitter::searchRecent(
            $query,
            $params
        );

        $data = $result['data'];

        // Check next token for paging case
        $nextToken = isset($result['meta']['next_token']) ? $result['meta']['next_token'] : null;
        while ($nextToken) {
            $nextResult = Twitter::searchRecent(
                $query,
                array_merge($params, ['next_token' => $nextToken])
            );

            $data = array_merge($data, $nextResult['data']);

            $nextToken = isset($nextResult['meta']['next_token']) ? $nextResult['meta']['next_token'] : null;
        }

        return $data;
    }

    /**
     * Refresh data in DB with new data from Twitter
     */
    public function refreshTweetData($data)
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
                Tweet::create([
                    'tweet_id' => $tweet['id'],
                    'author_nickname' => $tweet['author_id'],
                    'text' => $tweet['text'],
                ]);

                $urls = $tweet['entities']['urls'];
                foreach ($urls as $url) {
                    // Update the count number of domain
                    $domain = UrlUtil::getUrlDomain($url['display_url']);
                    if ($domain) {
                        $domains[$domain] = isset($domains[$domain]) ? $domains[$domain] + 1 : 1;
                    }

                    // Update the count number of (most) user
                    $mostUsers[$tweet['author_id']] = isset($mostUsers[$tweet['author_id']]) ? $mostUsers[$tweet['author_id']] + 1 : 1;
                }
            }

            foreach ($mostUsers as $key => $value) {
                TweetMostUser::create([
                    'user_id' => $key,
                    'nickname' => $key,
                    'count' => $value
                ]);
            }

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
