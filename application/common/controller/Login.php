<?php

namespace app\common\controller;

use think\Controller;
use think\Request;
use app\common\library\Auth;
use think\Config;
use think\Hook;
use think\Lang;
class Login extends \fast\Auth
{

    public function index(){
        echo "1";
    }

}
