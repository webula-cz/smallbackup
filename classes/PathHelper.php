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

    /**
     * Truncate path to length
     *
     * @param string $path
     * @param int $length
     * @param int $filename_length
     * @param string $append
     * @return string
     */
    public static function tarTruncatePath($path, $length = 256, $filename_length = 100, $append = '__trunc'): string
    {
        $pathname = mb_substr($path, 0, $last_separator_position = mb_strrpos($path, DIRECTORY_SEPARATOR));
        $filename = mb_substr($path, $last_separator_position + 1);

        if (mb_strlen($pathname) > $length - $filename_length - 1) {
            $pathname = DIRECTORY_SEPARATOR . $append . mb_substr($pathname, 0, $length - $filename_length - 1 - 1 - mb_strlen($append));
        }

        if (mb_strlen($filename) > $filename_length) {
            $extension = mb_substr($filename, mb_strrpos($filename, '.'));
            $filename = mb_substr($filename, 0, $filename_length - mb_strlen($append) - mb_strlen($extension)) . $append . $extension;
        }

        return $pathname . DIRECTORY_SEPARATOR . $filename;
    }
}