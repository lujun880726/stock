<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class c_admin extends c_cabstract
{

    public $_bg      = true;
    public $_isLogin = true;

    public function __construct()
    {
        $this->_isLogin = true;
    }

    /**
     * 后台主页
     */
    public function indexAction()
    {
        return array('urlid' => 0);
    }

    /**
     * 新闻添加
     * @return type
     */
    public function newsAddAction()
    {
        if ($this->isPost()) {
            $this->_paraArr = $_POST;

            // TODO 处理提交的数据注入
            $title = $this->getx('title');
            if (empty($title)) {
                return array('urlid' => 1, 'err' => '标题不能为空!', 'data' => $this->_paraArr);
            }

            $newsType = $this->getInt('news_type');
            if ($newsType < 1) {
                return array('urlid' => 1, 'err' => '类型不能为空!', 'data' => $this->_paraArr);
            }

            $content = $this->getx('content');
            if (empty($content)) {
                return array('urlid' => 1, 'err' => '内容不能为空!', 'data' => $this->_paraArr);
            }
            $inArr = array(
                'title'     => $title,
                'news_type' => $newsType,
                'content'   => $content,
                'ctime'     => time(),
                'state'     => 1, // 直接发布
            );
            $id    = $this->getInt('id');
            if ($id < 1) {
                $flag = model('news')->cnews($inArr);
                if (empty($flag)) {
                    $err = '提交出错';
                } else {
                    $err = '新建成功';
                }
                return array('urlid' => 1, 'err' => $err, 'data' => array());
            } else {
                unset($inArr['ctime']);
                $inArr['utime'] = time();
                $flag           = model('news')->update($inArr, '`id` = ' . $id);
                if (empty($flag)) {
                    $err = '更新出错';
                } else {
                    $err = '更新成功';
                }
                return array('urlid' => 1, 'err' => $err, 'data' => $this->_paraArr);
            }
        }
        $id   = $this->getInt(0);
        $data = array();
        $err  = '';
        if ($id > 0) {
            $data = model('news')->row($id);
            if (empty($data)) {
                $data = array();
                $err  = '此条数据不存在请新建';
            }
        }
        return array('urlid' => 1, 'err' => $err, 'data' => $data);
    }

    /**
     * 新闻列表
     */
    public function newsListAction()
    {
        // 列表分页
        $page     = max(1, intval($this->getInt(0)));
        $pageSize = 10;
        $start    = ($page - 1 ) * $pageSize;

        $where = array();
        $count = 0;
        $list  = array();
        //查询
        $count = model('news')->getCnt($where);

        if ($count) {
            $list = model('news')->getPage($where, $start, $pageSize);
        }


        return array('urlid' => 2, 'list' => $list, 'page' => $page, 'cnt' => ceil($count / $pageSize));
    }

    /**
     * 物品添加
     * @return type
     */
    public function goodsAddAction()
    {
        $err         = '';
        $data        = array();
        $goodsTypeKV = model('goods')->goodsTypeKV();
        if ($this->isPost()) {
            $this->_paraArr = $_POST;

            // TODO 处理提交的数据注入
            $goodsName = $this->getx('goods_name');
            if (empty($goodsName)) {
                return array('urlid' => 3, 'err' => '物品名称不能为空!', 'data' => $this->_paraArr, 'goodsTypeKV' => $goodsTypeKV);
            }

            $goodsType = $this->getInt('goods_type');
            if ($goodsType < 1) {
                return array('urlid' => 3, 'err' => '类型不能为空!', 'data' => $this->_paraArr, 'goodsTypeKV' => $goodsTypeKV);
            }

            $goodsContent = $this->getx('goods_content');
            if (empty($goodsContent)) {
                return array('urlid' => 3, 'err' => '内容不能为空!', 'data' => $this->_paraArr, 'goodsTypeKV' => $goodsTypeKV);
            }

            $goodsImg = $this->getx('goods_img');
            if (empty($goodsContent)) {
                return array('urlid' => 1, 'err' => '图片不能为空!', 'data' => $this->_paraArr, 'goodsTypeKV' => $goodsTypeKV);
            }
            $inArr = array(
                'goods_name'    => $goodsName,
                'goods_type'    => $goodsType,
                'goods_content' => $goodsContent,
                'goods_img'     => $goodsImg,
                'ctime'         => time(),
                'state'         => 1, // 直接发布
            );
            $id    = $this->getInt('id');
            if ($id < 1) {
                $flag = model('goods')->cgoods($inArr);
                if (empty($flag)) {
                    $err = '提交出错';
                } else {
                    $err = '新建成功';
                }
            } else {
                unset($inArr['ctime']);
                $inArr['utime'] = time();
                $flag           = model('goods')->goodsupdate($inArr, '`id` = ' . $id);
                if (empty($flag)) {
                    $err = '更新出错';
                } else {
                    $err = '更新成功';
                }
            }
            $data = $this->_paraArr;
        }
        $id = $this->getInt(0);


        if ($id > 0) {
            $data = model('goods')->goodsrow($id);
            if (empty($data)) {
                $data = array();
                $err  = '此条数据不存在请新建';
            }
        }

        return array('urlid' => 3, 'err' => $err, 'data' => $data, 'goodsTypeKV' => $goodsTypeKV);
    }

    /**
     * 物品列表
     */
    public function goodsListAction()
    {
        // 列表分页
        $page     = max(1, intval($this->getInt(0)));
        $pageSize = 5;
        $start    = ($page - 1 ) * $pageSize;

        $where = array();
        $count = 0;
        $list  = array();
        //查询
        $count = model('goods')->goodsCnt($where);

        if ($count) {
            $list = model('goods')->goodsPage($where, $start, $pageSize);
        }


        return array('urlid' => 4, 'list' => $list, 'page' => $page, 'cnt' => ceil($count / $pageSize));
    }

    /**
     * 物品分类
     */
    public function goodsTypeAction()
    {
        $err          = '';
        $goodsTypeArr = array();

        $id = $this->getInt(0);

        if ($this->isPost()) {
            $this->_paraArr = $_POST;
            $typeName       = $this->getx('type_name');
            if (empty($typeName)) {
                $err = '分类名不能为空';
            } else {

                $inArr = array('type_name' => $typeName);
                if ($id < 1) {
                    $inArr['ctime'] = time();
                    $flag           = model('goods')->cGoodsType($inArr);
                    if (empty($flag)) {
                        $err = '提交出错';
                    } else {
                        $err = '新建成功';
                    }
                } else {
                    $inArr['utime'] = time();
                    $flag           = model('goods')->uGoodsType($inArr, '`id` = ' . $id);
                    if (empty($flag)) {
                        $err = '更新出错';
                    } else {
                        $err = '更新成功';
                    }
                }
            }
        }

        if ($id > 0) {
            $goodsTypeArr = model('goods')->rowGoodsType($id);
            if (empty($goodsTypeArr)) {
                $goodsTypeArr = array();
                $err          = '此条数据不存在请新建';
            }
        }
        $list = model('goods')->goodsTypeAll();
        return array('urlid' => 5, 'err' => $err, 'goodsTypeArr' => $goodsTypeArr, 'list' => $list);
    }

    /**
     * 删除物品分类
     */
    public function delGoodsTypeAction()
    {

    }

    public function pageAddAction()
    {
        if ($this->isPost()) {
            $this->_paraArr = $_POST;

            // TODO 处理提交的数据注入
            $pageName = $this->getx('page_name');
            if (empty($pageName)) {
                return array('urlid' => 1, 'err' => '页面名不能为空!', 'data' => $this->_paraArr);
            }

            $content = $this->getx('page_val');
            if (empty($content)) {
                return array('urlid' => 1, 'err' => '内容不能为空!', 'data' => $this->_paraArr);
            }

            $inArr = array(
                'page_name' => $pageName,
                'page_val'  => $content,
                'ctime'     => time(),
            );
            $id    = $this->getInt('id');
            if ($id < 1) {
                $flag = model('pageConf')->cpageconf($inArr);
                if (empty($flag)) {
                    $err = '提交出错';
                } else {
                    $err = '新建成功';
                }
                return array('urlid' => 6, 'err' => $err, 'data' => array());
            } else {
                unset($inArr['ctime']);
                $inArr['utime'] = time();
                $flag           = model('pageConf')->update($inArr, '`id` = ' . $id);
                if (empty($flag)) {
                    $err = '更新出错';
                } else {
                    $err = '更新成功';
                }
                return array('urlid' => 6, 'err' => $err, 'data' => $this->_paraArr);
            }
        }
        $id   = $this->getInt(0);
        $data = array();
        $err  = '';
        if ($id > 0) {
            $data = model('pageConf')->row($id);
            if (empty($data)) {
                $data = array();
                $err  = '此条数据不存在请新建';
            }
        }
        return array('urlid' => 6, 'err' => $err, 'data' => $data);
    }

    public function pageListAction()
    {
        // 列表分页
        $page     = max(1, intval($this->getInt(0)));
        $pageSize = 10;
        $start    = ($page - 1 ) * $pageSize;

        $where = array();
        $count = 0;
        $list  = array();
        //查询
        $count = model('pageConf')->getCnt($where);

        if ($count) {
            $list = model('pageConf')->getPage($where, $start, $pageSize);
        }
        return array('urlid' => 7, 'list' => $list, 'page' => $page, 'cnt' => ceil($count / $pageSize));
    }

}
