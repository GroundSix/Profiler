<?php

namespace GroundSix\Component\Providers\Laravel;
use Illuminate\Support\ServiceProvider;

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