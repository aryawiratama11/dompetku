@extends('layouts.app')

@section('content')
    <h2>Tambah Pengeluaran Baru</h2><br>
    <h4>Detail Pengeluaran {{ $expense->description }}</h4><br>
    <h4>Bank {{ $expense->bank->name }}</h4><br>
    <h4>jumlah Rp {{ number_format($expense->amount, 2, ',', '.') }}</h4><br>
    <form action="{{ route('expenses.store-detail') }}" method="POST">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $expense->id }}">
        <div class="form-group">
            <label for="transaction_date">Tanggal Transaksi:</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                value="{{ old('transaction_date', date('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label for="amount">Jumlah Pengeluaran:</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                value="{{ old('amount') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi (opsional):</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('expenses.index') }}" class="btn">Kembali</a>
    </form>
@endsection
