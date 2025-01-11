<?php
namespace App\Shop\Facades;

use Illuminate\Support\Facades\Facade;

class Compare extends Facade {
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'compare';
    }
}