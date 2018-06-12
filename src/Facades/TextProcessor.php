<?php
namespace Snstvwd\Filter\Facades;
use Illuminate\Support\Facades\Facade;

class TextProcessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'textprocessor';
    }
}