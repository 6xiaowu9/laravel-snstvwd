<?php
return [
	// 敏感词
    'words' => [
    	'傻逼', 
    	'fuck', 
    	'王八蛋', 
    	'王八羔子', 
    	'操', 
    	'操尼玛', 
    	'操你妈', 
    	'操你', 
    	'操你妹', 
    	'操你娘', 
    	'操你爹', 
    	'操你全家'
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