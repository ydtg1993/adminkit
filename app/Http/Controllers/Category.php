<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 下午 3:11
 */

namespace App\Http\Controllers;

/**
 * 无限分类
 * Class Category
 * @package App\Http\Controllers
 */
class Category extends Controller
{
    public function index()
    {
        return view('category/index',self::$data);
    }
}