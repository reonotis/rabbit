<?php

namespace App\Http\Controllers;

use App\Consts\{DatabaseConst, SessionConst};
use App\Models\{VisitHistory, VisitReserve};
use App\Http\Requests\StoreVisitReserveRequest;
use App\Http\Requests\UpdateVisitReserveRequest;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class VisitReserveController extends ShopUserAppController
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @param VisitReserve $visitReserve
     * @return RedirectResponse
     */
    public function visited(VisitReserve $visitReserve): RedirectResponse
    {
        if($visitReserve->visit_date <> \Carbon\Carbon::now()->format('Y-m-d')){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['本日の予約ではありません']);
        }

        if($visitReserve->status <> DatabaseConst::VISIT_RESERVES_STATUS_RESERVE){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['ステータスが予約中のデータではありません']);
        }

        $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
        if($shopId <> $visitReserve->shop_id){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['該当ショップのデータではありません']);
        }

        // 予約テーブルを来店済みにする
        $visitReserve->status = DatabaseConst::VISIT_RESERVES_STATUS_VISIT;
        $visitReserve->save();

        // 来店情報に登録する
        $visitHistory = VisitHistory::create([
            'customer_id' => $visitReserve->customer_id,
            'shop_id' => $visitReserve->shop_id,
            'user_id' => $visitReserve->user_id,
            'visit_date' => $visitReserve->visit_date,
            'visit_time' => $visitReserve->visit_time,
            'visit_reserve_id' => $visitReserve->id,
            'visit_type' => 1,
            'status' => 1,
            'memo' => $visitReserve->memo,
        ]);


        return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['来店情報に登録しました']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        return redirect()->route('reserve.list', ['date' => $date]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function list($date = null): View
    {
        $shop = session()->get(SessionConst::SELECTED_SHOP);

        // ショップの予約を取得
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $shopReserves = VisitReserve::getReservesByShop($shop->id, $date)->toArray();
        $reserveUsers = $this->makeArrayReserve($shopReserves);

        // 営業時間の配列を作成
        $timeArray = CarbonPeriod::create($date . $shop->start_time, $date . $shop->end_time)->minutes(30)->toArray();
        array_pop($timeArray);
        $endTime = $timeArray[array_key_last($timeArray)];

        return view('reserve.index', compact('shop', 'timeArray', 'endTime', 'reserveUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitReserveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitReserveRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisitReserve  $visitReserve
     * @return \Illuminate\Http\Response
     */
    public function show(VisitReserve $visitReserve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitReserve  $visitReserve
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitReserve $visitReserve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitReserveRequest  $request
     * @param  \App\Models\VisitReserve  $visitReserve
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitReserveRequest $request, VisitReserve $visitReserve)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VisitReserve $visitReserve
     * @return RedirectResponse
     */
    public function destroy(VisitReserve $visitReserve): RedirectResponse
    {
        if($visitReserve->visit_date <> \Carbon\Carbon::now()->format('Y-m-d')){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['本日の予約ではありません']);
        }

        if($visitReserve->status <> DatabaseConst::VISIT_RESERVES_STATUS_RESERVE){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['ステータスが予約中のデータではありません']);
        }

        $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
        if($shopId <> $visitReserve->shop_id){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['該当ショップのデータではありません']);
        }

        // 予約テーブルから論理削除する
        $visitReserve->status = DatabaseConst::VISIT_RESERVES_STATUS_DELETE;
        $visitReserve->save();

        return redirect()->back()->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['予約を削除しました']);
    }

    /**
     * @param array $visitReserve
     * @return array
     */
    private function makeArrayReserve(array $visitReserve): array
    {
        $sortUserArray = $this->sortByUser($visitReserve);
        $usersArray = $this->makeUsersRow($sortUserArray);
        return $usersArray;
    }

    /**
     * 全ての予約をユーザー毎にまとめる
     * @param array $visitReserve
     * @return array $sortedArray[$userName][0][array[$id => $reserve]]
     * 例) array:2 [▼
     *          "佐藤 花子" => array:1 [▼
     *              0 => array:2 [▼
     *                  719 => array:13 [▶]
     *                  799 => array:13 [▶]
     *              ]
     *          ]
     *          "山田 太郎" => array:1 [▼
     *              0 => array:4 [▼
     *                  92 => array:13 [▶]
     *                  377 => array:13 [▶]
     *                  1 => array:13 [▶]
     *                  2 => array:13 [▶]
     *              ]
     *          ]
     *     ]
     */
    private function sortByUser(array $visitReserve): array
    {
        $sortedArray = [];
        foreach($visitReserve AS $reserve){
            $sortedArray[$reserve['user_name']][$reserve['id']] = $reserve;
        }

        if(array_key_exists('', $sortedArray)){
            $v = $sortedArray[''];
            unset($sortedArray['']);
            $sortedArray['未設定'] = $v;
        }
        return $sortedArray;
    }

    /**
     *
     * @param array $sortUserArray
     * @return array
     */
    private function makeUsersRow(array $sortUserArray): array
    {
        $newArray = [];
        foreach($sortUserArray AS $userName => $userArray){
            // ユーザーの予約を来店時間順に並び替える
            array_multisort(array_column($userArray, 'visit_time'), SORT_ASC, $userArray);

            $count = 1;
            do {
                $previousFinishesTime = '10:00:00'; // 営業開始時間
                foreach($userArray AS $key => $reserve){
                    // 終了時間の条件によって格納していく
                    if( $reserve['visit_time'] >= $previousFinishesTime){
                        $previousFinishesTime = $reserve['finish_time'];
                        $newArray[$userName][$count][] = $reserve;
                        unset($userArray[$key]);
                    }
                }

                if(count($userArray) == 0){
                    break;
                };
                $count ++;
            } while (true);
        }
        return $newArray;
    }


}
