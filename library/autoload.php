<?php

/**
 * Autoloader
 *
 * @param string $className
 */
function __autoload($className)
{
    $path = '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    require $path;
}