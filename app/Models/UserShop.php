<?php

namespace App\Models;

use App\Consts\{Common, DatabaseConst};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShop extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'user_id',
    ];


    public function shop()
    {
        return $this->hasone(shop::class, 'id', 'shop_id')
                    ->where('delete_flag', DatabaseConst::FLAG_OFF);
    }

    public function userShopAuthorization()
    {
        return $this->hasone(userShopAuthorization::class, 'user_shop_id', 'id')
                    ->where('delete_flag', DatabaseConst::FLAG_OFF);
    }

    /**
     * スタッフに紐づくショップを取得する
     *
     * @param int $userId
     * @return object
     */
    public static function getShopByUserId(int $userId): object
    {
        try {
            return self::select('shops.*')
                ->join('shops', 'shops.id', '=', 'user_shops.shop_id')
                ->join('user_shop_authorizations', 'user_shop_authorizations.user_shop_id', '=', 'user_shops.id')
                ->where('user_shops.user_id', $userId)
                ->where('shops.delete_flag', DatabaseConst::FLAG_OFF)
                ->where('user_shops.delete_flag', DatabaseConst::FLAG_OFF)
                ->get();
        } catch (Exception $e) {
            dd($e->getMessage(), 'getShopByUserId');
            return false;
        }
    }

    /**
     * @param int $shopId
     * @param int $userId
     * @return bool
     */
    public static function checkSelectableShop(int $shopId, int $userId): bool
    {
        $shop = self::where('shop_id', $shopId)->where('user_id', $userId)->first();
        if(empty($shop)){
            return false;
        }
        return true;
    }

    /**
     * @param int $userId
     * @param int $shopId
     * @return object
     */
    public static function getAuth(int $userId, int $shopId): object
    {
        $userShop = self::select('*')
            ->join('user_shop_authorizations', 'user_shop_authorizations.user_shop_id', '=', 'user_shops.id')
            ->where('user_shops.user_id', $userId)
            ->where('user_shops.shop_id', $shopId)->first();

        if(empty($userShop)){
            $userShop = new \stdClass();
        }
        return $userShop;
    }

}
