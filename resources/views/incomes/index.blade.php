@extends('layouts.app')

@section('content')
    <h2>Daftar Pemasukan</h2>
    <a href="{{ route('incomes.create') }}" class="btn btn-success">Tambah Pemasukan Baru</a>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Sumber/Bank</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incomes as $income)
                <tr>
                    <td>{{ $income->transaction_date->format('d M Y') }}</td>
                    <td>{{ $income->bank->name }}</td>
                    <td>Rp {{ number_format($income->amount, 2, ',', '.') }}</td>
                    <td>{{ $income->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('incomes.edit', $income->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('incomes.destroy', $income->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus pemasukan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada pemasukan yang dicatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
