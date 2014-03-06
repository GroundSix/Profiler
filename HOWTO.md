# HOW TO USE

```php
<?php

$profiler = new Profiler();

$profiler->push('Started profiling my code');

$query_profile = $profiler->start('Start query profile');

// Do a resource-intensive database query

$query_profile->push("Query 1 Finished");

// Do another resource-intensive database query

$query_profile->push("Query 2 Finished");

$query_profile->stop();

$profiler->push('Query Profile finished');

$special_profile = $profiler->start('Starting special profile');

$tiered_profile = $special_profile->start("beginning tiered profile");
$tiered_profile->push('Super Message');

function doAmazingCode($special_profile)
{
    $special_profile->kill();
}


```