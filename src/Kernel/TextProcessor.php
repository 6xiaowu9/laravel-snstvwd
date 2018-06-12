<?php 
namespace Snstvwd\Filter\Kernel;

use Snstvwd\Filter\Entity\Node;
use Snstvwd\Filter\Entity\FilterWord;
use Snstvwd\Filter\Entity\Word;
use Illuminate\Config\Repository;
/**
 * 文字处理器
 */
class TextProcessor 
{

	private $snstvwd;
	private $config;

	/**
	 * [__construct description]
	 * @Author xiaowu
	 * @param  Repository $config [读取配置文件]
	 */
	function __construct ( Repository $config ) {
		$this->config = $config['filter'];
	}

	/**
	 * 格式化词库
	 * @Author xiaowu
	 * @param  array  $words   [配置文件里的词库]
	 * @param  array  $snstvwd [校验词库数组]
	 * @return [array]          [校验词库数组]
	 */
	public function fomateWords ( array $words, array $snstvwd = [] ) {
		foreach ($words as $key => $word) {
			$wordArr = preg_split('/(?<!^)(?!$)/u', $word);
			$this->ArrayToHashArray( $wordArr, $snstvwd );
		}
		return $snstvwd;
	}

	/**
	 * 数组转换哈希数组
	 * @Author xiaowu
	 * @param  array  $wordArr  [词库数组]
	 * @param  [array] &$snstvwd [校验词库数组]
	 */
	private function ArrayToHashArray ( array $wordArr, &$snstvwd ) {
		$key = array_shift($wordArr);
		if ( isset( $snstvwd[$key] ) ) {
			if ( isset( $wordArr[0] ) ) {
				$this->ArrayToHashArray( $wordArr, $snstvwd[$key]->next );
			} else {
				$snstvwd[$key]->setEnd(true);
			}
			
		} else {
			$node = new Node;
			if ( isset( $wordArr[0] ) ) {
				$snstvwd[$key] = $node;
				$this->ArrayToHashArray( $wordArr, $snstvwd[$key]->next );
			} else {
				$snstvwd[$key] = $node->setEnd(true);
			}
		}
	}

	/**
	 * 校验敏感词
	 * @Author xiaowu
	 * @param  string       $text         [需要校验的文本]
	 * @param  array        $snstvwd      [校验词库数组]
	 * @return [FilterWord]               [词库过滤器实体]
	 */
	public function verification ( string $text, array $snstvwd ) {
		$this->snstvwd = $snstvwd;
        $filter_word = new FilterWord( 
						        	$text , 
						        	$this->config['word_replace'], 
						        	$this->config['replace_size'], 
						        	$this->config['replace_str'], 
						        	$this->config['force_replace'] );
		$textArray = $filter_word->getTextArray();
		$this->testWords ( $textArray, $snstvwd, $filter_word );
		return $filter_word;
	}

	/**
	 * 校验词库
	 * @Author xiaowu
	 * @param  array      &$textArr     [需要校验的文本数组]
	 * @param  array      $snstvwd      [校验词库数组]
	 * @param  FilterWord &$filter_word [词库过滤器实体]
	 * @param  integer    &$keyIndex    [记录需要校验的文本的索引]
	 */
	private function testWords ( array &$textArr, array $snstvwd, FilterWord &$filter_word, &$keyIndex = -1 ) {
		if ( isset( $textArr[0] ) ) {
			$key = array_shift($textArr);
			$keyIndex++;
			if ( isset($snstvwd[$key]) ) {
				$filter_word->setWordByIndex( $filter_word->getCount(), $keyIndex, $key);
				if ( count( $snstvwd[$key]->next ) > 0 && isset($snstvwd[$key]->next[$textArr[0]]) ) {
					$this->testWords( $textArr, $snstvwd[$key]->next, $filter_word, $keyIndex );
				}else{
					if ( $snstvwd[$key]->end )
						$keyIndex += $filter_word->incrCount();
					$this->testWords( $textArr, $this->snstvwd, $filter_word, $keyIndex );
				}
			}else{
				$filter_word->clearWrodByIndex( $filter_word->getCount() );
				$this->testWords( $textArr, $this->snstvwd, $filter_word, $keyIndex );
			}
		}
	}

}