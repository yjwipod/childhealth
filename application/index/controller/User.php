<?php

namespace app\index\controller;


use core\db\index\model\CurrentLevelModel;
use core\db\index\model\EatplanModel;
use core\db\index\model\FoodModel;
use core\db\index\model\GradeModel;
use core\db\index\model\PlanModel;
use core\db\index\model\PointLogModel;
use core\db\manage\model\MemberUserModel;
use PHPMailer\PHPMailer\PHPMailer;
use think\captcha\Captcha;
use think\Db;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Session;

class User extends Base
{
    protected $healthyLevel = array(
        '1' => 'Unhealthiest',
        '2' => 'Unhealthy',
        '3' => 'Healthy',
        '4' => 'Healthiest',
    );
    protected $foodgrade = array(
        '1' => 'level 1',
        '2' => 'level 2',
        '3' => 'level 3',
        '4' => 'level 4',
        '5' => 'level 5',
        '6' => 'level 6',
    );

    public function initialize()
    {
        parent::initialize();
        $this->assign('healthyLevel', $this->healthyLevel);

    }

    public function index()
    {

        if ($this->request->param('id') == 0) {
            return redirect('/login');
        }
        $list = PlanModel::getSingleton()->where(['userId' => Session::get('user_id')])->select();
//        print_r(count($list));
        $this->assign('list', $list);
        $this->assign('level', $this->getUserlevel($this->user_info['point']));
//        $this->assign('needpoints', $this->getUserlevel(Session::get('user_info')['point']));
        return $this->fetch();
    }


    public function getpoints($points, $type, $is_frist = 0)
    {
        $data['point'] = $points;
        $data['type'] = $type;
        $data['is_frist'] = $is_frist;
        $data['userId'] = $this->user_id;
        $data['createtime'] = time();
        if (PointLogModel::getSingleton()->save($data)) {
            Session::set('user_info', MemberUserModel::getSingleton()->where(['id' => $this->user_id])->find());
            MemberUserModel::getSingleton()->where(['id' => $this->user_id])->setInc('point', $points);
        }
//        return json(['code' => '22']);
    }

    public function ajaxGetpoints()
    {
        if ($this->request->isAjax()) {

            $data['point'] = $this->request->param('points');
            $data['type'] = 0;
            $data['is_frist'] = 0;
            $data['userId'] = $this->user_id;
            $data['createtime'] = time();
            if (Cache::get('ranktime_' . $this->user_id)['num'] < 7) {
                if (PointLogModel::getSingleton()->save($data)) {
                    Session::set('user_info', MemberUserModel::getSingleton()->where(['id' => $this->user_id])->find());
                    MemberUserModel::getSingleton()->where(['id' => $this->user_id])->setInc('point', $this->request->param('points'));
                    $startime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                    $endtime = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
                    $res = Db::table('current_level')
                        ->where('userid', 'eq', $this->user_id)
                        ->where(function ($query) use ($startime, $endtime) {
                            $query->where('time', ['<', $endtime], ['>', $startime], 'and');
                        })
                        ->find();
                    $map['id'] = $res['id'];
                    if ($res['level'] < 6) {
                        CurrentLevelModel::getSingleton()->where($map)->setInc('level', 1);
                    }
                }
            }

        }

    }

    public function foods()
    {
        $menu_model = new FoodModel();
        $lists = $menu_model::paginate(13);
        $page = $lists->render();
        $this->assign('lists', $lists);
        $this->assign('page', $page);


        return $this->fetch();
    }

