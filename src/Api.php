<?php

namespace Sungmee\LaraApi;

use Illuminate\Http\Request;

class Api
{
    /**
     * 默认 Http 状态码
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * 七牛 Http 状态码
     *
     * @var int
     */
    protected $qiniuCode = [298,419,478,573,579,608,612,614,630,631,640,701];

    /**
     * 错误消息
     *
     * @var int
     *
    * 状态说明
    *
    * 200 GET 请求成功，及 DELETE 或 PATCH 同步请求完成，或者 PUT 同步更新一个已存在的资源
    * 201 POST 同步请求完成，或者 PUT 同步创建一个新的资源
    * 202 POST，PUT，DELETE，或 PATCH 请求接收，将被异步处理
    * 204 无内容。当一个动作执行成功，但没有内容返回。
    * 206 GET 请求成功，但是只返回一部分，参考：上文中范围分页

    * 400 Bad request. 错误的请求。无法通过验证的请求的标准选项。
    * 401 Unauthorized. 未经授权。用户需要进行身份验证。
    * 403 Forbidden. 无权限。用户已通过身份验证，但没有执行操作的权限。
    * 404 Not found. 未找到。没有找到相关资源。
    * 422 Unprocessable Entity. 请求被服务器正确解析，但是包含无效字段
    * 429 Too Many Requests. 因为访问频繁，你已经被限制访问，稍后重试

    * 500 Internal Server Error: 服务器错误。
    * 503 Service unavailable. 暂停服务。
     */
    protected $messages;

	/**
     * 创建一个新实例。
     *
     * @return void
     */
    public function __construct()
    {
		$this->messages = [
            // 1xx Informational
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            // 2xx Success
            200 => 'Ok', //* ★ GET 请求成功，及 DELETE 或 PATCH 同步请求完成，或者 PUT 同步更新一个已存在的资源
            201 => 'Created', //* ★ POST 同步请求完成，或者 PUT 同步创建一个新的资源
            202 => 'Accepted', //* ★ POST，PUT，DELETE，或 PATCH 请求接收，将被异步处理
            203 => 'Non-authoritative Information',
            204 => 'No Content', //* ★ 当一个动作执行成功，但没有内容返回时
            205 => 'Reset Content',
            206 => 'Partial Content', //* ★ GET 请求成功，但是只返回一部分，参考：上文中范围分页
            207 => 'Multi-Status',
            208 => 'Already Reported',
            226 => 'IM Used',
            298 => '部分操作执行成功。', // 【七牛】
            // 3xx Redirection
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            // 4xx Client Error
            400 => 'Bad Request', //* ★ 错误的请求。无法通过验证的请求的标准选项。
            401 => 'Unauthorized', //* ★ 认证授权失败。用户需要进行身份验证。
            402 => 'Payment Required',
            403 => 'Forbidden', //* ★ 权限不足，拒绝访问。用户已通过身份验证，但没有执行操作的权限。
            404 => 'Not Found', //* ★ 资源不存在。没有找到相关资源。
            405 => 'Method Not Allowed', // 请求方式错误，主要指非预期的请求方式。
            406 => 'Not Acceptable', // 上传的数据 CRC32 校验错误
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Payload Too Large', // 请求资源大小大于指定的最大值
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot',
            419 => '用户账号被冻结。', // 【七牛】
            421 => 'Misdirected Request',
            422 => 'Unprocessable Entity', //* ★ 请求被服务器正确解析，但是包含无效字段。
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests', //* ★ 因为访问频繁，你已经被限制访问，稍后重试。
            431 => 'Request Header Fields Too Large',
            444 => 'Connection Closed Without Response',
            451 => 'Unavailable For Legal Reasons',
            478 => '镜像回源失败。', // 【七牛】主要指镜像源服务器出现异常。
            499 => 'Client Closed Request',
            // 5xx Server Error
            500 => 'Internal Server Error', //* ★ 服务器错误。
            501 => 'Not Implemented',
            502 => 'Bad Gateway', // 错误网关
            503 => 'Service unavailable', //* ★ 服务端不可用，暂停服务。
            504 => 'Gateway Timeout', // 服务端操作超时
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            573 => '单个资源访问频率过高。', // 【七牛】
            579 => '上传成功但是回调失败。', // 【七牛】包括业务服务器异常；七牛服务器异常；服务器间网络异常。需要确认回调服务器接受 POST 请求，并可以给出 200 的响应。
            599 => 'Network Connect Timeout Error', // 服务端操作失败
            608 => '资源内容被修改。', // 【七牛】
            612 => '指定资源不存在或已被删除。', // 【七牛】
            614 => '目标资源已存在。', // 【七牛】
            630 => '已创建的空间数量达到上限，无法创建新空间。', // 【七牛】
            631 => '指定空间不存在。', // 【七牛】
            640 => '调用列举资源(list)接口时，指定非法的marker参数。', // 【七牛】
            701 => '在断点续上传过程中，后续上传接收地址不正确或ctx信息已过期。' // 【七牛】
        ];
    }

