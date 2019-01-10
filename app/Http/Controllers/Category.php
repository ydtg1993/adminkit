<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 下午 3:11
 */

namespace App\Http\Controllers;

use App\Http\Model\CategoryModel;
/**
 * 无限分类
 * Class Category
 * @package App\Http\Controllers
 */
class Category extends Controller
{
    public function index()
    {
        self::$data['tree_view'] = CategoryModel::getCategoryTree();
        return view('category/index',self::$data);
    }
}