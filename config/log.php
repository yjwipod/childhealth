<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 日志设置
// +----------------------------------------------------------------------
use \think\facade\Env;

return [
    // 日志记录方式，内置 file socket 支持扩展
    'type' => 'Test',
    // 日志保存目录
    'path' => Env::get('RUNTIME_PATH') . 'log/',
    // 日志记录级别
    'level' => [],
];
