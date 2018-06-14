# 配置文件

本文档介绍了配置文件的使用，希望大家能在阅读后完美的使用配置文件。

## 生成配置文件

```
php artisan vendor:publish --provider="Snstvwd\Filter\Providers\FilterSerivceProvider"
```
执行后将会在你的项目目录下的config下生成一个filter.php文件

## 配置项
> ### word

敏感词
 
数组类型，代表需要过滤的敏感词，区分大小写。

```
'words' => [
        '傻逼', 
        'fuck', 
        '王八蛋', 
        '王八羔子', 
        '操'
    ],
```


> ### word_replace

是否需要替换敏感词为过滤字符

布尔值类型，如果为 <code>true</code> 将会把文本中的敏感词过滤为配置的过滤字符，反之则不会。

> ### replace_str

过滤字符

字符类型，当 <code>word_replace</code> 为 <code>true</code> 时，使用该字符替换敏感词。

> ### replace_size

替换位数

整数类型，当 <code>word_replace</code> 为 <code>true</code> 时，<code>replace_size</code> 为 <code>0</code> 时，代表不限制替换字符长度，当 <code>replace_size</code> 不为 <code>0</code> 时，代表替换敏感词的最多位数，如：敏感词为 <code>fuck</code> ，文本为 <code>fuck you</code> ，替换字符为 <code>?</code> ，那么替换后为 <code>??? you</code>。

> ### force_replace

强制补位

布尔类型，在以上条件下，且 <code>replace_size</code> 不为 <code>0</code> 时，<code>force_replace</code> 不为 <code>true</code> 时，敏感词替换过滤字符后不足 <code>replace_size</code> 长度将会将强制补位到 <code>replace_size</code> 的长度，如：敏感词为 <code>傻逼</code> ，文本为 <code>你是傻逼么？</code> ，替换字符为 <code>?</code> , <code>replace_size</code> 为 <code>3</code> ，<code>force_replace</code> 为 <code>true</code> ，那么替换后为 <code>你是???么？</code>;，<code>force_replace</code> 为 <code>false</code> 那么替换后为 <code>你是??么？</code> 


## <center>THANK YOU</center>