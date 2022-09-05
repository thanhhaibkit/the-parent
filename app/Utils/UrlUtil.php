<?php

namespace App\Utils;

class UrlUtil
{
    public static function getUrlDomain(string $url) : string
    {
        $pieces = parse_url($url);
        $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];

        return str_ireplace('/', '', $domain);
    }
}