    public function food_manage()
    {
        if ($this->request->post()) {
            $data = $this->request->post();

            $data['time'] = time();
            if ($_FILES['file']['error'] != 4)
                $data['picpath'] = $this->uploadImage();

            $foodgrade = $data['foodgrade'];
            unset($data['foodgrade']);

            if (!empty($data['foodId'])) {
                if (FoodModel::getSingleton()->save($data, ['foodId' => $data['foodId']])) {
                    $this->editGrade($data['foodId'], $foodgrade);
                    return $this->success('Update Success', 'index/user/foods');
                } else {
                    return $this->error('Update error', 'index/user/food_manage');
                }
            } else {

                if ($food_id = FoodModel::getSingleton()->save($data)) {
                    $this->editGrade(FoodModel::getSingleton()->getLastInsID(), $foodgrade);
                    return $this->success('Save Success', 'index/user/foods');
                } else {
                    return $this->error('Save error', 'index/user/food_manage');
                }
            }
        }
        if ($this->request->isGet()) {
            $food_id = $this->request->param('foodId');
            if ($food_id) {
                $food_info = FoodModel::getSingleton()->where(['foodId' => $food_id])->find();
            } else {
                $food_info['healthyLevel'] = 0;
            }
            $grade_info = GradeModel::getSingleton()->where(['food_id' => $food_id])->select()->toArray();


            $this->assign('grade_info', $this->gradetoarray($grade_info));
            $this->assign('info', $food_info);
        }
        $this->assign('foodgrade', $this->foodgrade);
        return $this->fetch();
    }

    public function food_del()
    {
        $id = $this->request->param('foodId');
        if (FoodModel::getSingleton()->where(['foodId' => $id])->delete()) {
            return $this->success('Del Success');
        } else {
            return $this->error('Del Error');
        }
    }

    public function uploadImage()
    {
        if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/png")
                || ($_FILES["file"]["type"] == "image/pjpeg"))
            && ($_FILES["file"]["size"] < 20000000)) {
            if ($_FILES["file"]["error"] > 0) {
//                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
                return $this->error($_FILES["file"]["error"]);
            } else {
//                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//                echo "Type: " . $_FILES["file"]["type"] . "<br />";
//                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                if (file_exists("upload/" . $_FILES["file"]["name"])) {
//                    echo $_FILES["file"]["name"] . " already exists. ";
                    return $this->error($_FILES["file"]["name"] . " already exists. ");
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        "upload/" . $_FILES["file"]["name"]);
//                    echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
                    return "upload/" . $_FILES["file"]["name"];
                }
            }
        } else {
//            echo "Invalid file";
            return $this->error("Invalid file");
        }
    }

    public function login()
    {
        if (Session::get('user_id')) {
            return redirect(url('index/index/user'));
        }
        if ($this->request->isAjax()) {
            $captcha = new Captcha();
            $data = $this->request->param();
            if (!$captcha->check($data['imgcode'])) {
                return json(['status' => 0, 'msg' => 'verify code  not right']);
            }
            $map = [
                'user_name' => $data['account'],
                'user_password' => md5($data['password']),
            ];
            $res = MemberUserModel::getSingleton()->where($map)->find();
            if ($res != false) {
                $_data = ['login_time' => time()];
                MemberUserModel::getSingleton()->save(['login_time' => time()], $map);
                Session::set('user_info', $res);
                Session::set('user_id', $res->id);
                Cookie::set('user_id', 'value', $res->id);
                return json(['status' => 1, 'msg' => "login seccess"]);
            } else {
                return json(['status' => 0, 'msg' => "login error"]);
            }
        }
        return $this->fetch();
    }

    public function reg()
    {

        if ($this->request->isAjax()) {

            $captcha = new Captcha();
            $data = $this->request->param();
            if (!$captcha->check($data['imgcode'])) {
                return json(['status' => 0, 'msg' => 'verify code  not right']);
            }
            $_data = [
                'user_name' => $data['account'],
                'email' => $data['email'],
                'sex' => $data['sex'],
                'user_password' => md5($data['password']),
                'create_time' => time(),
                'login_time' => time(),
            ];
            $res = MemberUserModel::getSingleton()->save($_data);

            if ($res != false) {
                $res = MemberUserModel::getSingleton()->where(['user_name' => $data['account'], 'user_password' => md5($data['password'])])->find();
                Session::set('user_info', $res);
                Session::set('user_id', $res->id);
                Cookie::set('user_id', 'value', $res->id);
                return json(['status' => 1, 'msg' => "reg success"]);
            } else {
                return json(['status' => 0, 'msg' => "reg error"]);
            }
        }
        return $this->fetch();
    }

    public function verify()
    {
        $config = [
            'imageH' => 40,
            // 验证码字体大小
            'fontSize' => 16,
            // 验证码位数
            'length' => 4,
            // 关闭验证码杂点
            'useNoise' => false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function logout()
    {
        Session::delete('user_id');
        Session::delete('user_info');
        Cookie::delete('user_id');
        return redirect(url('/index'));
    }

    public function addplan()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            list($startTime, $endTime) = explode('-', $data['time']);
            $time = date('Y-m-d', time());
            $data['startTime'] = $startTime;
            $data['endTime'] = $endTime;
            $data['userId'] = $this->user_id;
            $data['date'] = $time;
            unset($data['time']);
            $info = PlanModel::getSingleton()->where($data)->find();
            if ($info) {
                return json(['code' => 30, 'msg' => 'Already exist']);
            }
            if (PlanModel::getSingleton()->save($data)) {

                return json(['code' => 20, 'msg' => 'success']);
            } else {
                return json(['code' => 10, 'msg' => 'error']);
            }
        }
    }

    public function plan_handle()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $s_data['status'] = $data['status'];
            $map['planId'] = $data['planId'];
            $s_data['createtime'] = time();
            $map['userId'] = $this->user_id;
            if (PlanModel::getSingleton()->save($s_data, $map)) {
                if ($data['status'] == 2) {
                    $this->getpoints(10, 1);
                }
                return json(['code' => 20, 'msg' => 'success']);
            } else {
                return json(['code' => 10, 'msg' => 'error']);
            }
        }
    }

    public function plan_eat()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $s_data['foodId'] = $data['strid'];
            $s_data['userId'] = $this->user_id;

            $startime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $endtime = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            $res = Db::table('user_eat')
                ->where('userId', 'eq', $this->user_id)
