<?php

namespace NickDeKruijk\LaravelVisitors;

use Jenssegers\Agent\Agent;
use NickDeKruijk\LaravelVisitors\Models\Visitor;

class Visitors
{
    /**
     * Check if the visitor is not a robot
     *
     * @return boolean
     */
    public static function isVisitor(): bool
    {
        $agent = new Agent();
        return !$agent->isRobot();
    }

    /**
     * Check if the visitor is already tracked
     *
     * Returns true for new visitors so additional javascript may be loaded
     * For tracked visitors the pagecount is increased
     * 
     * @return boolean
     */
    public static function firstHit(): bool
    {
        if (self::isVisitor()) {
            if (!session('visitors.id')) {
                return true;
            } else {
                $visitor = Visitor::find(session('visitors.id'));
                if ($visitor) {
                    // Update visitor pagecount
                    $visitor->pageviews += 1;
                    $visitor->save();
                } else {
                    return true;
                }
            }
        }
        return false;
    }
}
