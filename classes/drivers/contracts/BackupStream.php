<?php namespace Webula\SmallBackup\Classes\Drivers\Contracts;

interface BackupStream
{
    public function backupStream(): string;
}