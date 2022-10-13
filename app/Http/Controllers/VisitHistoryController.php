<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitHistoryRequest;
use App\Http\Requests\UpdateVisitHistoryRequest;
use App\Models\VisitHistory;

class VisitHistoryController extends ShopUserAppController
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
     * @param  \App\Http\Requests\StoreVisitHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisitHistory  $visitHistory
     * @return \Illuminate\Http\Response
     */
    public function show(VisitHistory $visitHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisitHistory  $visitHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitHistory $visitHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitHistoryRequest  $request
     * @param  \App\Models\VisitHistory  $visitHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitHistoryRequest $request, VisitHistory $visitHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisitHistory  $visitHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitHistory $visitHistory)
    {
        //
    }
}
