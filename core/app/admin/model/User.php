<?php
namespace app\admin\model;
use app\common\model\Admin;
use think\Log;

class User extends Admin
{
    //自动完成
    protected $auto = [];

    protected $insert = ['last_location' => '新建用户','last_login_ip' => '127.0.0.1','last_login_time'];

    //自动验证
    protected $validate = [
        'rule' => [
            'username' => 'require|unique:user'
        ],
        'msg' =>
        [
            'username.require' => '用户名称必须！',
            'username.unique' => '用户名称已经存在！'
        ]
    ];

    protected function setPasswordAttr($value)
    {
        return md5($value);
    }

    protected function setLastLoginTimeAttr()
    {
        return time();
    }

    // 获取所有用户信息
    public function getAllUser($where = '' , $order = 'id  ASC', $limit='') {
        return $this->where($where)->order($order)->limit($limit)->select();
    }

    // 获取单个用户信息
    public function getUser($where = '',$field = '*') {
        return $this->field($field)->where($where)->find();
    }

    // 删除用户
    public function delUser($where) {
        if($where){
            return $this->where($where)->delete();
        }else{
            return false;
        }
    }

    // 更新用户
    public function upUser($data) {
        if($data) {
            return $this->save($data);
        }else {
            return false;
        }
    }

    // 更新用户
    public function check_name($username,$user_id=0){

        if($user_id){   //编辑时查询
            $map['id']  = ['neq',$user_id];
            $map['username']  =['eq',$username];
        }else{  // 新增是查询
            $map['username']  = ['eq',$username];
        }
        return $this->where($map)->find();
    }
}