<?php

namespace app\index\service;


use core\base\Service;
use core\db\index\model\PointLogModel;
use think\facade\Cache;

class CommonService extends Service
{
    public function Rw_Json($status, $code, $message)
    {
        $arr = ['status' => $status, 'code' => $code, 'message' => $message];
        return json($arr);
    }

    public function web_info()
    {
        if (!Cache::get('web_info')) {
            $web_info = WebSetService::getSingleton()->getWebset(['web_logo', 'copyright', 'web_name', 'web_title', 'web_desc', 'web_keywords', 'web_hot_line', 'web_kefu_line', 'web_address', 'web_qrcode']);
            Cache::set('web_info', $web_info, 3600);
            return $web_info;
        } else {
            return Cache::get('web_info');
        }
    }

    public function ranktime($user_id)
    {

        if ($user_id) {
            $sign = 'ranktime_' . $user_id;

            $t = time();
            $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
            $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
            $map['type'] = 0;
            $map['userId'] = $user_id;
            $map['is_frist'] = 1;

            $check_is_frist = PointLogModel::getSingleton()->where($map)->whereTime('createtime','between',[$start,$end])->find();
            $cache_ranktime_info = Cache::get($sign);

            if ($cache_ranktime_info['num'] == 6 && empty($check_is_frist)) {

                if($start < $cache_ranktime_info['time'] && $cache_ranktime_info['time'] < $end){
                    $num = intval($cache_ranktime_info['num']) + 1;
                }else{
                    $num = 1;
                }
                Cache::set($sign, ['num'=>$num,'time'=>time()]);
                return 3;
                exit();

            }
            if (false === $cache_ranktime_info['num']) {

                $num = 1;
                Cache::set($sign, ['num'=>$num,'time'=>time()]);

            } else {

                if($start < $cache_ranktime_info['time'] && $cache_ranktime_info['time'] < $end){
                    $num = intval($cache_ranktime_info['num']) + 1;
                }else{
                    $num = 1;
                }

                Cache::set($sign, ['num'=>$num,'time'=>time()]);

            }
            return 1;

        } else {
            return false;
        }
    }

}
