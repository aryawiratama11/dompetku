@extends('layouts.app')

@section('content')
    <h2>Edit Pengeluaran</h2>
    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="transaction_date">Tanggal Transaksi:</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                value="{{ old('transaction_date', $expense->transaction_date->format('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label for="bank_id">Sumber/Bank:</label>
            <select name="bank_id" id="bank_id" class="form-control" required>
                <option value="">Pilih Sumber/Bank</option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}"
                        {{ old('bank_id', $expense->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }} (Saldo:
                        Rp {{ number_format($bank->balance, 2, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Jumlah Pengeluaran:</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                value="{{ old('amount', $expense->amount) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi (opsional):</label>
            <input type="text" name="description" id="description" class="form-control"
                value="{{ old('description', $expense->description) }}">
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('expenses.index') }}" class="btn">Kembali</a>
    </form>
@endsection
