<?php

/**
 * Ground Six Profiler
 *
 * @author Andrew Willis  twitter.com/ilovefluffy
 * @author Harry Lawrence twitter.com/harry4_
 *
 * (c) Ground Six 2014
 *
 * License: MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GroundSix\Component\Providers\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * Class StatsProfiler
 *
 * @package GroundSix\Component\Providers\Laravel
 */
class StatsProfiler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'groundsix.profiler';
    }
}
