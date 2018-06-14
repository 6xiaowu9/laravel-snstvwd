<?php 
namespace Snstvwd\Filter\Entity;
/**
 * 
 */
class Word
{
	// 敏感词
	protected $key;
	// 敏感词在过滤后文本中的索引
	protected $index;
	// 敏感词在原始本中的索引
	protected $origin_index;
	// 敏感词长度
	protected $length;

	function __construct ( $index, $origin_index, $key ) {
		$this->key = $key;
		$this->index = $index;
		$this->origin_index = $origin_index;
		$this->length = 1;
	}

	/**
	 * 获取敏感词
	 * @Author xiaowu
	 * @return [string]
	 */
	public function getKey () {
		return $this->key;
	}

	/**
	 * 设置敏感词
	 * @Author xiaowu
	 * @param  [string] $key 
	 */
	public function setKey ($key) {
		$this->key = $key;
	}

	/**
	 * 插入单词节点值
	 * @Author xiaowu
	 * @param  [string] $key [结点值]
	 */
	public function pushKey ( string $key ) {
		$this->key .= $key;
		$this->incrLength();
	}

	/**
	 *获取敏感词在文本中的索引
	 * @Author xiaowu
	 * @return [int]
	 */
	public function getIndex () {
		return $this->index;
	} 

	/**
	 * 设值敏感词在文本中的索引
	 * @Author xiaowu
	 * @param  [int] $index
	 */
	public function setIndex ( int $index ) {
		$this->index = $index;
	}

	/**
	 *获取敏感词在原始文本中的索引
	 * @Author xiaowu
	 * @return [int]
	 */
	public function getOriginIndex () {
		return $this->index;
	} 

	/**
	 * 设值敏感词在原始文本中的索引
	 * @Author xiaowu
	 * @param  [int] $index
	 */
	public function setOriginIndex ( int $index ) {
		$this->origin_index = $origin_index;
	}

	/**
	 * 获取单词长度
	 * @Author xiaowu
	 * @return [int] [单词长度]
	 */
	public function getLength () {
		return $this->length;
	} 

	/**
	 * 自动增加单词长度
	 * @Author xiaowu
	 */
	public function incrLength () {
		$this->length++;
	}
}