<?php

namespace App\Http\Controllers;

use App\Consts\SessionConst;
use App\Models\{Shop, UserShop};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ShopSelectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $shops = UserShop::getShopByUserId(Auth::user()->id);
        return view('shop.index', compact('shops'));
    }

    /**
     * 選択したショップをセッションに格納する
     * @param Shop  $shop
     * @return RedirectResponse
     */
    public function selecting(Shop $shop): RedirectResponse
    {
        try {
            // 対象のショップに紐づいているかチェック
            $result = UserShop::checkSelectableShop($shop->id, Auth::user()->id);
            if(empty($result)){
                throw new Exception('不正なアクセスです');
            }

            // 選択したショップをセッションに格納してマイページにリダイレクト
            session()->put(SessionConst::SELECTED_SHOP, $shop);
            return redirect()->route('myPage')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['選択しました']);
        } catch (Exception $e) {
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, [$e->getMessage()]);
        }
    }

    /**
     * 選択しているショップを解除して、店舗選択画面にリダイレクトする
     * @return RedirectResponse
     */
    public function deselect(): RedirectResponse
    {
        session()->forget(SessionConst::SELECTED_SHOP);
        return redirect()->route('shop.select');
    }

}