    public function __call($name, $args)
    {
        $field = preg_match('/^e(\d+)/', $name, $matches);
        if ($field && $matches[1]) {
            $statusCode = $matches[1];
            $errors     = isset($args[0]) ? $args[0] : null;
            $message    = isset($args[1]) ? $args[1] : null;
            return $this->e($errors, $statusCode, $message);
        }
    }

    /**
     * 出错时的相应方法。
     *
     * @param  string|array|object  $errors     出错明细
     * @param  int                  $statusCode 状态码
     * @param  string               $message    错误提示
     * @return json                 $this->response
     */
    public function e($errors = null, $statusCode = 400, $message = null)
    {
        // 捕获程序抛出的错误，并转化为正常错误消息。
        if (is_object($errors)) {
            $statusCode = $errors->getCode();
            $errors     = $errors->getMessage();
        }

        $this->statusCode = $statusCode;

        return $this->response([
            'errors'  => is_string($errors) ? ['error' => [__($errors)]] : $errors
        ], $message);
    }

    /**
     * 返回 204、数据或 503 错误。
     *
     * @param  bool|string|array    $data       表示完成与否的布尔值，或字符串数据，或数组数据。
     * @param  string               $error      错误消息
     * @return json   $response
     */
    public function or503($data, $error = null)
    {
        if (is_bool($data)) {
            return $data ? $this->ok() : $this->e503($error);
        }

        return empty($data) ? $this->ok() : $this->res($data);
    }

    /**
     * 请求数据的成功的标准响应方法
     *
     * @param  string|array $data
     * @return json         $this->response
     */
    public function res($data)
    {
        return $this->response(['data' => $data]);
    }

    /**
     * 不带数据的成功响应方法。
     *
     * @return json   $this->response
     */
    public function ok()
    {
        $this->statusCode = 204;

        return $this->response();
    }

    /**
     * 基本的响应方法
     *
     * @param  array  $data
     * @param  string $message
     * @return json   $response
     */
    public function response($data = [], $message = null)
    {
        $code = $this->isStatusCode() ? $this->statusCode : 503;
        $data['message'] = __($message ?: $this->messages[$code]);
        $statusCode = $this->isQiniuCode($code) ? 503 : $code;

        return response()->json($data, $statusCode);
    }

    /**
     * 判断是否 Http 状态码
     *
     * @return bool
     */
    private function isStatusCode()
    {
        $codes = array_keys($this->messages);
        return in_array($this->statusCode, $codes);
    }

    /**
     * 判断是否 七牛云专用 Http 状态码
     *
     * @param  int  $code
     * @return bool
     */
    private function isQiniuCode($code)
    {
        return in_array($code, $this->qiniuCode);
    }
}
