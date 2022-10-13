<?php

namespace App\Http\Controllers;

use App\Consts\ErrorLog;
use App\Http\Requests\UpdateShopRequest;
use App\Consts\SessionConst;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\{Customer, Shop, User, VisitHistory};
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CustomerController extends ShopUserAppController
{

    private array $errMsg;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        try {
            // 顧客取得
            $condition = [
                'customer_no' => request('customer_no'),
                'f_name' => request('f_name'),
                'l_name' => request('l_name'),
                'l_read' => request('l_read'),
                'f_read' => request('f_read'),
                'sex' => request('sex'),
                'staff_charge' => request('staff_charge'),
                'other_shop' => request('other_shop'),
            ];
            $customerQuery = Customer::searchCustomer($condition);
            $customers = $customerQuery->paginate(50);

            // TODO 最終来店日を紐づけたい


            // スタイリスト取得
            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $condition = [];
            $condition['otherAuthorityLevel'] = false;
            $users = User::myShopUsers($shopId, $condition)->get();
            $userList = [];
            $userList[0] = '選択しない';
            foreach($users AS $user){
                $userList[$user->id] = $user->name;
            }


        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return view('customer.index', compact('customers', 'userList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(): View
    {
        $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
        $condition = [];
        $condition['otherAuthorityLevel'] = false;
        $users = User::myShopUsers($shopId, $condition)->get();

        return view('customer.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->session()->regenerateToken(); // 重複クリック対策
        try {
            $this->_checkValidation($request);
            $customerNo = $this->_makeCustomerNo($request->customer_no);
            if(count($this->errMsg)){
                return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, $this->errMsg)->withInput();
            }

            DB::beginTransaction();
            // 登録
            $insertData = [
                'customer_no' => $customerNo,
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
            ];
            $customer = Customer::create($insertData);
            if(!$customer){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new Exception('errorrrrrrrrrrrr');
            }

            DB::commit();
            return redirect()->route('customer.show', ['customer' => $customer->id])->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['登録しました'])->withInput();
        } catch (Exception $e) {
            Log::error( ' msg:' . $e->getMessage());
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, $this->errMsg)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return View
     */
    public function show(Customer $customer): View
    {
        $customerId = $customer->id;
        $visitHistoryQuery = VisitHistory::getByCustomerId($customerId);
        $visitHistories = $visitHistoryQuery->get();

        return view('customer.show', compact('customer', 'visitHistories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
        dd($shop, 'edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopRequest  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        //
        dd($shop, 'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        dd($shop, 'destroy');
        //
    }

    /**
     * @param Request $r
     * @return void
     */
    private function _checkValidation(Request $r)
    {
        $this->errMsg = [];

        if(empty($r->f_name)){
            $this->errMsg['f_name'] = '顧客名(苗字)は必須入力です';
        }
        if(empty($r->l_name)){
            $this->errMsg['l_name'] = '顧客名(名前)は必須入力です';
        }

        if(empty($r->f_read)){
            $this->errMsg['f_read'] = '顧客名(ミョウジ)は必須入力です';
        }
        if(empty($r->l_read)){
            $this->errMsg['l_read'] = '顧客名(ナマエ)は必須入力です';
        }

        if(empty($r->email)){
            $this->errMsg['email'] = 'emailは必須入力です';
        }

    }

    /**
     * @param string|null $customerNo
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function _makeCustomerNo(string $customerNo = null): string
    {
        if($customerNo){
            $this->_checkCustomerNo($customerNo);
            return $customerNo;
        }

        // 最後の顧客を取得
        $lastCustomer = Customer::orderBy('id', 'desc')->whereNotNull('customer_no')->first();
        $lastCustomerNo = $lastCustomer->customer_no;
        $newNom = preg_replace('/[^0-9]/', '', $lastCustomerNo) + 1;
        $shopSymbol = session()->get(SessionConst::SELECTED_SHOP)->shop_symbol;
        $customerNo = $shopSymbol .sprintf('%07d', $newNom) ;
        if(!$this->_checkCustomerNo($customerNo)){
            $this->errMsg['customer_no'] = '顧客番号の作成に失敗しました';
        }
        return $customerNo;
    }

    /**
     * @param string $customerNo
     * @return bool
     */
    private function _checkCustomerNo(string $customerNo): bool
    {
        $customer = Customer::where('customer_no', $customerNo)->first();
        if($customer){
            $this->errMsg['customer_no'] = 'この顧客番号は既に利用されています';
            return false;
        }

        $symbol = str_split($customerNo, 2)[0];
        $shops = Shop::select('shop_symbol')->get()->toArray();
        $symbolArray = array_column( $shops, 'shop_symbol' );
        if(!in_array($symbol, $symbolArray)){
            $this->errMsg['customer_no'] = '顧客番号のシンボル(先頭2文字)に不正な値が利用されています';
            return false;
        }

        $number = ltrim($customerNo, $symbol);
        if(!is_numeric($number)){
            $this->errMsg['customer_no'] = '顧客番号の3文字目以降に数値以外の文字列が利用されています';
            return false;
        }

        $nomLen = mb_strlen($number);
        if($nomLen <> 7){
            $this->errMsg['customer_no'] = '顧客番号の3文字目以降の数値は7桁にしてください';
            return false;
        }

        return true;
    }

}







