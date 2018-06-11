<?php 
namespace Snstvwd\Filter\Kernel;

 /**
  * 节点模型类
  */
 class Node
 {
 	public $next;
 	public $end;

 	/**
 	 * 构造函数 初始化模型
 	 * @Author xiaowu
 	 */
 	function __construct () {
 		$this->next = [];
 		$this->end = false;
 	}

 	/**
 	 * 添加下一个节点
 	 * @Author xiaowu
 	 * @param  string $next 下一个节点
 	 * @return [type]       [description]
 	 */
 	public function pushNext ( $next ) {
 		array_push($this->next, $next);
 		return $this;
 	}

 	/**
 	 * 获取下一个节点
 	 * @Author xiaowu
 	 * @return [Node]       [description]
 	 */
 	public function getNext () {
 		return $this->next;
 	}

 	/**
 	 * 设置结束 Tag
 	 * @Author xiaowu
 	 * @param  bool $end 单词结束Tag
 	 */
 	public function setEnd ( $end ) {
 		$this->end = $end;
 		return $this;
 	}
 	
 	/**
 	 * 设置结束 Tag
 	 * @Author xiaowu
 	 * @return [bool]       [description]
 	 */
 	public function getEnd () {
 		return $this->end;
 	}

 }