//                ->where('is_frist', 'eq', 1)
                ->where(function ($query) use ($startime, $endtime) {
                    $query->where('createtime', ['<', $endtime], ['>', $startime], 'and');
                })
                ->find();

            $s_data['createtime'] = time();
            if (EatplanModel::getSingleton()->save($s_data)) {
                $points = count(explode(',', $data['strid'])) == 1 ? 5 : 10;
//                Cache::rm('ranktime_' . $this->user_id);
                if (is_array($res) && !empty($res)) {
                    return json(['code' => 20, 'msg' => 'success', 'data' => '1']); //已有
                } else {
                    $this->getpoints($points, 0, 1);
                    return json(['code' => 20, 'msg' => 'success', 'data' => '0']);
                }
            } else {
                return json(['code' => 10, 'msg' => 'error']);
            }
        }
    }

    public function foodRankTest()
    {
        $sign = 'ranktime_' . $this->user_id;
//        if (Cache::get($sign) != 6) {
//            return redirect(url('/health'));
//        }
//        $foodlist = FoodModel::getSingleton()->where('healthyLevel','in', [3,4])->select();
//        $this->assign('list',$foodlist);

        $y_foodlist = FoodModel::getSingleton()->where('healthyLevel', 'eq', 4)->order('rand()')->limit(6)->select();
        $this->assign('y_list', $y_foodlist);

        $l_foodlist = FoodModel::getSingleton()->where('healthyLevel', 'eq', 3)->order('rand()')->limit(6)->select();
        $this->assign('l_list', $l_foodlist);
        return $this->fetch();
    }

    public function point_logs()
    {
        $user_id = $this->request->param('user_id');
        if ($user_id) {
//            $list = PointLogModel::getSingleton()->where(['userId'=>$user_id])->select();
//            $this->assign('lists',$list);

            $lists = Db::name('point_log')->where(['userId' => $user_id])->paginate(10);

            $page = $lists->render();
            $this->assign('lists', $lists);
            $this->assign('page', $page);
        }
        return $this->fetch();
    }

    public function sendEmail()
    {

        $foods = $this->request->param('foodname');
        $user_info = Session::get('user_info');
        if (empty($user_info)) {
            return false;
        }

        $toemail = $user_info['email'];
        $name = $user_info['user_name'];
        $subject = 'Fit Kidz Tips';
        $content = 'Your child ' . $user_info['user_name'] . ' has chosen ' . $foods . ' for the next meal. Fit-kidz is always helping children to choose the healthiest food they want.';
        if (null !== $this->request->param('msg') && !empty($this->request->param('msg'))) {
            $content = $this->request->param('msg');
        }
        $this->send_mail($toemail, $name, $subject, $content);
        echo "";
    }

    /**
     * 获取用户等级
     */
    public function getUserlevel($points = 100)
    {

        if (10 <= $points && $points <= 90) {
            $needpoints = 100 - $points;
            return ['level' => 1, 'needpoints' => $needpoints];
        } elseif (100 <= $points && $points <= 190) {
            $needpoints = 200 - $points;
            return ['level' => 2, 'needpoints' => $needpoints];
        } elseif (200 <= $points && $points <= 290) {
            $needpoints = 300 - $points;
            return ['level' => 3, 'needpoints' => $needpoints];
        } elseif (300 <= $points && $points <= 390) {
            $needpoints = 400 - $points;
            return ['level' => 4, 'needpoints' => $needpoints];
        } elseif (400 <= $points && $points <= 490) {
            $needpoints = 500 - $points;
            return ['level' => 5, 'needpoints' => $needpoints];
        } elseif (500 <= $points && $points <= 590) {
            $needpoints = 600 - $points;
            return ['level' => 6, 'needpoints' => $needpoints];
        } elseif (600 <= $points && $points <= 690) {
            $needpoints = 700 - $points;
            return ['level' => 7, 'needpoints' => $needpoints];
        } elseif (700 <= $points && $points <= 790) {
            $needpoints = 800 - $points;
            return ['level' => 8, 'needpoints' => $needpoints];
        } elseif (800 <= $points && $points <= 890) {
            $needpoints = 900 - $points;
            return ['level' => 9, 'needpoints' => $needpoints];
        } elseif (900 <= $points && $points <= 990) {
            $needpoints = 0;
            return ['level' => 10, 'needpoints' => $needpoints];
        } else {
            $needpoints = 10 - $points;
            return ['level' => 0, 'needpoints' => $needpoints];
        }


    }

    /**
     * 系统邮件发送函数
     * @param string $tomail 接收邮件者邮箱
     * @param string $name 接收邮件者名称
     * @param string $subject 邮件主题
     * @param string $body 邮件内容
     * @param string $attachment 附件列表
     * @return boolean
     * @author static7 <static7@qq.com>
     */
    function send_mail($tomail, $name, $subject = '', $body = '', $attachment = null)
    {

        $mail = new PHPMailer();           //实例化PHPMailer对象
        $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP();                    // 设定使用SMTP服务
        $mail->SMTPDebug = 1;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
        $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
        $mail->SMTPSecure = 'ssl';          // 使用安全协议
        $mail->Host = "smtp.qq.com"; // SMTP 服务器
        $mail->Port = 465;                  // SMTP服务器的端口号
        $mail->Username = "120025737@qq.com";    // SMTP服务器用户名
        $mail->Password = "Huang89814!!qy";     // SMTP服务器密码
        $mail->SetFrom('120025737@qq.com', 'Kids Fit');
        $replyEmail = '';                   //留空则为发件人EMAIL
        $replyName = '';                    //回复名称（留空则为发件人名称）
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($tomail, $name);
        if (is_array($attachment)) { // 添加附件
            foreach ($attachment as $file) {
                is_file($file) && $mail->AddAttachment($file);
            }
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }

    public function editGrade($foodid, $grade)
    {

        if (!empty($foodid)) {
            $data['food_id'] = $foodid;
            GradeModel::getInstance()->where(['food_id' => $foodid])->delete();
            foreach ($grade as $item) {
                $data['grade'] = $item;
                GradeModel::getInstance()->save($data);
            }
        }
    }

    public function gradetoarray($gradeArr)
    {
        $re_arr = [];
        foreach ($gradeArr as $item) {
            $re_arr[] = $item['grade'];
        }

        return $re_arr;
    }


}