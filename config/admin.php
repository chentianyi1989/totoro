<?php

return [
    'page-size' => 15,
    /* 上传文件配置 */
    'uploads'                      => [
        'mimes'     => [],
        'storage'   => 'local',
        'max_size'  => 10 * 1024 * 1024,
        'extension' => ['jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'tar', 'gz', '7z', 'doc', 'docx', 'txt', 'xml'],
        'save_path' => date('Y-m-d') . '/' . sha1(time()),
    ],
];