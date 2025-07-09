@extends('layouts.app')

@section('content')
    <h2>Edit Sumber/Bank</h2>
    <form action="{{ route('banks.update', $bank->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Sumber/Bank:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $bank->name) }}"
                required>
        </div>
        <div class="form-group">
            <label for="account_number">Nomor Akun (opsional):</label>
            <input type="text" name="account_number" id="account_number" class="form-control"
                value="{{ old('account_number', $bank->account_number) }}">
        </div>
        <div class="form-group">
            <label for="balance">Saldo:</label>
            <input type="number" name="balance" id="balance" class="form-control" step="0.01"
                value="{{ old('balance', $bank->balance) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('banks.index') }}" class="btn">Kembali</a>
    </form>
@endsection
