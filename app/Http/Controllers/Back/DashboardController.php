<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\Rack;
use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    $branchCount = Branch::count();
    $warehouseCount = Warehouse::count();
    $rackCount = Rack::count();
    $itemCount = Item::count();

    $branches = Branch::with(['warehouses.racks.items'])->get();

    $searchRack = $request->input('search_rack');
    $searchItem = $request->input('search_item');

    $racksWithItems = collect();
    $itemsWithRack = collect();

    if ($searchRack) {
        $racksWithItems = Rack::with(['items', 'warehouse.branch'])
            ->where('rack_number', 'like', "%{$searchRack}%")
            ->get();
    }

    if ($searchItem) {
        $itemsWithRack = Item::with(['rack.warehouse.branch'])
            ->where('name', 'like', "%{$searchItem}%")
            ->orWhere('qr_code', 'like', "%{$searchItem}%")
            ->orWhere('barcode', 'like', "%{$searchItem}%")
            ->get();
    }

    return view('back.dashboard', [
        'branchCount' => \App\Models\Branch::count(),
        'warehouseCount' => \App\Models\Warehouse::count(),
        'rackCount' => \App\Models\Rack::count(),
        'itemCount' => \App\Models\Item::count(),
        'racksWithItems' => $racksWithItems,
        'itemsWithRack' => $itemsWithRack,
        'branches' => $branches,
    ]);

    // return view('back.dashboard', compact(
    //     'branchCount', 'warehouseCount', 'rackCount', 'itemCount', 'branches'
    // ));


    }
}
