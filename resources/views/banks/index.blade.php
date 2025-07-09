@extends('layouts.app')

@section('content')
    <h2>Daftar Sumber/Bank</h2>
    <a href="{{ route('banks.create') }}" class="btn btn-success">Tambah Sumber/Bank Baru</a>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor Akun</th>
                <th>Saldo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($banks as $bank)
                <tr>
                    <td>{{ $bank->name }}</td>
                    <td>{{ $bank->account_number ?? '-' }}</td>
                    <td>Rp {{ number_format($bank->balance, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus sumber/bank ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada sumber/bank yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
