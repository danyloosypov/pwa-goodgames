<?php
namespace App\Shop\Facades;

use Illuminate\Support\Facades\Facade;

class Fondy extends Facade {
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fondy';
    }
}