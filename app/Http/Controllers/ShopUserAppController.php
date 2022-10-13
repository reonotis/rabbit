<?php

namespace App\Http\Controllers;

use App\Consts\Common;
use App\Consts\SessionConst;
use App\Http\Controllers\Controller;
use App\Models\{Config, UserShop};
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ShopUserAppController extends Controller
{
    public $shopId;
    public $loginUser;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->loginUser = Auth::user();
            if($this->loginUser->authority_level == Common::AUTHORITY_RETIREMENT){
                // TODO リリース時にコメントアウトを外すこと
                session()->flash(SessionConst::FLASH_MESSAGE_ERROR, ['退職済みのユーザーです']);
                Redirect::route('error')->send();
            }

            // 操作できるショップがあるかチェックする
            $shopService = app()->make('ShopService');
            if(!$shopService->shopCheck($this->loginUser->id)){
                 Redirect::route('shop.select')->send();
            }
            $this->shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $routeCheck = $this->routeAuthCheck();
            if(!$routeCheck){
                dd('権限エラー');
            }
            return $next($request);
        });
    }

    public function routeAuthCheck(): bool
    {
        $routeName = \Route::currentRouteName();
        $userShopAuth = UserShop::getAuth($this->loginUser->id, $this->shopId);
        try {
            switch ($routeName) {
                case 'user.index':
                case 'user.show':
                    if(!$userShopAuth->user_read){
                        throw new Exception('ユーザー表示の権限がありません');
                    }
                    break;
                case 'user.create':
                case 'user.store':
                    if(!$userShopAuth->user_create){
                        throw new Exception('ユーザー作成の権限がありません');
                    }
                    break;
                case 'user.edit':
                    if(!$userShopAuth->user_edit){
                        throw new Exception('ユーザー編集の権限がありません');
                    }
                    break;
                // default:
                //     throw new Exception('権限チェックがありません');
            }
            return true;
        } catch (Exception $e) {
            Log::error( ' errorMsg : ' . $e->getMessage() . ' loginUserId=' . $this->loginUser->id);
            return false;
        }

    }
}
