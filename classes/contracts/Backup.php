<?php namespace Webula\SmallBackup\Classes\Contracts;

interface Backup
{
    public function backupStream(): string;
}