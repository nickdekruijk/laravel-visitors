<?php

namespace NickDeKruijk\LaravelVisitors;

class Visitors
{
    /**
     * Anonymizes the given IP address by applying a bitmask to it.
     *
     * @param string $ip The IP address to be anonymized.
     * @return string The anonymized IP address.
     */
    public static function anonymize_ip(string $ip): string
    {
        return inet_ntop(inet_pton($ip) & inet_pton("255.255.255.0"));
    }
}
