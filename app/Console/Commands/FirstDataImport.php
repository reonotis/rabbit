<?php

namespace App\Console\Commands;

use App\Models\{Customer, Menu, Shop, User, UserShop, UserShopAuthorization, VisitHistory};
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use mysqli;
use PDO;

class FirstDataImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:FirstDataImport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : ' . $this->name .' : Batch start');
        try{
            DB::beginTransaction();

            $this->shopImport();
            $this->userImport();
            $this->menuImport();
            $this->customerImport();
            $this->historyImport();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error( ' errorMsg : ' . $e->getMessage());
            dump($e->getMessage());
        }
    }

    public function shopImport()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : shopImport start...');
        try{

            $shops = DB::connection('mysql_urhair_ur')->select("SELECT * FROM shop WHERE deleted_at IS NULL");
            if(empty($shops)){
                return;
            }

            $insertData = [];
            foreach($shops AS $shop){
                $insertData[] = [
                    'id' => $shop->shop_id,
                    'shop_name' => $shop->shop_name,
                    'shop_symbol' => $shop->TOKKAI_shop,
                    'email' => $shop->email,
                    'tel' => $shop->tel,
                    'img_pass' => NULL,
                    'start_time' => '10:00:00',
                    'end_time' => '21:00:00',
                    'last_reception_time' => '20:00:00',
                    'created_at' => $shop->created_at,
                    'updated_at' => $shop->updated_at,
                    'delete_flag' => 0,
                ];
            }

            Shop::insert($insertData);
        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error( ' errorMsg : ' . $e->getMessage());
            throw new Exception('shop登録に失敗しました urhair_ur.shop.id=' . $shop->shop_id );
        }

        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : shopImport end');
    }

    public function userImport()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : UserImport start...');
        try{
            $users = DB::connection('mysql_urhair_ur')->select('select * from user');

            foreach($users AS $key => $user){
                if($user->user_id == 0){
                    continue;
                }

                if(empty($user->display_name)){
                    $name = 'name_' . $key;
                }else{
                    $name = $user->display_name;
                }

                if(empty($user->email)){
                    $email = 'test_' . $key . '@test.jp';
                }else{
                    $email = $user->email;
                }

                switch($user->status_id){
                    case 1:   // 在籍
                        $authorityId = 2;  // 2:在籍
                        break;
                    case 2:   // 長期休暇
                        $authorityId = 5;  // 5:長期休暇
                        break;
                    default:
                        $authorityId = 9;  // 9:退職
                }

                if(empty($user->password)){
                    $password = $user->user_id;
                }else{
                    $password = $user->password;
                }

                $insertData = [
                    'id' => $user->user_id,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'authority_level' => $authorityId,
                ];
                User::create($insertData);

                $userShopResult = UserShop::create([
                    'shop_id' => $user->shop_id,
                    'user_id' => $user->user_id,
                ]);

                UserShopAuthorization::create([
                    'user_shop_id' => $userShopResult->id,
                    'user_read' => 1,
                    'user_create' => 0,
                    'user_edit' => 0,
                    'user_delete' => 0,
                    'customer_read' => 1,
                    'customer_create' => 0,
                    'customer_edit' => 0,
                    'customer_delete' => 0,
                    'reserve_read' => 1,
                    'reserve_create' => 0,
                    'reserve_edit' => 0,
                    'reserve_delete' => 0,
                ]);
            }
        } catch (Exception $e) {
            Log::error( ' errorMsg : ' . $e->getMessage());
            throw new Exception('ユーザー登録に失敗しました urhair_ur.user.id=' . $user->user_id );
        }
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : UserImport end');
    }

    public function customerImport()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : CustomerImport start...');
        try{
            $lastId = 0;
            while(true){ // 無限ループ
                $sysCustomers = DB::connection('mysql_urhair_ur')->select("SELECT * FROM sys_customer WHERE id > " . $lastId . " AND derete_flag = 0 ORDER BY id ASC LIMIT 1000");
                if(empty($sysCustomers)){
                    break; // データが無ければ繰返しの強制終了
                }

                $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : CustomerImport insertLastId:' . $lastId . '...');

                $insertData = [];
                foreach($sysCustomers AS $sysCustomer){
                    $lastId = $sysCustomer->id;

                    $insertData[] = [
                        'id' => $sysCustomer->id,
                        'customer_no' => $sysCustomer->TOKKAI_number,
                        'f_name' => $sysCustomer->customer_fName,
                        'l_name' => $sysCustomer->customer_lName,
                        'f_read' => $sysCustomer->customer_fNameRead,
                        'l_read' => $sysCustomer->customer_lNameRead,
                        'sex' => $sysCustomer->sex,
                        'tel' => $sysCustomer->tel,
                        'email' => $sysCustomer->email,
                        'zip21' => $sysCustomer->zip1,
                        'zip22' => $sysCustomer->zip2,
                        'pref21' => $sysCustomer->pref21,
                        'address21' => $sysCustomer->addr21,
                        'street21' => $sysCustomer->strt21,
                        'shop_no' => $sysCustomer->goToShop,
                        'staff_charge' => $sysCustomer->person_staff,
                        'memo' => $sysCustomer->comment,
                    ];

                }
                Customer::insert($insertData);
            }
        } catch (Exception $e) {
            Log::error( ' errorMsg : ' . $e->getMessage());
            throw new Exception('顧客登録に失敗しました urhair_ur.sys_customer.id=' . $lastId );
        }
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : CustomerImport end');
    }

    public function menuImport()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : menuImport start...');
        try{
            $menus = DB::connection('mysql_urhair_ur')->select("SELECT * FROM menu WHERE deleted_at IS NULL");
            if(empty($menus)){
                return;
            }

            $insertData = [];
            foreach($menus AS $menu){
                $insertData[] = [
                    'id' => $menu->menu_id,
                    'menu_name' => $menu->menu_name,
                    'menu_read' => $menu->menu_read,
                    'menu_rank' => $menu->menu_rank,
                    'price' => $menu->price,
                    'shortening' => $menu->shortening,
                    'created_at' => $menu->created_at,
                    'updated_at' => $menu->updated_at,
                ];
            }

            Menu::insert($insertData);
        } catch (Exception $e) {
            Log::error( ' errorMsg : ' . $e->getMessage());
            throw new Exception('メニュー登録に失敗しました urhair_ur.menu.id=' .  $menu->menu_id);
        }
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : menuImport end');
    }

    public function historyImport()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : historyImport start...');
        try{
            $lastId = 0;
            while(true){ // 無限ループ
                $sql = "SELECT *
                        FROM sys_visitHistory
                        WHERE visit_id > " . $lastId . "
                        AND deleted_at = 0
                        ORDER BY visit_id ASC
                        LIMIT 1000";

                $sysVisitHistory = DB::connection('mysql_urhair_ur')->select($sql);
                if(empty($sysVisitHistory)){
                    break; // データが無ければ繰返しの強制終了
                }

                $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : CustomerImport insertLastId:' . $lastId . '...');

                $insertData = [];
                foreach($sysVisitHistory AS $visitHistory){
                    $lastId = $visitHistory->visit_id;

                    $insertData[] = [
                        'id' => $visitHistory->visit_id,
                        'customer_id' => $visitHistory->customer_id,
                        'shop_id' => $visitHistory->shop_id,
                        'user_id' => $visitHistory->user_id,
                        'visit_date' => $visitHistory->visit_date,
                        'visit_time' => $visitHistory->visit_time,
                        'visit_reserve_id' => null,
                        'visit_type' => $visitHistory->correspondence_id,
                        'status' => 1,
                        'menu_id' => $visitHistory->menu_id,
                        'memo' => $visitHistory->visit_comment,
                    ];

                }
                VisitHistory::insert($insertData);
            }
        } catch (Exception $e) {
            Log::error( ' errorMsg : ' . $e->getMessage());
            throw new Exception('来店履歴の登録に失敗しました urhair_ur.sys_visitHistory.visit_id=' . $visitHistory->visit_id);
        }
        $this->info(Carbon::now()->format('Y-m-d H:i:s') . ' : historyImport end');
    }
}
