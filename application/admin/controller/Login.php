<?php
namespace app\admin\controller;

use think\Controller;
use think\captcha\Captcha;
use app\admin\model\Root as RootModel;
use app\admin\model\Role as RoleModel;
use hanziToPinyin\ChinesePinyin;
class Login extends Controller{
    /*
     * 后台登录
     */
    public function login(){
        if(isset($_POST['username']) && isset($_POST['password'])){
            //检测验证码
            $code = input("post.code");
            $captcha = new Captcha();
            if(!$captcha->check($code)){
                $this->error("验证码错误");exit;
            }
            //查找账号密码
            $usename = input("post.username");
            $password = input("post.password");
            $password = md5(config('queue.salt').$password);
            $rootModel = new RootModel();
            $rst = $rootModel->where("root_username",$usename)
                ->where("root_pwd",$password)->find();
            if (!$rst){
                $this->error("用户名或密码错误");exit;
            }
            //将用户信息保存session中
            $roleModel = new RoleModel();
            $roleRst = $roleModel->find($rst['role_id']);
            
            session('rootInfo',$rst);
            session('rootInfo.role_name',$roleRst['role_name']);
            //为用户添加登录时间
            $rootModel->save([
                'root_last_time' => time()
            ],['root_id'=>$rst['root_id']]);
            $this->redirect("Index/index");exit;
           // $this->success("登录成功","Index/index","",0);
        }else{

            return view('login');
        }
    }
    
    //测试websocket
    public function test()
    {
        return view('test');
    }
    
    /*
     * 生成验证码
     */
    public function getCaptcha(){
        $captcha = new Captcha();
        $captcha->useCurve = false;
        $captcha->imageH = 40;
        $captcha->imageW = 100;
        $captcha->length = 4;
        $captcha->fontSize = 16;
        $captcha->fontttf = "4.ttf";
        return $captcha->entry();
    }
    
    /*
     * 退出登录
     */
    public function goOut(){
        session(null);
        $this->success("退出成功","Login/login");
    }
    
//     /*
//      * 测试 汉子转换拼音
//      */
//     public function chineseToSpell(){
//         $chinese = input('param.name');
    
//         $pinyin = new ChinesePinyin();
//         $str = $pinyin->TransformUcwords($chinese);
//         $str = strtolower($str);
//         var_dump($str);
//     }
    
    
    
    
    
    
    
    
    
    
    
    
}