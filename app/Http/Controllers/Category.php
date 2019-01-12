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
        $data = CategoryModel::orderBy('p_id', 'ASC')->orderBy('sort', 'DESC')->get();
        $data = $data->toArray();
        self::$data['tree_view'] = (new TreeView())->index($data);
        return view('category/index',self::$data);
    }

    public function operate()
    {

    }
}