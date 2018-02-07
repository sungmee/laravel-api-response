# Laravel API Response

易于使用的 Laravel API 响应扩展包。

## 安装

在 Laravel 项目根目录的 composer.json 文件的 `require` 中加入 `"Sungmee/laravel-api-response": "dev-master",`，然后命令行运行 `composer update`。

就这些了。

## 使用

```php
// 正常响应 - 将 $data 包裹在 ['data' => $data] 以 Json 格式相应
$data = 'string|array|bool';
\Api::res($data);

// 204 响应 - 空响应正文
\Api::ok();

// 自动根据内容相应：204，正常响应或 503 错误
$data = 'bool:true'; // 204
$data = 'bool:false'; // 503
$data = 'string|array'; // 正常响应
\Api::or503($data);

// 错误响应
$errors = 'string|array|object'; // 具体错误内容，如果为 object 则应为程序抛出的错误 \Exception，将自动转为普通错误响应。
$statusCode = 'null|int'; // 状态码，默认 400
$message = 'null|string'; // 错误消息，默认根据状态码显示
\Api::e($errors, $statusCode, $message);

// 自定义状态码错误响应
\Api::e404($errors, $message);
\Api::e422();
\Api::e500();
...
```