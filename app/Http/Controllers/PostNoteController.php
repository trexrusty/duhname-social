<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostNoteRequest;
use App\Http\Requests\UpdatePostNoteRequest;
use App\Models\PostNote;

class PostNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePostNoteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PostNote $postNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostNote $postNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostNoteRequest $request, PostNote $postNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostNote $postNote)
    {
        //
    }
}
