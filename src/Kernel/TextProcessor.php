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
	 * 格式化词库 递归
	 * @Author xiaowu
	 * @param  array  $words   [配置文件里的词库]
	 * @param  array  $snstvwd [校验词库数组]
	 * @return [array]          [校验词库数组]
	 */
	public function fomateWords ( array $words, array $snstvwd = [] ) {
		foreach ($words as $key => $word) {
			$wordArr = preg_split('/(?<!^)(?!$)/u', $word);
			$this->ArrayToHashMap( $wordArr, $snstvwd );
		}
		return $snstvwd;
	}

	/**
	 * 通过循环处理单个敏感词
	 * @Author xiaowu
	 * @param  array  $wordArr  [敏感词分割数组]
	 * @param  [type] &$snstvwd [description]
	 */
	private function ArrayToHashMap ( array $wordArr, &$snstvwd ) {
		while ( isset($wordArr[0]) ) {

			$key = array_shift($wordArr);

			if ( !isset($snstvwd[$key]) ) {
				$snstvwd[$key] = [
					'next' => [],
					'end' => 0
				];
			}

			if ( !isset($wordArr[0]) ) {
				$snstvwd[$key]['end'] = 1;
			}

			$snstvwd = &$snstvwd[$key]['next'];

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
	 * 根据循环测试敏感词
	 * @Author xiaowu
	 * @param  array      $textArray    [原始文本队列]
	 * @param  array      $snstvwd      [敏感词树]
	 * @param  FilterWord &$filter_word [存放敏感词处理结果实体]
	 * @return [type]                   [description]
	 */
	private function testWords ( array $textArray, array $snstvwd, FilterWord &$filter_word) {
		$text_index = $origin_index = -1;
		while ( isset( $textArray[0] ) ) {
			/**
			 * 记录索引
			 * @param text_index 	敏感词在过滤后文本中的索引
			 * @param origin_index 	敏感词在原始文本中的索引
			 */
			$text_index++;
			$origin_index++;

			// 原始文本队列出队
			$key = array_shift( $textArray );

			// 判断是否存在在敏感词树中
			if ( isset( $snstvwd[$key] ) ) {

				// 将出队节点存入实体
				$filter_word->pushWordByIndex( $filter_word->getCount(), $text_index, $origin_index, $key);

				// 队头节点是否是树的子节点
				if ( isset( $snstvwd[$key]['next'][$textArray[0]] ) )

					// 如果属于树的子节点那就用该子节点继续匹配
					$snstvwd = $snstvwd[$key]['next'];
				else {
					// 敏感词状态是否是禁止
					if ( $snstvwd[$key]['end'] )
						// 改变敏感词索引以及词组索引
						$text_index += $filter_word->incrCount();
					// 敏感词匹配结束，初始化载体词组和敏感词树
					$this->initSnstvwd( $filter_word, $snstvwd );
				}

			} else {
				// 敏感词匹配结束，初始化载体词组和敏感词树
				$this->initSnstvwd( $filter_word, $snstvwd );
			}

		}
	}

	/**
	 * [初始化载体和敏感词树]
	 * @Author xiaowu
	 * @param  FilterWord &$filter_word [description]
	 * @param  array      &$snstvwd     [description]
	 * @return [type]                   [description]
	 */
	private function initSnstvwd (FilterWord &$filter_word, array &$snstvwd ) {
		$filter_word->clearWrodByIndex( $filter_word->getCount() );
		$snstvwd = $this->snstvwd;
	}

}