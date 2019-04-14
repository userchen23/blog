<?php

namespace app\index\model;

use think\Model;
use think\Cache;
use cache\Cache as MyCache;
use cache\Cachev1 as MyCachev1;

class User extends Model
{
    /**
     * 原生redis
     * @Author   Maying
     * @DateTime 2019-03-31
     * @E-mail   1977905246@qq.com
     * @param    [type]            $id [description]
     * @return   [type]                [description]
     */
    public function getInfoById($id) {
        $redis = new \Redis();
        $redis->connect('192.168.199.249', '6379');

        $key = "user_info_{$id}";
        $info = $redis->get($key);

        if (empty($info)) {
            $info = $this->where('id', $id)->find();
            $info = $info->toArray();
            $info = serialize($info);
            $redis->setex($key, 600, $info);
        }

        $info = unserialize($info);
        return $info;
    }

    /**
     * think cache
     * 以后可能会常用，think集成
     * @Author   Maying
     * @DateTime 2019-03-31
     * @E-mail   1977905246@qq.com
     * @param    [type]            $id [description]
     * @return   [type]                [description]
     */
    public function getInfoByIdv1($id) {
        $key = "user_info_{$id}";
        $info = Cache::get($key);
        if (empty($info)) {
            $info = $this->where('id', $id)->find();
            $info = $info->toArray();
            Cache::set($key,$info,600);
        }
        return $info;
    }

    /**
     * 基于公共函数的 链接redis
     * @Author   Maying
     * @DateTime 2019-03-31
     * @E-mail   1977905246@qq.com
     * @param    [type]            $id [description]
     * @return   [type]                [description]
     */
    public function getInfoByIdv2($id) {
        $key = "user_info_{$id}";
        $info = redis_cache_get($key);
        if (empty($info)) {
            $info = $this->where('id', $id)->find();
            $info = $info->toArray();
            redis_cache_set($key, $info);
        }
        return $info;
    }

    /**
     * 基于静态方法的 链接redis
     * @Author   Maying
     * @DateTime 2019-03-31
     * @E-mail   1977905246@qq.com
     * @param    [type]            $id [description]
     * @return   [type]                [description]
     */
    public function getInfoByIdv3($id) {
        $key = "user_info_{$id}";
        $info = MyCache::cacheGet($key);
        if (empty($info)) {
            $info = $this->where('id', $id)->find();
            $info = $info->toArray();
            MyCache::cacheSet($key, $info);
        }
        return $info;
    }

    /**
     * 基于单例模式 链接redis
     * 日后要重点学习的，面试会问
     * @Author   Maying
     * @DateTime 2019-03-31
     * @E-mail   1977905246@qq.com
     * @param    [type]            $id [description]
     * @return   [type]                [description]
     */
    public function getInfoByIdv4($id) {
        $key = "user_info_{$id}";
        $info = MyCachev1::app()->cacheGet($key);
        if (empty($info)) {
            $info = $this->where('id', $id)->find();
            $info = $info->toArray();
            MyCachev1::app()->cacheSet($key,$info);
        }
        return $info;
    }
}