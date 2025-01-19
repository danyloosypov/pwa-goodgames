<?php

namespace App\Models;

use App\FastAdminPanel\Models\MultilanguageModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends MultilanguageModel
{
    use HasFactory;

    const NEW = 1;
    const CANCELLED = 2;
    const COMPLETED = 3;
    const FAILED = 4;

    protected $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    #region Relationships
    
    

    #endregion
}