<?php namespace Webula\SmallBackup\Classes;

class PathHelper
{
    //
    // STATIC HELPERS
    //

    /**
     * Convert slash and backslash trash to version good for Rainlab Zip class
     *
     * @param string $path
     * @return string
     */
    public static function normalizePath($path): string
    {
        return rtrim(preg_replace('#([\\\\/]+)#', '/', $path), '/');
    }
}