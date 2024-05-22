<?php

/**
 * Get the config values for s3
 *
 * @param $key
 * @return mixed
 */
function configS3($key)
{
    return config('s3.' . $key);
}
