<?php
if (!function_exists('path_active')) {
    /**
     * 根据path设置菜单激活状态
     *
     * @param string|array $path
     * @param string $class
     * @return string
     */
    function path_active($path, $class = 'active')
    {
        $path = array_map(function ($p) {
            return explode('?', $p)[0];
        }, (array)$path);
        return call_user_func_array('\Request::is', (array)$path) ? $class : '';
    }
}
