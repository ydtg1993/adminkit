<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30 0030
 * Time: 下午 2:35
 */

namespace App\Http\Common;


use Illuminate\Support\Facades\Redis;

class RedisDriver
{
    private static $RM;
    private static $config;
    public $redis;


    private function __construct()
    {
        $this->redis = Redis::connection();
    }

    public static function getInstance()
    {
        if(self::$RM == null) {
            self::$config = config('redis_key');
            self::$RM = new self();
        }
        return self::$RM;
    }

    public function getCacheKey($name, ...$params)
    {
        $pos = strpos($name, '.');

        if (!is_int($pos)) {
            throw new \Exception('未设定键值');
        }

        $name_type = substr($name, 0, $pos);
        $name_key = substr($name, $pos + 1);
        if (!isset(self::$config[$name_type][$name_key])) {
            throw new \Exception('未设定键值');
        }

        switch ($name_type){
            case 'key':
                $this->redis->select(1);
                break;
            case 'cache':
                $this->redis->select(2);
                break;
            case 'list':
                $this->redis->select(3);
                break;
            case 'hash':
                $this->redis->select(4);
                break;
            case 'active':
                $this->redis->select(14);
                break;
        }

        $cache = (string)self::$config[$name_type][$name_key];

        foreach ($params as $k => $param) {
            $cache .= '_'.$param;
        }

        return $cache;
    }

}