@extends('layouts.app')

@section('content')
    <h2>Tambah Pemasukan Baru</h2>
    <form action="{{ route('incomes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="transaction_date">Tanggal Transaksi:</label>
            <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                value="{{ old('transaction_date', date('Y-m-d')) }}" required>
        </div>
        <div class="form-group">
            <label for="bank_id">Sumber/Bank:</label>
            <select name="bank_id" id="bank_id" class="form-control" required>
                <option value="">Pilih Sumber/Bank</option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                        {{ $bank->name }} (Saldo: Rp {{ number_format($bank->balance, 2, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Jumlah Pemasukan:</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                value="{{ old('amount') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi (opsional):</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('incomes.index') }}" class="btn">Kembali</a>
    </form>
@endsection
