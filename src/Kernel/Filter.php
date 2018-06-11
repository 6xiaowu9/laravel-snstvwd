<?php
namespace Snstvwd\Filter\Kernel;

use Illuminate\Session\SessionManager;
use Illuminate\Config\Repository;

    // use TextProcessor;
class Filter
{
    /**
     * @var SessionManager
     */
    protected $session;

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
    public function __construct(SessionManager $session, Repository $config)
    {
        $this->session = $session;
        $this->config = $config;
        $this->snstvwd = TextProcessor::fomateWords( $this->config['filter']['words'] );
    }

    // public function addWords ( $words ) {
    //     if ( !is_array( $words ) ) 
    //         $words = [$words];
    //     $this->snstvwd = $this->fomateWords( $words, $this->snstvwd );
    // }

    public function filter ( string $text ) {
        return $this->snstvwd;
        // $data = [
        //     'count' => 0,
        //     'sensitive' => []
        // ];
        // $textArr = preg_split('/(?<!^)(?!$)/u', $text);
        // $this->verification( $textArr, $this->snstvwd, $data);
        // return $data;
    }
}