<?php

namespace App\Http\Controllers;

use App\Consts\ErrorLog;
use App\Http\Requests\UpdateShopRequest;
use App\Consts\{Common, DatabaseConst, SessionConst};
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\{Customer, Shop, User, UserShop, UserShopAuthorization};
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends ShopUserAppController
{

    private $errMsg = [];

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
            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $condition = [];
            $condition['otherAuthorityLevel'] = false;
            $users = User::myShopUsers($shopId, $condition)->get();
        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        try {
            $condition = [];
            if(!empty($request->name)) $condition['name'] = $request->name;
            if(!empty($request->email)) $condition['email'] = $request->email;
            if(!empty($request->authority)) $condition['authority'] = $request->authority;

            $condition['otherAuthorityLevel'] = false;
            if($request->otherAuthorityLevel) $condition['otherAuthorityLevel'] = true;

            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $users = User::myShopUsers($shopId, $condition)->get();

        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return View
     */
    public function belongSelect(): View
    {
        try {
            // 紐づいているUserを取得
            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $shop = Shop::find($shopId);
            $myShopUsers = $shop->userShops;

            // userのidをリストにする
            $myShopUserIdList = array_column($myShopUsers->toArray(), 'user_id');

            // リスト以外のUserを取得する
            $query = User::select('users.*')
                ->whereNotIn('id', $myShopUserIdList)
                ->where('authority_level', '<>', Common::AUTHORITY_RETIREMENT);
            $users = $query->get();

        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return view('user.belongSelect', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function belongSelected(User $user): RedirectResponse
    {
        try {
            // 既に登録されていないか確認
            $userShop = UserShop::where('user_id', $user->id)
                        ->where('shop_id', $this->shopId)
                        ->where('delete_flag', DatabaseConst::FLAG_OFF)
                        ->first();
            if($userShop){
                $this->errMsg[] = 'このスタッフは既に登録されています';
                throw new Exception('このスタッフは既に登録されています' . ' ' . __CLASS__ . ' ' .  __LINE__);
            }

            // 権限確認
            if(!array_key_exists( $user->authority_level, Common::AUTHORITY_LIST)){
                $this->errMsg[] = '権限が不正です';
                throw new Exception('権限が不正です' . ' ' . __CLASS__ . ' ' .  __LINE__);
            }
            if($user->authority_level == Common::AUTHORITY_RETIREMENT){
                $this->errMsg[] = 'このスタッフは権限がありません';
                throw new Exception('このスタッフは権限がありません' . ' ' . __CLASS__ . ' ' .  __LINE__);
            }

            // 登録
            $insertData = [
                'shop_id' => $this->shopId,
                'user_id' => $user->id,
            ];
            $userShop = UserShop::create($insertData);
            if(!$userShop){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new \Exception('errorrrrrrrrrrrr');
            }

            $authorizationInsertData = [
                'user_shop_id' => $userShop->id,
            ];
            $userShopAuthorization = UserShopAuthorization::create($authorizationInsertData);
            if(!$userShopAuthorization){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new \Exception('errorrrrrrrrrrrr');
            }


            return redirect()->route('user.index')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['スタッフを登録しました'])->withInput();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, $this->errMsg)->withInput();
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function deleteBelongShop(User $user): RedirectResponse
    {
        $userShop = $user->userShop;
        if(empty($userShop)){
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['選択したスタイリストには該当店舗への権限がありません']);
        }

        $userShop->delete_flag = DatabaseConst::FLAG_ON;
        $userShop->save();
        return redirect()->route('user.index')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['削除しました']);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $randomPass = uniqid();
            // 登録
            $insertData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($randomPass),
                'authority_level' => $request->authority,
            ];
            $user = User::create($insertData);
            if(!$user){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new \Exception('errorrrrrrrrrrrr');
            }

            $shopId = session()->get(SessionConst::SELECTED_SHOP)->id;
            $userShop = UserShop::create([
                'shop_id' => $shopId,
                'user_id' => $user->id,
            ]);
            if(!$userShop){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new \Exception('errorrrrrrrrrrrr');
            }

            $userShopAuthorization = UserShopAuthorization::create([
                'user_shop_id' => $userShop->id,
                'user_read' => $request->user_read,
                'user_create' => $request->user_create,
                'user_edit' => $request->user_edit,
                'user_delete' => $request->user_delete,
                'customer_read' => $request->customer_read,
                'customer_create' => $request->customer_create,
                'customer_edit' => $request->customer_edit,
                'customer_delete' => $request->customer_delete,
                'reserve_read' => $request->reserve_read,
                'reserve_create' => $request->reserve_create,
                'reserve_edit' => $request->reserve_edit,
                'reserve_delete' => $request->reserve_delete,
            ]);
            if(!$userShopAuthorization){
                $this->errMsg[] = 'errorrrrrrrrrrrr';
                throw new \Exception('errorrrrrrrrrrrr');
            }

            $this->sendCreateUserMail($request->name, $request->email, $randomPass);

            DB::commit();
            return redirect()->route('user.index')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['スタッフを登録しました'])->withInput();
        } catch (Exception $e) {
            Log::error( ' msg:' . $e->getMessage());
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['登録に失敗しました'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): view
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): view
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * @param User $user
     * @return RedirectResponse
     */
    public function update(User $user, Request $request): RedirectResponse
    {
        try {
            $this->checkValidation($request);
            if(count($this->errMsg)){
                return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, $this->errMsg)->withInput();
            }

            DB::beginTransaction();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->authority_level = $request->authority;
            $user->save();


            $authorization = $user->userShop->userShopAuthorization;
            $authorization->user_read = $request->user_read;
            $authorization->user_create = $request->user_create;
            $authorization->user_edit = $request->user_edit;
            $authorization->user_delete = $request->user_delete;
            $authorization->customer_read = $request->customer_read;
            $authorization->customer_create = $request->customer_create;
            $authorization->customer_edit = $request->customer_edit;
            $authorization->customer_delete = $request->customer_delete;
            $authorization->reserve_read = $request->reserve_read;
            $authorization->reserve_create = $request->reserve_create;
            $authorization->reserve_edit = $request->reserve_edit;
            $authorization->reserve_delete = $request->reserve_delete;
            $authorization->save();

            DB::commit();
            return redirect()->route('user.index')->with(SessionConst::FLASH_MESSAGE_SUCCESS, ['スタッフ情報を更新しました']);
        } catch (Exception $e) {
            Log::error( ' msg:' . $e->getMessage());
            return redirect()->back()->with(SessionConst::FLASH_MESSAGE_ERROR, ['スタッフ情報の更新に失敗しました'])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
    }

    /**
     * @param string $randomPass
     * @return void
     */
    public function sendCreateUserMail(string $name, string $email, string $randomPass)
    {
        // 第1引数に、テンプレートファイルのパスを指定し、
        // 第2引数に、テンプレートファイルで使うデータを指定する
        Mail::send('mails.test', [
            'name' => $name,
            'url' => url("/myPage"),
            'mailAddress' => $email,
            'password' => $randomPass
        ], function($message) {
            // 第3引数にはコールバック関数を指定し、
            // その中で、送信先やタイトルの指定を行う.
            $message
                ->to('fujisawareon@yahoo.co.jp')
                ->bcc('admin@sample.com')
                ->subject("ユーザー登録ありがとうございます");
        });
    }

    /**
     * @return void
     */
    private function checkValidation(Request $r)
    {
        $myAuthorization = Auth::user()->userShop->userShopAuthorization;
        if($r->user_edit > $myAuthorization->user_edit){
            $this->errMsg[] = 'あなたにはスタイリスト編集権限が無い為、編集権限があるユーザーを作成できません';
        }
        if($r->user_edit > $myAuthorization->user_delete){
            $this->errMsg[] = 'あなたにはスタイリスト削除権限が無い為、削除権限があるユーザーを作成できません';
        }
        if($r->customer_edit > $myAuthorization->customer_edit){
            $this->errMsg[] = 'あなたには顧客編集権限が無い為、編集権限があるユーザーを作成できません';
        }
        if($r->customer_delete > $myAuthorization->customer_delete){
            $this->errMsg[] = 'あなたには顧客削除権限が無い為、削除権限があるユーザーを作成できません';
        }
        if($r->reserve_edit > $myAuthorization->reserve_edit){
            $this->errMsg[] = 'あなたには予約編集権限が無い為、編集権限があるユーザーを作成できません';
        }
        if($r->reserve_delete > $myAuthorization->reserve_delete){
            $this->errMsg[] = 'あなたには予約削除権限が無い為、削除権限があるユーザーを作成できません';
        }

        if($r->user_read < $r->user_create ){
            $this->errMsg[] = 'スタイリスト閲覧権限がない場合、スタイリスト作成権限を与えられません';
        }
        if($r->user_create < $r->user_edit ){
            $this->errMsg[] = 'スタイリスト作成権限がない場合、スタイリスト編集権限を与えられません';
        }
        if($r->user_edit < $r->user_delete ){
            $this->errMsg[] = 'スタイリスト編集権限がない場合、スタイリスト削除権限を与えられません';
        }

        if($r->customer_read < $r->customer_create ){
            $this->errMsg[] = '顧客閲覧権限がない場合、顧客作成権限を与えられません';
        }
        if($r->customer_create < $r->customer_edit ){
            $this->errMsg[] = '顧客作成権限がない場合、顧客編集権限を与えられません';
        }
        if($r->customer_edit < $r->customer_delete ){
            $this->errMsg[] = '顧客編集権限がない場合、顧客削除権限を与えられません';
        }

        if($r->reserve_read < $r->reserve_create ){
            $this->errMsg[] = '予約閲覧権限がない場合、予約作成権限を与えられません';
        }
        if($r->reserve_create < $r->reserve_edit ){
            $this->errMsg[] = '予約作成権限がない場合、予約編集権限を与えられません';
        }
        if($r->reserve_edit < $r->reserve_delete ){
            $this->errMsg[] = '予約編集権限がない場合、予約削除権限を与えられません';
        }
    }
}
