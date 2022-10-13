<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ErrorPageController extends Controller
{

    /**
     * コンストラクタ
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('error.error');
    }

}
