<?php 
namespace Snstvwd\Filter\Kernel;
/**
 * 文字处理器
 */
class TextProcessor 
{
	public function fomateWords ( array $words, array $snstvwd = [] ) {
		foreach ($words as $key => $word) {
			$wordArr = preg_split('/(?<!^)(?!$)/u', $word);
			$this->ArrayToHashArray( $wordArr, $snstvwd );
		}
		return $snstvwd;
	}

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

	public function verification ( array &$textArr, array $snstvwd, array &$data) {
		if ( isset( $textArr[0] ) ) {
			$key = array_shift($textArr);
			if ( isset($snstvwd[$key]) ) {
				if ( isset($data['sensitive'][$data['count']]) ) {
					$data['sensitive'][$data['count']] .= $key;
				}else{
					$data['sensitive'][$data['count']] = $key;
				}
				if ( count( $snstvwd[$key]->next ) > 0 && isset($snstvwd[$key]->next[$textArr[0]]) ) {
					$this->verification( $textArr, $snstvwd[$key]->next, $data );
				}else{
					if ( $snstvwd[$key]->end ) {
						$data['count']++;
					}
					$this->verification( $textArr, $this->snstvwd, $data );
				}
			}else{
				$this->verification( $textArr, $this->snstvwd, $data );
			}
		}
	}

	function getInstance()
    {
        static $instance = null;

        if ($instance === null) {
            $instance = new TextProcessor();
        }

        return $instance;
    }
    public static function __callStatic($method, $args)
    {
    	var_dump($method, $args);exit;
        $instance = static::getInstance();
        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }
        return $instance->$method(...$args);
    }
}