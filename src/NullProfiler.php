<?php

class GroundSix\Component;

class NullProfiler implements Profiler
{
    public function start($message = '') {}
    public function stop() {}
    public function push($message = '') {}
    public function fetch() {}
    public function kill() {}
}