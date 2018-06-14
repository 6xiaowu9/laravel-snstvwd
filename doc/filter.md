# Filter使用指南

本文档将介绍Filter门面的使用指南，希望大家在阅读本文档后能够灵活的使用Filter。

## 如何引入Filter

在 config/app.php 配置如下别名

```
    'aliases' => [
        .
        .
        .
        'Filter' => Snstvwd\Filter\Facades\Filter::class
    ]

```

别名其实配置不配置都可以的，如果配置了我们就可以更方便的去使用Filter。

```
// 配置了别名我们就可以这样引入Filter
use Filter;

// 没有配置别名我们就需要这样引入Filter
use Snstvwd\Filter\Facades\Filter;
```

显然，我们配置了别名显得更加优雅便捷一些。

## Filter的基本使用

例子：

>config/filter.php

```
<?php
    return [
        data => [
            'fuck',
            'bitch'
        ],
        // 是否需要替换过滤字符
        'word_replace' => true,

        // 过滤字符
        'replace_str' => '?',

        // 替换位数
        'replace_size' => 3,

        // 是否需要强制补位
        'force_replace' => true,
    ];
```

> Test 

```
<?php 

// code

// 配置了别名我们就可以这样引入Filter
use Filter;

// 没有配置别名我们就需要这样引入Filter
//use Snstvwd\Filter\Facades\Filter;

// code

public function testFilter() {
    $text = 'bitch, fuck you!';
    $filtered = Filter::filter($text);
    $filteredText = $filtered->getText();
    dd($filteredText);
}

// code
```

返回实例：

```
"???, ??? you!"
```

## Filter提供的方法

### filter

概述： filter 方法为主要过滤方法，传入一个需要过滤的字符串文本，该方法会返回一个FilterWord的实体类，提供使用。

返回值: FilterWord, FilterWord是一个实体类，提供一些可用的方法，想要知道更多可以点击：<a href="./filterword.md">FilterWord使用指南</a>查看详细的FilterWord指南。

> 实例：

```
Filter::filter( string $text );
```

