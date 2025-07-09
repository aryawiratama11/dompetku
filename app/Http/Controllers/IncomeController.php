<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('bank')->latest()->get();
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('incomes.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Income::create($request->all());

            $bank = Bank::find($request->bank_id);
            $bank->balance += $request->amount;
            $bank->save();
        });

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil ditambahkan!');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        $banks = Bank::all();
        return view('incomes.edit', compact('income', 'banks'));
    }

    public function update(Request $request, Income $income)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $income) {
            // Kembalikan saldo bank lama jika bank berubah atau jumlah berubah
            if ($income->bank_id != $request->bank_id || $income->amount != $request->amount) {
                $oldBank = Bank::find($income->bank_id);
                $oldBank->balance -= $income->amount;
                $oldBank->save();

                $newBank = Bank::find($request->bank_id);
                $newBank->balance += $request->amount;
                $newBank->save();
            } else { // Jika bank tidak berubah, hanya update saldo jika jumlah berubah
                $bank = Bank::find($request->bank_id);
                $bank->balance = $bank->balance - $income->amount + $request->amount;
                $bank->save();
            }

            $income->update($request->all());
        });

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil diperbarui!');
    }

    public function destroy(Income $income)
    {
        DB::transaction(function () use ($income) {
            $bank = Bank::find($income->bank_id);
            $bank->balance -= $income->amount;
            $bank->save();

            $income->delete();
        });

        return redirect()->route('incomes.index')->with('success', 'Pemasukan berhasil dihapus!');
    }
}
