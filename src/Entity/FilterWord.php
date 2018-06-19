<?php 
namespace Snstvwd\Filter\Entity;
/**
 * 敏感词类
 */
class FilterWord
{
	// 敏感词出现数量
	private $count;
	// 出现过的敏感词
	private $words;
	// 敏感词树
	private $snstvwd;
	// 原始文本
	private $origin;
	// 过滤后的文本
	private $text;
	// 过滤后的节点文本
	private $textArray;
	// 是否替换敏感词
	private $word_replace;
	// 需要过滤敏感词为过滤字符的数量
	private $replace_size;
	// 过滤字符
	private $replace_str;
	// 是否需要强制补充字符
	private $force_replace;

	function __construct ( string $origin, bool $word_replace = true, int $replace_size = 0, string $replace_str = '*', bool $force_replace = false ) {
		$this->count = 0;
		$this->words = [];
		$this->origin = $origin;
		$this->setTextArray( $this->origin );
		$this->word_replace = $word_replace;
		$this->replace_size = $replace_size;
		$this->replace_str = $replace_str;
		$this->force_replace = $force_replace;
	}

	/**
	 * 获取数量
	 * @Author xiaowu
	 * @return [int] [敏感词数量]
	 */
	public function getCount () {
		return $this->count;
	}

	/**
	 * 增长数量
	 * @Author xiaowu
	 * @param  int|integer $incr [增长量]
	 * @return [int]            [偏移量]
	 */
	public function incrCount ( int $incr = 1 ) {
		$shifting = $this->word_replace ? $this->wordReplaceByIndex( $this->count ) : 0;
		$this->count += $incr;
		return $shifting;
	}

	/**
	 * 获取出现过的敏感词
	 * @Author xiaowu
	 * @return [array] [敏感词数组]
	 */
	public function getWords () {
		return $this->words;
	}

	/**
	 * 获取所有的敏感词树
	 * @Author xiaowu
	 * @return [array] [敏感词树]
	 */
	public function getSnstvwd () {
		return $this->snstvwd;
	}

	/**
	 * 设置所有的敏感词树
	 * @Author xiaowu
	 */
	public function setSnstvwd ( array $snstvwd ) {
		$this->snstvwd = $snstvwd;
	}

	/**
	 * 根据索引设置插入敏感词
	 * @Author xiaowu
	 * @param  int    $index    [敏感词索引]
	 * @param  int    $keyIndex [敏感词在原始文本中的索引]
	 * @param  string $key      [敏感词节点值]
	 */
	public function pushWordByIndex ( int $index, int $text_index, int $origin_index, string $key ) {
		if ( $this->issetWrodByIndex( $index ) )
			$this->words[$index]->pushKey( $key );
		else
			$this->words[$index] = new Word( $text_index, $origin_index, $key );
	}

	/**
	 * 根据索引清除敏感词
	 * @Author xiaowu
	 * @param  int    $index [敏感词索引]
	 */
	public function clearWrodByIndex ( int $index ) {
		unset($this->words[$index]);
	}

	/**
	 * 根据索引判断敏感词是否存在
	 * @Author xiaowu
	 * @param  int    $index [敏感词索引]
	 * @return [bool|boolean]
	 */
	public function issetWrodByIndex ( int $index ) {
		return isset($this->words[$index]);
	}

	/**
	 * 获取过滤后的文本节点数组
	 * @Author xiaowu
	 * @return [array]
	 */
	public function getTextArray () {
		return $this->textArray;
	}

	/**
	 * 获取过滤后的文本字符串
	 * @Author xiaowu
	 * @return [string]
	 */
	public function getText () {
		return $this->text;
	}

	/**
	 * 设置过滤后的文本
	 * @Author xiaowu
	 * @param  string $origin [原始文本]
	 */
	public function setText ( array $origin ) {
		$this->text =  implode($origin, '');
	}

	/**
	 * 设置需要过滤的文本节点
	 * @Author xiaowu
	 * @param  string $origin [原始文本]
	 */
	public function setTextArray ( string $origin ) {
		$this->textArray = preg_split('/(?<!^)(?!$)/u', $origin);
	}

	/**
	 * 获取原始文本
	 * @Author xiaowu
	 * @return [string] [description]
	 */
	public function getOrigin () {
		return $this->origin;
	}

	/**
	 * 设置原始文本
	 * @Author xiaowu
	 */
	public function setOrigin ( string $origin ) {
		$this->origin = $origin;
	}

	/**
	 * 根据索引删除过滤文本节点
	 * @Author xiaowu
	 * @param  int $index [索引]
	 */
	public function setRemoveTextByIndex ( int $index ) {
		unset( $this->textArray[$index] );
	}

	/**
	 * [根据索引设置文本节点为过滤替换字符]
	 * @Author xiaowu
	 * @param  [int] $index [索引]
	 */
	public function setTextToReplaceStrByIndex ( int $index ) {
		$this->textArray[$index] = $this->replace_str;
	}

	/**
	 * 获取是否需要替换为过滤字符串
	 * @Author xiaowu
	 * @return [bool|boolean] [description]
	 */
	public function getwordReplace () {
		return $this->word_replace;
	}

	/**
	 * 根据索引过滤替换文本
	 * @Author xiaowu
	 * @param  int    $index [索引]
	 * @return [int]        [偏移量]
	 */
	public function wordReplaceByIndex ( int $index ) {
		$word = $this->words[$index];
		for ( $i = 0; $i < $word->getLength(); $i++ ) {
			if ( $this->replace_size && $i > ($this->replace_size - 1) )
				$this->setRemoveTextByIndex( $word->getIndex()+$i );
			else
				$this->setTextToReplaceStrByIndex( $word->getIndex()+$i );
		}
		$shifting = 0;
		if ( $this->force_replace && $this->replace_size > $i  )
			$shifting = $this->pushReplaceStrByIndex( ( $word->getIndex()+$i ), ( $this->replace_size - $i ) );
		return $shifting;
	}
	/**
	 * 获取过滤字符
	 * @Author xiaowu
	 * @return [string] [过滤字符]
	 */
	public function getReplaceStr () {
		return $this->replace_str;
	}

	/**
	 * 根据索引和数量插入强制补齐过滤字符
	 * @Author xiaowu
	 * @param  int    $index  [索引]
	 * @param  int    $number [数量]
	 * @return [int]         [偏移量]
	 */
	public function pushReplaceStrByIndex ( int $index, int $number ) {
		$i = 0;
		while ( $i < $number) {
			$i++;
			array_splice($this->text, $index, 0, [$this->replace_str] );
		}
		$this->replace_str = $this->replace_str;
		return $number;
	}

	/**
	 * 获取过滤文字数量
	 * @Author xiaowu
	 * @return [int]
	 */
	public function getReplaceSize () {
		return $this->replace_size;
	}

	/**
	 * 获取强制补齐过滤字符
	 * @Author xiaowu
	 * @return [bool|boolean]
	 */
	public function getForceReplace () {
		return $this->force_replace;
	}

}