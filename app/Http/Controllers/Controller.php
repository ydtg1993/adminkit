<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Lib\Response;

class Controller extends BaseController
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回成功响应
     *
     * @param null $data
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function success($data = null, $headers = [], $options = 0)
    {
        return $this->response('success', $data, $headers, $options);
    }


    /**
     * 返回错误
     *
     * @param null $message
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Response
     */
    public function error($message = null, $headers = [], $options = 0)
    {
        return $this->response('bad_request', $message, $headers, $options);
    }


    /**
     * 响应
     *
     * @param string $id
     * @param null $data
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Laravel\Lumen\Http\Redirector|Response
     */

    protected function response($id = 'success', $data = null, $headers = [], $options = 0)
    {
        $request = app('request');
        if ($request->ajax()) {
            return new Response($id, $data, is_array($headers) ? $headers : [], $options);
        }
        return is_string($headers) ? redirect($headers) : redirect()->back();
    }
}
