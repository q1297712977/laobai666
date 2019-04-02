<?php

namespace app\admin\model\robot\info;

use think\Model;

class Run extends Model
{
    // 表名
    protected $name = 'robot_info_run';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'currenttime_text'
    ];
    

    



    public function getCurrenttimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['currenttime']) ? $data['currenttime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCurrenttimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
