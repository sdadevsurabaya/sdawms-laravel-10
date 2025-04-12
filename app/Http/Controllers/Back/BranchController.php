<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('back.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('back.branch.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Branch::create($request->all());

        return redirect()->route('branch.index')->with('success', 'Branch created successfully!');
    }

    public function edit(Branch $branch)
    {
        return view('back.branch.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $branch->update($request->all());

        return redirect()->route('branch.index')->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branch.index')->with('success', 'Branch deleted successfully!');
    }
}
