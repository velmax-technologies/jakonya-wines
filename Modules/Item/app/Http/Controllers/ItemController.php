<?php

namespace Modules\Item\Http\Controllers;

use App\Models\Item;
use App\Enums\Messages;
use App\Enums\ApiStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseFormatTrait;
use Modules\Item\Transformers\ItemResource;

class ItemController extends Controller
{
        use ApiResponseFormatTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return (ItemResource::collection($items))->additional($this->preparedResponse('index'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('item::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('item::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
