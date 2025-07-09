<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return view('banks.index', compact('banks'));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name',
            'account_number' => 'nullable|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        Bank::create($request->all());

        return redirect()->route('banks.index')->with('success', 'Sumber/Bank berhasil ditambahkan!');
    }

    public function show(Bank $bank)
    {
        return view('banks.show', compact('bank'));
    }

    public function edit(Bank $bank)
    {
        return view('banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:banks,name,' . $bank->id,
            'account_number' => 'nullable|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        $bank->update($request->all());

        return redirect()->route('banks.index')->with('success', 'Sumber/Bank berhasil diperbarui!');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'Sumber/Bank berhasil dihapus!');
    }
}
