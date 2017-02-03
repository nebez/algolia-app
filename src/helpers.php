<?php

/**
 * A helper function to make working with environment variables more sane
 *
 * @param  string $key
 * @param  string|null $default
 * @return string|null
 */
function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    return $value;
}
