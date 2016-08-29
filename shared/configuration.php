<?php

/**
 * This file is useful for change the configuration method for your container.
 */

/*
 * Load global/local configuration files based on environment
 */
if (true === defined('APP_ENV') and 'dev' == APP_ENV) {
    $files = glob(__DIR__ . '/configurations/{{,*.}global,{,*.}local}.php', GLOB_BRACE);
} else {
    $files = glob(__DIR__ . '/configurations/{{,*.}global}.php', GLOB_BRACE);
}

/*
 * Setup the configuration array
 */
$settings = [];

/*
 * Cycle the files and include in the configuration array
 */
if (0 < count($files)) {
    foreach ($files as $file) {
        $settings = array_replace_recursive($settings, include $file);
    }
}

/*
 * Return the configuration array
 */
return $settings;