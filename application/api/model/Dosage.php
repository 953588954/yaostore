<?php
namespace app\api\model;

use think\Model;
class Dosage extends Model{
    protected $hidden = ['create_time','update_time','delete_time'];
}