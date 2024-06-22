<?php

namespace NickDeKruijk\LaravelVisitors;

class Visitors
{
    public static function isVisitor(): bool
    {
        $agent = new Agent();
        return !$agent->isRobot();
    }
}
