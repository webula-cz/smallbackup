<?php
return [
    'plugin' => [
        'name' => '小型备份',
        'description' => '备份数据库和主题',
    ],

    'backup' => [
        'list' => [
            'db' => '数据库备份文件',
            'theme' => '主题备份文件',
            'storage' => '存储备份文件',
            'filename' => '备份文件',
            'created_at' => '已创建',
        ],
        'control' => [
            'download' => '下载',
            'backup_now' => '立即备份',
        ],
        'flash' => [
            'expired_deleted' => ':已成功删除过期备份。',
            'successfull_backup' => '备份文件为：:file。',
            'failed_backup' => '备份失败：:error。',

            'backup_all' => ':已成功删除过期备份。备份已成功创建到文件：:files。',

            'nothing_to_backup' => '无需备份。',
            'unknown_database_driver' => '未知的数据库驱动程序：:driver！此驱动程序尚未实现。请发送PR。',
            'unknown_theme' => '未知主题！无法找到代码名为：:theme的主题。',
            'unknown_resource' => '未知的存储资源！无法找到存储资源：:resource。',
            'empty_resource' => '此资源为空，无需备份！',
            'empty_files' => '存储资源不包含任何文件，无需备份！',
            'unknown_output' => '未知的输出类型，无法创建备份！',

            'truncated_filenames' => '在创建TAR存档时，这些文件名被截断：:filenames',
        ],
    ],

    'permissions' => [
        'access_settings' => '管理后端偏好',
    ],

    'settings' => [
        'tabs' => [
            'database' => '数据库',
            'theme' => '主题',
            'storage' => '存储',
            'settings' => '设置',
        ],

        'backup_folder' => '备份文件夹',
        'backup_folder_comment' => '留空以使用默认文件夹。',
        'cleanup_interval' => '清理间隔（以天为单位）',
        'db_use_compression' => '使用ZIP压缩',

        'db_auto' => '开启自动数据库备份',
        'db_auto__comment' => '自动模式将每天由调度器根据October CMS文档启动一次。手动模式需要根据插件文档运行进程。',

        'db_excluded_tables' => '从备份中排除的表',
        'db_excluded_tables__comment' => '仅适用于MySQL。SQLite将备份为一个文件。',

        'db_custom_mapping' => '自定义MySQL数据库Doctrine映射',
        'db_custom_mapping__prompt' => '添加新类型',
        'db_custom_mapping__comment' => '当导出数据库时，用于替代原始类型的数据库列类型（例如，将JSON导出为TEXT）。',
        'db_custom_mapping__db_type' => '当前数据库类型',
        'db_custom_mapping__db_type__comment' => '例如：json',
        'db_custom_mapping__doctrine_type' => '备份用的Doctrine类型',
        'db_custom_mapping__doctrine_type__comment' => '例如：text',

        'theme_auto' => '开启自动主题备份',
        'theme_auto__comment' => '自动模式将每天由调度器根据October CMS文档启动一次。手动模式需要根据插件文档运行进程。',

        'storage_auto' => '开启自动存储备份',
        'storage_auto__comment' => '自动模式将每天由调度器根据October CMS文档启动一次。手动模式需要根据插件文档运行进程。',
        'storage_output' => '输出类型',
        'storage_output__tar' => 'TAR存档',
        'storage_output__tar_unsafe' => '无文件名长度检查的TAR存档（更快）',
        'storage_output__tar' => 'TAR存档标准',
        'storage_output__tar_gz' => '使用zlib压缩的TAR存档',
        'storage_output__tar_bz2' => '使用bzip2压缩的TAR存档',
        'storage_output__zip' => 'ZIP存档',
        'storage_output__comment' => '标准TAR存档文件名的最大长度为256个字符。更长的名称将被截断。',

        'storage_excluded_resources' => '从备份中排除的存储文件夹',

    ],
];
