<?php
return [
    // 下载
    'download' => 'index/index/download',
    'health' => 'index/index/health',
    'introduction' => 'index/index/introduction',
    'trip' => 'index/index/go_trip',
    'login' => 'index/index/login',
    'reg' => 'index/index/reg',
//    'user' => 'index/index/user',
    'logout' => 'index/index/logout',
    '[user]'     => [
        ':id'   => ['index/user/index', ['method' => 'get'], ['id' => '\d+']],
//        'getpoints' => ['index/user/getpoints', ['method' => 'post']],
//        ':name' => ['index/hello', ['method' => 'post']],
    ],
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '__alias__' =>  [
//        'home'  =>  'index/index',
//        'admin'=> 'admin/index'
//    ],
    // 后台
    'module/:_module_/:_controller_/:_action_' => 'manage/loader/run'
];