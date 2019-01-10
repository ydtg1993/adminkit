<?php

namespace App\Http\Controllers;

use App\Http\Common\ResponseCode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public static $data = [
        'slug'=>'',
        'head'=>'',
        'user_info'=>[],
        'navigation'=>[]
    ];

    /**
     * @var Staticize
     */
    public static $STATICIZE;

    /**
     * @var Request
     */
    public static $REQUEST;

    /**
     * @var
     */
    public static $RESPONSE;

    public function __construct(Request $request)
    {
        self::$REQUEST = $request;
        self::$RESPONSE = ResponseCode::getInstance();
    }
}
