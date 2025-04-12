<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\Rack;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        $branchCount = Branch::count();
    $warehouseCount = Warehouse::count();
    $rackCount = Rack::count();
    $itemCount = Item::count();

    $branches = Branch::with(['warehouses.racks.items'])->get();

    return view('back.dashboard', compact(
        'branchCount', 'warehouseCount', 'rackCount', 'itemCount', 'branches'
    ));
    }
}
