<?php

namespace App\Services\Impls;

use App\Services\TwitterAPIService;
use App\Utils\DatetimeUtil;
use Auth;
use Twitter;

class TwitterAPIServiceImpl implements TwitterAPIService
{
    /**
     * Fetch Data from Twitter
     */
    public function fetchDataFromTwitter()
    {
        $user = Auth::user();

        $nickname = $user->provider_nickname;

        $query = sprintf("(from:%s OR to:%s) has:links", $nickname, $nickname);

        $params = [
            'tweet.fields' => 'author_id,entities',
            'start_time' => DatetimeUtil::getPastDaysToFetchData(),
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
}