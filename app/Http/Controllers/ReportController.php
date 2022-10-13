<?php

namespace App\Http\Controllers;

use App\Consts\SessionConst;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\{VisitHistory, VisitReserve};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ReportController extends ShopUserAppController
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
        $visitReserves = VisitReserve::getReservesByShop($shopId);
        $visitHistories = VisitHistory::getTodayVisit($shopId);
        return view('report.index', compact('visitReserves', 'visitHistories'));
    }

}
