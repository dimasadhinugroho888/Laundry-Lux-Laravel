<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ActivityLog;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customers.index', [
            'customers' => Customer::all()
        ]);
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $customer = Customer::create($request->all());

        ActivityLog::record(
            'created', 'Customer', $customer->id,
            "Pelanggan baru ditambahkan: \"{$customer->name}\" (HP: {$customer->phone})"
        );

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan');
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $oldName = $customer->name;
        $customer->update($request->all());

        ActivityLog::record(
            'updated', 'Customer', $customer->id,
            "Data pelanggan diperbarui: \"{$oldName}\" → \"{$customer->name}\""
        );

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diupdate');
    }

    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $id   = $customer->id;
        $customer->delete();

        ActivityLog::record(
            'deleted', 'Customer', $id,
            "Pelanggan dihapus: \"{$name}\""
        );

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus');
    }
}