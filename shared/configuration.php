<?php

/**
 * This file is useful for change the configuration method for your container.
 */

/*
 * Load configuration files
 */
$files = glob(__DIR__ . '/configurations/*.php', GLOB_BRACE);

/*
 * Setup the configuration array
 */
$settings = [];

/*
 * Cycle the files and include in the configuration array
 */
if (0 < count($files)) {
    foreach ($files as $file) {
        $key = str_replace('.php', '', basename($file));

        $settings[$key] = include realpath($file);
    }
}

/*
 * Return the configuration array
 */
return $settings;