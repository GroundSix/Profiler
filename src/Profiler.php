<?php

namespace GroundSix\Component;

interface Profiler
{
    public function start($message);
    public function stop();
    public function push($message);
    public function fetch();
    public function kill();
} 