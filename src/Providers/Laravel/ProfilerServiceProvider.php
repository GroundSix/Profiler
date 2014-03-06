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

use Illuminate\Support\ServiceProvider;

/**
 * Class ProfilerServiceProvider
 *
 * @package GroundSix\Component\Providers\Laravel
 */
class ProfilerServiceProvider extends ServiceProfider
{
    public function register()
    {
        $this->app->singleton('groundsix.profiler', function () {
            return new \GroundSix\Component\StatsProfiler;
        });
        $monolog = \Log::getMonolog();
        $this->app['groundsix.profiler']->setLogger($monolog);
        $this->app['groundsix.profiler']->push("Provider registered");
    }

    public function provides()
    {
        return array('groundsix.profiler');
    }
}
