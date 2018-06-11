<?php
namespace Snstvwd\Filter\Facades;
use Illuminate\Support\Facades\Facade;

class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filter';
    }
}