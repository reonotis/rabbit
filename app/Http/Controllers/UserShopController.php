<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserShopRequest;
use App\Http\Requests\UpdateUserShopRequest;
use App\Models\UserShop;

class UserShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserShopRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserShopRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserShop  $userShop
     * @return \Illuminate\Http\Response
     */
    public function show(UserShop $userShop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserShop  $userShop
     * @return \Illuminate\Http\Response
     */
    public function edit(UserShop $userShop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserShopRequest  $request
     * @param  \App\Models\UserShop  $userShop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserShopRequest $request, UserShop $userShop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserShop  $userShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserShop $userShop)
    {
        //
    }
}
