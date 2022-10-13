<?php

namespace App\Models;

use App\Consts\DatabaseConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     * @var array
     */
    protected $fillable = [
        'id',
        'shop_name',
        'shop_symbol',
        'email',
        'tel',
        'img_pass',
        'start_time',
        'end_time',
        'last_reception_time',
        'created_at',
        'updated_at',
        'delete_flag',
    ];

    public function userShops()
    {
        return $this->hasMany(UserShop::class)
            ->where('delete_flag', DatabaseConst::FLAG_OFF);
    }
}
