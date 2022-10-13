<?php

namespace App\Models;

use App\Consts\Common;
use App\Consts\DatabaseConst;
use App\Consts\SessionConst;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'authority_level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userShop()
    {
        $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
        return $this->hasOne(UserShop::class)
                    ->where('shop_id', $shopId)
                    ->where('delete_flag', DatabaseConst::FLAG_OFF);
    }

    public function userShops()
    {
        return $this->hasMany(UserShop::class)
                    ->where('delete_flag', DatabaseConst::FLAG_OFF);
    }

    /**
     * @param int $shopId
     * @param array $condition
     * @return object
     */
    public function myShopUsers(int $shopId, array $condition): object
    {
        $query = self::select('users.*')
            ->join('user_shops', 'user_shops.user_id', '=', 'users.id')
            ->where('user_shops.SHOP_id', '=', $shopId)
            ->where('user_shops.delete_flag', DatabaseConst::FLAG_OFF);

        if(!empty($condition)){
            if(!empty($condition['name'])){
                $query = $query->where('name', '=', $condition['name']);
            }
            if(!empty($condition['email'])){
                $query = $query->where('email', '=', $condition['email']);
            }
            if(!$condition['otherAuthorityLevel']){
                $query = $query->where('authority_level', '=', Common::AUTHORITY_ENROLLED);
            }
        }
        return $query;
    }

}
