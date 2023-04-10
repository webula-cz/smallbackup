<?php namespace Webula\SmallBackup\Classes;

class PathHelper
{
    //
    // STATIC HELPERS
    //

    /**
     * Convert slash and backslash trash to OS
     *
     * @param string $path
     * @return string
     */
    public static function normalizePath($path): string
    {
        return rtrim(preg_replace('#([\\\\/]+)#', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    }

    /**
     * Convert slash and backslash trash to version good for Rainlab Zip class
     *
     * @param string $path
     * @return string
     */
    public static function linuxPath($path): string
    {
        return rtrim(preg_replace('#([\\\\/]+)#', '/', $path), '/');
    }
}