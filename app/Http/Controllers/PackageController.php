<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\ActivityLog;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.packages.index', [
            'packages' => Package::all()
        ]);
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $package = Package::create($request->all());

        ActivityLog::record(
            'created', 'Package', $package->id,
            "Paket baru ditambahkan: \"{$package->name}\" (Rp " . number_format($package->price, 0, ',', '.') . ")"
        );

        return redirect()->route('packages.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $oldName  = $package->name;
        $oldPrice = $package->price;
        $package->update($request->all());

        ActivityLog::record(
            'updated', 'Package', $package->id,
            "Paket diperbarui: \"{$oldName}\" (Rp " . number_format($oldPrice, 0, ',', '.') . ") → \"{$package->name}\" (Rp " . number_format($package->price, 0, ',', '.') . ")"
        );

        return redirect()->route('packages.index')->with('success', 'Paket berhasil diupdate');
    }

    public function destroy(Package $package)
    {
        $name = $package->name;
        $id   = $package->id;
        $package->delete();

        ActivityLog::record(
            'deleted', 'Package', $id,
            "Paket dihapus: \"{$name}\""
        );

        return redirect()->route('packages.index')->with('success', 'Paket berhasil dihapus');
    }
}
