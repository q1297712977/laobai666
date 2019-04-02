<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use app\common\library\Token;
use app\common\controller\Backend;
use think\Model;
use think\Db;

class Index extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';


    protected $relationSearch = true;

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        // $id = session('admin')['id'];
        // $auth_id = Db::name('auth_group_access')->where('uid',$id)->find();
        // var_dump($auth_id);
        // $auth_list = Db::name('auth_group')->where('id',$auth_id['group_id'])->find();
        // var_dump($auth_list);
        list($menulist, $navlist, $fixedmenu, $referermenu) = $this->auth->getSidebar(
            [
            'dashboard' => 'hot',
            'addon'     => ['new', 'red', 'badge'],
            'auth/rule' => __('Menu'),
            'general'   => ['new', 'purple'],
        ], $this->view->site['fixedpage']);
        $action = $this->request->request('action');
        if ($this->request->isPost()) {
            if ($action == 'refreshmenu') {
                $this->success('', null, ['menulist' => $menulist, 'navlist' => $navlist]);
            }
        }

        // echo "<pre>";
        var_dump($menulist);
        // 所有权限列表
        $this->view->assign('menulist', $menulist);
        $this->view->assign('navlist', $navlist);
        $this->view->assign('fixedmenu', $fixedmenu);
        $this->view->assign('referermenu', $referermenu);
        $this->view->assign('title', __('Home'));
        return $this->view->fetch();
    }


    public function news()
    {
        $newslist = [];
        return jsonp(['newslist' => $newslist, 'new' => count($newslist), 'url' => 'https://www.fastadmin.net?ref=news']);
    }

}
