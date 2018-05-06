<?php

namespace app\index\controller;



use core\db\index\model\CurrentLevelModel;
use core\db\index\model\MemberUserModel;
use think\Controller;
use think\Db;
use think\facade\Env;
use think\facade\Session;
use think\facade\Url;

class Base extends Controller
{
    public $user_id = 0;
    public $user_info = '';
    public $level = 1;
    public $wrong_times = 10;

    public function initialize()
    {
        $siteInfo = [
            'site_title' => '',
            'site_keyword' => '',
            'site_description' => '',
            'health_url' => Url::build('index/index/health'),
            'login_url' => Url::build('index/index/login'),
            'reg_url' => Url::build('index/index/reg'),
            'go_trip_url' => Url::build('index/index/go_trip'),
            'logout_url' => Url::build('index/index/logout'),
            'about_url' => Url::build('index/index/about')
        ];
        $this->user_id = Session::get('user_id') == "" ? "0" : Session::get('user_id');
        //Session::get('user_info') == "" ? "" : Session::get('user_info');

        $this->user_info = MemberUserModel::getSingleton()->where(['id' => $this->user_id])->find();

        $this->assign('site_info', $siteInfo);
//        echo $this->request->action();
        $this->assign('user_id', $this->user_id);
        $this->assign('user_info', $this->user_info);
        $this->assign('domain_url', Env::get('BASE_URL'));

        $this->level = $this->checkLevel();
        $this->assign('level', $this->level);
//        $this->assign('wrong_times', $this->wrong_times);


        $this->assign('action', $this->request->action()); //存储用户信息

        $this->assign('controller', $this->request->controller()); //存储用户信息
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Controller::beforeViewRender()
     */
    protected function beforeViewRender()
    {
        $siteVersion = date('Ymd');
        $this->assign('site_version', $siteVersion);

        $staticPath = '/static';
        $this->assign('static_path', $staticPath);

        $assetsPath = '/assets';
        $this->assign('assets_path', $assetsPath);

        parent::beforeViewRender();
    }


    public function checkLevel()
    {
        $startime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endtime = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $res = Db::table('current_level')
            ->where('userid', 'eq', $this->user_id)
            ->where(function ($query) use ($startime, $endtime) {
                $query->where('time', ['<', $endtime], ['>', $startime], 'and');
            })
            ->find();
        if ($res) {
            switch ($res['level']) {
                case 1;
                    $wrong_times = 10;
                    break;
                case 2;
                    $wrong_times = 9;
                    break;
                case 3;
                    $wrong_times = 8;
                    break;
                case 4;
                    $wrong_times = 7;
                    break;
                case 5;
                    $wrong_times = 6;
                    break;
                case 6;
                    $wrong_times = 5;
                    break;
                default :
                    $wrong_times = 10;
                    break;
            }
            return ['level'=>$res['level'], 'wrong_times'=>$wrong_times];
        } else {
            $data['userid'] = $this->user_id;
            $data['time'] = time();
            $data['level'] = 1;
            CurrentLevelModel::getSingleton()->save($data);
            $this->checkLevel();
        }

    }


}


