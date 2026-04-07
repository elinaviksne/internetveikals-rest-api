<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return Shop::query()->orderBy('name')->get();
    }

    public function show(Shop $shop)
    {
        return $shop;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:shops,name',
            'api_url' => 'nullable|url|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        return Shop::create($validated);
    }

    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:shops,name,' . $shop->id,
            'api_url' => 'nullable|url|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $shop->update($validated);

        return $shop;
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return response()->noContent();
    }
}
