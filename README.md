# express

## Introduction

Express query

## Install

```
$ composer require yanlongma/express
```

## Demo

```php
require __DIR__ . '/vendor/autoload.php';

// 初始化服务
$appCode = 'your appCode';
$server = new \YanlongMa\Express\Jisukdcx($appCode);

$express = new \YanlongMa\Express\Express($server);

// 查件
$info = $express->query('69576009311');
var_dump($info);

// 获取快递公司列表
$list = $express->company();
var_dump($list);

```