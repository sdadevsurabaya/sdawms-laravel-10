<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Branch;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('branch')->get();
        return view('back.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $branches = Branch::all();  // Get all branches to assign to warehouse
        return view('back.warehouses.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouse.index')->with('success', 'Warehouse created successfully.');
    }

    public function edit(Warehouse $warehouse)
    {
        $branches = Branch::all();
        return view('back.warehouses.edit', compact('warehouse', 'branches'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouse.index')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouse.index')->with('success', 'Warehouse deleted successfully.');
    }
}
