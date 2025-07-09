@extends('layouts.app')

@section('content')
    <h2>Tambah Sumber/Bank Baru</h2>
    <form action="{{ route('banks.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Sumber/Bank:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="account_number">Nomor Akun (opsional):</label>
            <input type="text" name="account_number" id="account_number" class="form-control"
                value="{{ old('account_number') }}">
        </div>
        <div class="form-group">
            <label for="balance">Saldo Awal:</label>
            <input type="number" name="balance" id="balance" class="form-control" step="0.01"
                value="{{ old('balance', 0) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('banks.index') }}" class="btn">Kembali</a>
    </form>
@endsection
