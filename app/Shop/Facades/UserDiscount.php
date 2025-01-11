<?php
namespace App\Shop\Facades;

use Illuminate\Support\Facades\Facade;

class UserDiscount extends Facade {
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'user_discount';
    }
}