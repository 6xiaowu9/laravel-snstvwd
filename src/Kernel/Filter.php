<?php
namespace Snstvwd\Filter\Kernel;

use Illuminate\Config\Repository;
use Snstvwd\Filter\Facades\TextProcessor;

class Filter
{

    /**
     * @var Repository
     */
    protected $config;

    protected $snstvwd;
    /**
     * Packagetest constructor.
     * @param SessionManager $session
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config['filter'];
        $this->snstvwd = TextProcessor::fomateWords( $this->config['words'] );
    }

    /**
     * 动态添加词库
     * @Author xiaowu
     * @param  [string | array] $words [description]
     */
    public function addWords ( $words ) {
        if ( !is_array( $words ) ) 
            $words = [$words];
        $this->snstvwd = TextProcessor::fomateWords( $words, $this->snstvwd );
    }

    /**
     * 字符串过滤
     * @Author xiaowu
     * @param  string $text 字符串文本
     * @return [FilterWord]       词库过滤器实体
     */
    public function filter ( string $origin ) {
        return TextProcessor::verification( $origin, $this->snstvwd );
    }
}