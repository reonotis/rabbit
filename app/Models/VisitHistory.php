<?php

namespace App\Models;

use App\Consts\DatabaseConst;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisitHistory extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'shop_id',
        'user_id',
        'visit_date',
        'visit_time',
        'visit_reserve_id',
        'visit_type',
        'status',
        'memo',
    ];

    protected $dates = [
        'visit_time',
        'visit_date',
    ];

    /**
     * @param integer $id
     * @return object
     */
    public static function getTodayVisit(int $shopId)
    {
        $select = [
            'visit_histories.*',
            DB::raw('CONCAT (customers.f_name, " ", customers.l_name) AS customer_name'),
            'users.name AS user_name',
        ];

        return self::select($select)
            ->join('customers', 'visit_histories.customer_id', '=', 'customers.id')
            ->join('users', 'visit_histories.user_id', '=', 'users.id')
            ->where('visit_histories.visit_date', Carbon::now()->format('Y-m-d'))
            ->where('visit_histories.shop_id', $shopId)
            ->where('visit_histories.status', 1)
            ->orderBy('visit_histories.visit_time', 'ASC')
            ->get();
    }

    public static function getByCustomerId(int $customerId)
    {

        $select = [
            'visit_histories.*',
            'shops.shop_name',
            'menus.menu_name',
        ];
        $query = self::select($select)
            ->where('customer_id', $customerId)
            ->leftJoin('shops', 'shops.id', '=', 'shop_id')
            ->leftJoin('menus', 'menus.id', '=', 'menu_id')
        ;

        return $query;
    }



}
