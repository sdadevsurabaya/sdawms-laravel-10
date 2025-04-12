<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Rack;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('rack')->get();
        return view('back.items.index', compact('items'));
    }

    public function create()
    {
        $racks = Rack::all();
        return view('back.items.create', compact('racks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qr_code' => 'required|unique:items',
            'barcode' => 'required|unique:items',
            'rack_id' => 'required|exists:racks,id',
        ]);

        Item::create($request->all());
        return redirect()->route('item.index')->with('success', 'Item created successfully.');
    }

    public function edit(Item $item)
    {
        $racks = Rack::all();
        return view('back.items.edit', compact('item', 'racks'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qr_code' => 'required|unique:items,qr_code,' . $item->id,
            'barcode' => 'required|unique:items,barcode,' . $item->id,
            'rack_id' => 'required|exists:racks,id',
        ]);

        $item->update($request->all());
        return redirect()->route('item.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('item.index')->with('success', 'Item deleted successfully.');
    }
}
