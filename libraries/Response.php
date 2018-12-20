<?php
/**
 * Created by PhpStorm.
 * User: donggege
 * Date: 2018/11/12
 * Time: 17:34
 */

namespace Lib;

use Illuminate\Http\JsonResponse;

class Response extends JsonResponse
{
    /**
     * 状态及状态码
     *
     * @var array
     */
    private $status = [
        // request succeeded
        'success' => [200, '请求成功'],
        // resource created, for example a new app was created or an add-on was provisioned
        'created' => [201, '创建成功'],
        // request accepted, but the processing has not been completed
        'accepted' => [202, '请求已受理，将进行异步处理'],
        // request succeeded, but this is only a partial response, see ranges
        'partial_content' => [206, '部分数据返回'],
        // request invalid, validate usage and try again
        'bad_request' => [400, '非法请求'],
        // request not authenticated, API token is missing, invalid or expired
        'unauthorized' => [401, '需要登录'],
        // either the account has become delinquent as a result of non-payment, or the account’s payment method must be confirmed to continue
        'delinquent' => [402, '支付信息需要确认'],
        // request not authorized, provided credentials do not provide access to specified resource
        'forbidden' => [403, '权限不足'],
        // request not authorized, account or application was suspended.
        'suspended' => [403, '账户已被停用'],
        // request failed, the specified resource does not exist
        'not_found' => [404, '找不到页面'],
        // request failed, set Accept: application/vnd.heroku+json; version=3 header and try again
        'not_acceptable' => [406, '请求无法处理'],
        // request failed, validate Content-Range header and try again
        'requested_range_not_satisfiable' => [416, '请求超出范围'],
        // request failed, validate parameters try again
        'invalid_params' => [422, '参数无效'],
        // request failed, enter billing information in the Heroku Dashboard before utilizing resources.
        'verification_needed' => [422, '需要认证'],
        // request failed, wait for rate limits to reset and try again, see rate limits
        'rate_limit' => [429, '接口调用频率限制'],
        // error occurred, we are notified, but contact support if the issue persists
        'internal_server_error' => [500, '无法处理的请求'],
        // API is unavailable, check response body or Heroku status for details
        'service_unavailable' => [503, '服务器异常'],
    ];

    /**
     * 构造函数
     *
     * @param string $id
     * @param mixed $data
     * @param array $headers
     * @param int $options
     */
    public function __construct($id = 'success', $data = null, $headers = [], $options = 0)
    {
        list($code, $message) = $this->status[$id];
        $data = is_string($data) ? ['message' => $data] : $data;

        if ($code < 200 || $code >= 300) {
            $data = array_merge(['id' => $id, 'message' => $message], $data);
        }

        parent::__construct($data, $code, $headers, $options);
    }

    /**
     * 静态创建方法
     *
     * @param string $id
     * @param mixed $data
     * @param array $headers
     * @param int $options
     * @return static
     */
    public static function create($id = 'success', $data = null, $headers = [], $options = 0)
    {
        return new static($id, $data, $headers, $options);
    }
}