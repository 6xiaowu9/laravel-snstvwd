<?php 
/**
 * 
 */
class Word
{
	protected $key;
	
	protected $index;

	public function getKey () {
		return $this->key;
	}

	public function setKey ($key) {
		$this->key = $key;
	}

	public function getIndex () {
		return $this->index;
	} 

	public function setIndex ($index) {
		$this->index = $index;
	}
}