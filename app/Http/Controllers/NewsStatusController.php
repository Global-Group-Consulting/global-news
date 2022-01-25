<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsStatusRequest;
use App\Http\Requests\UpdateNewsStatusRequest;
use App\Models\NewsStatus;

class NewsStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreNewsStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsStatus  $newsStatus
     * @return \Illuminate\Http\Response
     */
    public function show(NewsStatus $newsStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsStatus  $newsStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsStatus $newsStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewsStatusRequest  $request
     * @param  \App\Models\NewsStatus  $newsStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsStatusRequest $request, NewsStatus $newsStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsStatus  $newsStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsStatus $newsStatus)
    {
        //
    }
}
