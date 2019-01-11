<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/10 0010
 * Time: 下午 3:11
 */

namespace App\Http\Controllers;

use App\Http\Model\CategoryModel;
use App\Http\ViewModel\TreeView;

/**
 * 无限分类
 * Class Category
 * @package App\Http\Controllers
 */
class Category extends Controller
{
    public function index()
    {
        $data = CategoryModel::getAllWhere([],'p_id');
        self::$data['tree_view'] = (new TreeView())->index($data);

        return view('category/inde',self::$data);
    }
}