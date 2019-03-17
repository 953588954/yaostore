<?php
/*
 * 权限控制器
 */

namespace app\admin\controller;

use app\admin\validate\AddRole;
use app\admin\model\Role as RoleModel;
use app\admin\validate\AddRoot;
use app\admin\model\Root as RootModel;
use app\admin\validate\AddAuth;
use app\admin\model\Auth as AuthModel;

class Auth extends BaseController{
    /*
     * 角色管理页面
     */
    public function role(){
        
        
        $this->assign('navigation1','权限设置');
        $this->assign('navigation2','角色管理');
        return view('role');
    }
    /*
     * 添加角色
     */
    public function addRole(){
        (new AddRole('Auth/role'))->goCheck();
        //var_dump(input('post.role_name'));die;
        //添加角色
        $role = new RoleModel();
        $role->role_name = trim(input('post.role_name'));
        $role->save();
        $this->success("添加成功","Auth/role");
    }
    
    /*
     * 用户管理页面
     */
    public function root(){
        //查询所有用户
        $allRoots = RootModel::select();
        //查询所有角色
        $allRoles = RoleModel::select();
        
        $this->assign('allRoot',$allRoots);
        $this->assign('allRole',$allRoles);
        $this->assign('navigation1','权限设置');
        $this->assign('navigation2','用户管理');
        return view('root');
    }
    /*
     * 添加用户、
     * 编辑更新用户
     */
    public function addOrEditRoot(){
        (new AddRoot('Auth/root'))->goCheck();
        $params = input('post.');
        
        //更新用户
        if(isset($params['root_id']) && !empty($params['root_id'])){
            $rootInfo = RootModel::get($params['root_id']);
            $rootInfo->root_name = $params['root_name'];
            $rootInfo->root_username = $params['root_username'];
            $rootInfo->root_sex = $params['root_sex'];
            $rootInfo->root_phone = $params['root_phone'];
            $rootInfo->role_id = $params['role_id'];
            $rootInfo->save();
            $this->success('修改成功','Auth/root');exit;
        }else{  //增加用户
            $root = new RootModel();
            $root->root_name = $params['root_name'];
            $root->root_username = $params['root_username'];
            $root->root_sex = $params['root_sex'];
            $root->root_pwd = $params['root_pwd'];
            $root->root_phone = $params['root_phone'];
            $root->role_id = $params['role_id'];
            $root->save();
            
            $this->success('添加成功','Auth/root');exit;
        }
        
    }
    /*
     * ajax 查询某一个用户信息
     */
    public function getRootInfo(){
        $id = input("post.id");
       checkID($id);
       $rootInfo = RootModel::find($id);
       echo json_encode($rootInfo);
    }
    /*
     * ajax删除指定用户
     */
    public function deleteRoot(){
        $id = input("post.id");
        checkID($id);
        RootModel::destroy($id);
        echo json_encode([
            'error' => 0,
            'msg' => "删除成功"
        ]);
    }
    
    /*
     * 权限管理页面
     */
    public function auth(){
        $authObj = new AuthModel();
        //查询所有一级权限
        $first_level = $authObj->where("auth_level","=","1")->select();
        //查询所有二级权限
        $second_level = $authObj->where("auth_level","=","2")->select();
        //查询所有三级权限
        $third_level = $authObj->where("auth_level","=","3")->select();
        
        $this->assign("firstLevel",$first_level);
        $this->assign("secondLevel",$second_level);
        $this->assign("thirdLevel",$third_level);
        $this->assign('navigation1','权限设置');
        $this->assign('navigation2','权限管理');
        return view('auth');
    }
    /*
     * 增加权限
     */
    public function addAuth(){
        (new AddAuth('Auth/auth'))->goCheck();
        $params = input("post.");
        $authModel = new AuthModel();
        $authModel->auth_name = $params['auth_name'];
        $authModel->auth_pid = $params['auth_pid'];
        $authModel->auth_c = trim($params['auth_c']);
        $authModel->auth_a = trim($params['auth_a']);
        if($params['auth_pid'] == 0){
            $authModel->auth_level = 1;
        }else{
            $pidInfo = $authModel->where('auth_id','=',$params['auth_pid'])->find();
            $authModel->auth_level = $pidInfo['auth_level']+1;
        }
        $authModel->save();
        $id = $authModel->auth_id;
        $auth_path = $params['auth_pid']==0?$id:$params['auth_pid']."-".$id;
        
        $selfObj = AuthModel::get($id);
        $selfObj->auth_path = $auth_path;
        $selfObj->save();
        $this->success("添加成功","Auth/auth");
    }
    
    
    
}