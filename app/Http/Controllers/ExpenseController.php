<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('bank')->where('parent_id', null)->latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $banks = Bank::all();
        return view('expenses.create', compact('banks'));
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
            $bank = Bank::find($request->bank_id);
            if ($bank->balance < $request->amount) {
                return back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk pengeluaran ini.']);
            }

            Expense::create($request->all());

            $bank->balance -= $request->amount;
            $bank->save();
        });

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $banks = Bank::all();
        return view('expenses.edit', compact('expense', 'banks'));
    }
    public function editDetail(Expense $expense)
    {
        // $banks = Bank::all();
        $expenses = Expense::with('bank')->where('parent_id', $expense->id)->latest()->get();
        return view('expenses.detail.edit-detail', compact('expense', 'expenses'));
    }
    public function createDetail(Expense $expense)
    {
        $banks = Bank::all();
        return view('expenses.detail.create-detail', compact('banks', 'expense'));
    }
    public function storeDetail(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            Expense::create($request->all());
        });

        return redirect()->route('expenses.edit-detail', $request->parent_id)->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $expense) {
            $bank = Bank::find($request->bank_id);

            // Hitung kembali saldo jika bank atau jumlah berubah
            $currentBalance = $bank->balance;
            if ($expense->bank_id != $request->bank_id) {
                // Kembalikan dana ke bank lama
                $oldBank = Bank::find($expense->bank_id);
                $oldBank->balance += $expense->amount;
                $oldBank->save();

                // Cek saldo di bank baru
                if ($bank->balance < $request->amount) {
                    throw new \Exception('Saldo di bank tujuan tidak mencukupi.');
                }
                $bank->balance -= $request->amount;
                $bank->save();
            } else {
                // Jika bank tidak berubah, sesuaikan saldo
                $bank->balance = $bank->balance + $expense->amount - $request->amount;
                if ($bank->balance < 0) {
                    throw new \Exception('Saldo tidak mencukupi setelah perubahan pengeluaran.');
                }
                $bank->save();
            }

            $expense->update($request->all());
        });

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        DB::transaction(function () use ($expense) {
            $bank = Bank::find($expense->bank_id);
            $bank->balance += $expense->amount; // Kembalikan uang ke saldo bank
            $bank->save();

            $expense->delete();
        });

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
