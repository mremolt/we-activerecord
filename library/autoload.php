<?php

/**
 * Autoloader
 *
 * @param string $className
 * @package library
 */
function __autoload($className)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    require $path;
}