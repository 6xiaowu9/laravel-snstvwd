# 敏感词过滤器

PHP基于确定有穷自动机（DFA）敏感词过滤器，支持 Laravel 框架。

> ## 安装

### 1. 利用composer安装包

```
$ composer require snstvwd/filter
```

### 2. 在config/app.php 里面添加：

```

    'providers' => [
        .
        .
        .
        Snstvwd\Filter\Providers\FilterSerivceProvider::class
    ],
    
    'aliases' => [
        .
        .
        .
        'Filter' => Snstvwd\Filter\Facades\Filter::class
    ]

```

### 3. 创建配置文件

```
php artisan vendor:publish --provider="Snstvwd\Filter\Providers\FilterSerivceProvider"
```

### 4. 基本使用

```

use Filter;

public function test () {
    $text = '你是傻逼吗？';
    $filter = Filter::filter($text)->getText();
    dump($filter);
}
```

### 返回实例

```
你是???吗？
```

## 文档

### [配置文件](./doc/setting.md)
### [Filter的使用指南](./doc/filter.md)
### [FilterWrod的使用指南](./doc/filterword.md)

## <center>THANK YOU</center>