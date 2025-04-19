<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Rack;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function index()
    {
        $racks = Rack::with('warehouse')->get();
        return view('back.racks.index', compact('racks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('back.racks.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rack_number' => 'required|string|max:255',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $rackNumber = $request->rack_number;

        Rack::create([
            'rack_number' => $rackNumber,
            'warehouse_id' => $request->warehouse_id,
            'barcode' => 'BAR-' . strtoupper(preg_replace('/\s+/', '', $rackNumber)),
            'gr_code' => 'QR-' . strtoupper(preg_replace('/\s+/', '', $rackNumber)),
        ]);

        return redirect()->route('rack.index')->with('success', 'Rack created successfully.');
    }

    public function edit(Rack $rack)
    {
        $warehouses = Warehouse::all();
        return view('back.racks.edit', compact('rack', 'warehouses'));
    }

    public function update(Request $request, Rack $rack)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $rack->update($request->all());
        return redirect()->route('rack.index')->with('success', 'Rack updated successfully.');
    }

    public function destroy(Rack $rack)
    {
        $rack->delete();
        return redirect()->route('rack.index')->with('success', 'Rack deleted successfully.');
    }

    public function show($id)
    {
        $rack = Rack::with(['warehouse.branch', 'items'])->findOrFail($id);

        return view('back.racks.show', compact('rack'));
    }
}
