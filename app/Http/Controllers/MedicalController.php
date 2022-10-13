<?php

namespace App\Http\Controllers;

use App\Consts\SessionConst;
use Exception;
use App\Models\{Shop, UserShop};
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class MedicalController extends ShopUserAppController
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        if(\Route::currentRouteName() == 'medical.index'){
            parent::__construct();
        }
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        try {
            $url = url('') . '/medicalCreate/' . $this->shopId;
             $options = new QROptions([
                 'eccLevel' => QRCode::ECC_L,
                 'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                 'version' => 5,
             ]);
             $qrcode = (new QRCode($options))->render($url);

        } catch (Exception $e) {
            dd($e->getMessage());
        }
        return view('medical.index', compact('url', 'qrcode'));
    }

    /**
     * Display a listing of the resource.
     * @param Shop $shop
     * @return View
     */
    public function create(Shop $shop): View
    {
        return view('medical.create', compact('shop'));
    }

}
