<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_login extends c_cabstract
{

    public $_isLogin = false;

    public function indexAction()
    {
        define('ADMIN_ACCOUT', 'admin');
        define('ADMIN_PWD', 'admin');

        if ($this->isPost()) {
            $account = $_POST['account'];
            $pwd     = $_POST['pwd'];
            //管理员判断
            if ($account == ADMIN_ACCOUT) {
                if ($account != ADMIN_ACCOUT || $pwd != ADMIN_PWD) {
                    $err = '账号或密码不正确';
                } else {
                    $_SESSION['auth']     = 1;
                    $_SESSION['username'] = 'admin';
                    header("Location: /");
                }
            }
        }
    }

}
