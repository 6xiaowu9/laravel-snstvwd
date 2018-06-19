# FilterWord 指南

FilterWord 包含所有敏感词树、出现的敏感词、敏感词数量、源过滤文本，过滤后文本、过滤后的文本节点、以及一些敏感词配置参数。

## FilterWord 的属性方法

> ### getCount

获取文本中出现的敏感词数量。

> ### getWords

获取文本中出现过的敏感词数组，针对每一个敏感词中包含一些操作敏感词的方法。

> ### getSnstvwd

获取所有的敏感词树。

> getKey

该方法可以获取敏感词。

> getIndex

该方法可以获取敏感词在过滤后文本中的索引。

> getOriginIndex

该方法可以获取敏感词在源始文本中的索引。

> getLength

该方法可以获取敏感词的长度。

> ### getOrigin

获取原始文本。

> ### getText

获取过滤替换后的文本。

> ### getTextArray

获取文本节点。

> ### getwordReplace

获取配置信息：获取是否需要替换字符过滤。

> ### getReplaceStr

获取配置信息：过滤替换字符。

> ### getReplaceSize

获取配置信息：过滤替换字符长度。

> ### getForceReplace

获取配置信息：是否强制补位替换。

例子：
```
$filtered = Filter::filter('you are bitch!');

echo $filtered->getText();
// echo you are ???!

$words = $filtered->getWords();
dump( $words );
/*
    array:1 [▼
      0 => Word {#179 ▼
        #key: "bitch"
        #index: 8
        #origin_index: 8
        #length: 5
      }
    ]
*/
$word = $words[0];
echo $word->getLength();
// echo 5
```

## <center>THANK YOU</center>