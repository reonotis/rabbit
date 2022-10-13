<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShopAuthorization extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     * @var array
     */
    protected $fillable = [
        'user_shop_id',
        'user_read',
        'user_create',
        'user_edit',
        'user_delete',
        'customer_read',
        'customer_create',
        'customer_edit',
        'customer_delete',
        'reserve_read',
        'reserve_create',
        'reserve_edit',
        'reserve_delete',
    ];


}
