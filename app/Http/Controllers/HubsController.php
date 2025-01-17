<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHubsRequest;
use App\Http\Requests\UpdateHubsRequest;
use App\Models\Hubs;
use Inertia\Inertia;
class HubsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Hub/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHubsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hubs $hubs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hubs $hubs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHubsRequest $request, Hubs $hubs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hubs $hubs)
    {
        //
    }
}
