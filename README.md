# Small Backup
> Simple backup for database (MySQL, SQLite), active theme and CMS storages


## Installation

**GitHub** clone into `/plugins` dir:

```sh
git clone https://github.com/webula-cz/smallbackup
```

**OctoberCMS backend (OC1)**

Just look for 'Small Backup' in search field in:
> Settings > Updates & Plugins > Install plugins

### Permissions

> Settings > Administrators

You can set permissions to restrict access in *Settings > Small plugins > Small Backup*.


### Installation with composer

* Edit composer.json by adding new repository
```
"repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/webula-cz/smallbackup"
    }
]
```
* run in command line
```sh
composer require webula/smallbackup-plugin
```


## Settings

* Default backups folder `storage/app/backup`
* Default cleanup interval `7 days`

You can download created backups from plugin Settings tabs Database, Theme and Storage or you can get it directly from backup folder (eg. with FTP).

It's recommended to put your backup folder into .htaccess' *Black listed folders*, e.g. `RewriteRule ^storage/app/backup/.* index.php [L,NC]`.


## How to make backups

### Automatic backup (with scheduler)

>Must be allowed in plugin's Settings!

There are default scheduler jobs for database and active theme to be backed up once a day.

[See October CMS docs](https://docs.octobercms.com/1.x/setup/installation.html#review-configuration) about scheduling jobs.

### Automatic backup (without scheduler)

If you cannot run Cron command directly on your server/hosting, you can create custom CMS page like this:

```
title = "artisan"
url = "/artisan/schedule"
is_hidden = 0
==
<?php
    function onStart()
    {
        wsb_backup_db($once = false, $connectionName = null,$noCleanup = false);
        wsb_backup_theme($once = false, $themeName = null, $noCleanup = false);
        wsb_backup_storage($once = false, $cmsStorage = null, $noCleanup = false);
    }
?>
==
```


### Manual backup

You can create manual backup in plugin's Settings by clicking button `Backup now` on Database or Theme tab.

#### Console commands

There are console commands ready:

* `php artisan smallbackup:db [connectionName] [--no-cleanup] [--once]` (connectionName is optional and respect config/database.php settings)

* `php artisan smallbackup:theme [themeName] [--no-cleanup] [--once]` (themeName is optional and can be any folder name in themes/)

* `php artisan smallbackup:storage [cmsStorage] [--no-cleanup] [--once]` (cmsStorage is optional and can be any storage registered in *cms.storage* config)


----
> Our thanks goes to:
> [OctoberCMS](http://www.octobercms.com) team members and supporters for this great system.
> [Brooke Cagle](https://unsplash.com/@benjaminlehman) for his photo.
> [Font Awesome](http://fontawesome.io/icons/) for nice icons.

Created by [Webula](https://www.webula.cz) in Czech Republic.
