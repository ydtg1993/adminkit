<?php
/**
 * Created by PhpStorm.
 * User: ydtg1
 * Date: 2019/1/11
 * Time: 2:25
 */
/**
 * @param $date
 * @return string
 */
function hourglassTime($date)
{
    $time = strtotime($date);
    $differ = time() - $time;
    if ($differ < 60) {
        return $differ . ' 秒前';
    } elseif ($differ < 3600) {
        $minute = floor($differ / 60);
        return $minute . ' 分钟前';
    } elseif ($differ < 86400) {
        $hour = floor($differ / 3600);
        return $hour . ' 小时前';
    } elseif ($differ < (86400 * 7)) {
        $day = floor($differ / 86400);
        return $day . ' 天前';
    } elseif ($differ < (86400 * 30)) {
        $week = floor($differ / (86400 * 7));
        return $week . ' 周前';
    } elseif ($differ < (86400 * 365)){
        $months = floor($differ / (86400 * 30));
        return $months . ' 月前';
    }
    $year = floor($differ / (86400 * 365));
    return $year . ' 年前';
}

/**
 * 多条件查询二维数组 返回唯一值
 *
 * @param $array
 * @param array $params
 * @return array
 */
function getQuery2Array(array $array, array $params)
{
    foreach ($array as $item) {
        $flag = true;
        foreach ($params as $field => $value) {
            if ($item[$field] != $value) {
                $flag = false;
            }
        }
        if ($flag) {
            return $item;
        }
    }

    return [];
}

/**
 * 多条件查询二维数组
 *
 * @param $array
 * @param array $params
 * @return array
 */
function multiQuery2Array(array $array, array $params)
{
    $data = [];
    foreach ($array as $item) {
        $add = true;
        foreach ($params as $field => $value) {
            if ($item[$field] != $value) {
                $add = false;
            }
        }
        if ($add) {
            $data[] = $item;
        }
    }

    return $data;
}

/**
 * 多条件查询二维数组索引
 *
 * @param $array
 * @param array $params
 * @return bool|int|string
 */
function multiQuery2ArrayIndex(array $array, array $params)
{
    $index = false;
    foreach ($array as $key=>$item) {
        $add = true;
        foreach ($params as $field => $value) {
            if ($item[$field] != $value) {
                $add = false;
            }
        }
        if ($add) {
            $index = $key;
            break;
        }
    }

    return $index;
}

/**
 * 二维数组分组
 * @param $array
 * @param array $keys
 * @return array
 */
function group2Array(array $array,array $keys)
{
    $data = [];
    foreach ($array as $item){
        $group_key = '';
        foreach ($keys as $key){
            $group_key.= $item[$key].'|';
        }

        $data[$group_key][] = $item;
    }
    return $data;
}

/**
 * 根据值返回所有键
 * @param $array
 * @param $value
 * @return array
 */
function keysQueryByValue(array $array, $value)
{
    $keys = [];
    foreach ($array as $k => $v) {
        if ($v == $value) {
            $keys[] = $k;
        }
    }

    return $keys;
}

/**
 * @param string $id
 * @param string $p_id
 * @param array $array
 * @param array $tree
 */
function makeTree($id,$p_id,&$array,&$tree = [])
{
    if(empty($array)){
        return;
    }

    if(empty($tree)){
        $item = array_shift($array);
        $tree[$item[$id]] = [];
    }

    foreach ($tree as $branch=>&$leaves){
        foreach ($array as $key=>$value){
            if($value[$p_id] == $branch){
                $leaves[$value[$id]] = [];
                unset($array[$key]);
            }
        }

        if(!empty($leaves) && $array){
            makeTree($id,$p_id,$array,$leaves);
        }
    }
}

function createToken()
{
    $str = uniqid(mt_rand(),1).microtime();
    return sha1($str);
}

/**
 * @param $password
 * @param $token
 * @return string
 */
function packPassword($password,$token)
{
    return md5($password.DIRECTORY_SEPARATOR.$token);
}

/**
 * @param $url
 * @param array $vars
 * @param string $method
 * @param int $timeout
 * @param bool $CA
 * @param string $cacert
 * @return int|mixed|string
 */
function curlRequest($url, $vars = array(), $method = 'POST', $timeout = 10, $CA = false, $cacert = '')
{
    $method = strtoupper($method);
    $SSL = substr($url, 0, 8) == "https://" ? true : false;
    if ($method == 'GET' && !empty($vars)) {
        $params = is_array($vars) ? http_build_query($vars) : $vars;
        $url = rtrim($url, '?');
        if (false === strpos($url . $params, '?')) {
            $url = $url . '?' . ltrim($params, '&');
        } else {
            $url = $url . $params;
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout - 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-HTTP-Method-Override: {$method}"));

    if ($SSL && $CA && $cacert) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, $cacert);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    } else if ($SSL && !$CA) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    }

    if ($method == 'POST' || $method == 'PUT') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长
    }
    $result = curl_exec($ch);
    $error_no = curl_errno($ch);
    if (!$error_no) {
        $result = trim($result);
    } else {
        $result = $error_no;
    }

    curl_close($ch);
    return $result;
}