<?php

namespace App\Models;

use App\Consts\DatabaseConst;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisitReserve extends Model
{
    use HasFactory;

    /**
     * @param integer $id
     * @return object
     */
    public static function getReservesByShop(int $shopId, string $date = null)
    {
        $select = [
            'visit_reserves.*',
            DB::raw('CONCAT (customers.f_name, " ", customers.l_name) AS customer_name'),
            'users.name AS user_name',
        ];

        $query = self::select($select)
            ->join('customers', 'visit_reserves.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'visit_reserves.user_id', '=', 'users.id');
        if(empty($date)){
            $query = $query->where('visit_reserves.visit_date', Carbon::now()->format('Y-m-d'));
        }else{
            $query = $query->where('visit_reserves.visit_date', $date);
        }
        $query = $query->where('visit_reserves.shop_id', $shopId)
            ->where('visit_reserves.status', DatabaseConst::VISIT_RESERVES_STATUS_RESERVE)
            ->orderBy('visit_reserves.visit_time', 'ASC');
        return $query->get();
    }

}
