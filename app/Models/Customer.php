<?php

namespace App\Models;

use App\Consts\SessionConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     * @var array
     */
    protected $fillable = [
        'id',
        'customer_no',
        'f_name',
        'l_name',
        'f_read',
        'l_read',
        'sex',
        'tel',
        'email',
        'zip21',
        'zip22',
        'pref21',
        'address21',
        'street21',
        'shop_no',
        'staff_charge',
        'memo',
    ];

    /**
     * @param array $condition
     * @return object
     */
    public static function searchCustomer(array $condition): object
    {
        $query = self::select('customers.*', 'users.name');
        if(!empty($condition['customer_no'])){
            $query = (new Customer)->setWhereLike($query, 'customer_no', $condition['customer_no']);
        }
        if(!empty($condition['f_name'])){
            $query = (new Customer)->setWhereLike($query, 'f_name', $condition['f_name']);
        }
        if(!empty($condition['l_name'])){
            $query = (new Customer)->setWhereLike($query, 'l_name', $condition['l_name']);
        }
        if(!empty($condition['f_read'])){
            $query = (new Customer)->setWhereLike($query, 'f_read', $condition['f_read']);
        }
        if(!empty($condition['l_read'])){
            $query = (new Customer)->setWhereLike($query, 'l_read', $condition['l_read']);
        }
        if(!empty($condition['tel'])){
            $query = (new Customer)->setWhereLike($query, 'tel', $condition['tel']);
        }
        if(!empty($condition['sex'])){
            $query = $query->where('sex', $condition['sex']);
        }
        if(!empty($condition['email'])){
            $query = (new Customer)->setWhereLike($query, 'email', $condition['email']);
        }

        if(!empty($condition['staff_charge'])){
            $query = $query->where('staff_charge', $condition['staff_charge']);
        }
        if(empty($condition['other_shop'])){
            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $query = $query->where('shop_no', $shopId);
        }

        $query = $query->leftJoin('users', 'users.id', '=', 'customers.staff_charge');

        return $query;
    }

    /**
     * @param object $query
     * @param string $columName
     * @param string $values
     * @return object
     */
    public function setWhereLike(object $query, string $columName, string $values): object
    {
        // 全角スペースを半角スペースに変換
        $HANKAKUValues = mb_convert_kana($values, 's');

        // 半角スペース区切りで配列にする
        $valueArray = explode (' ' , $HANKAKUValues);

        foreach($valueArray AS $value){
            $query = $query->where($columName, 'LIKE', '%' . $value . '%');
        }
        return $query;
    }


}
