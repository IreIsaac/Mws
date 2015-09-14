<?php
namespace IreIsaac\Mws\Support;

use Illuminate\Support\Facades\Facade;

class MwsFacade extends Facade
{
    protected static function getFacadeAccessor() { 
        return 'IreIsaac\Mws\Mws';
    }
}