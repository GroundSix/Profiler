<?php

namespace GroundSix\Component\Providers\Laravel;
use Illuminate\Support\Facades\Facade;

class StatsProfiler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'groundsix.profiler';
    }
} 