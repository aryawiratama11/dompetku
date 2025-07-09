@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pengeluaran</h2>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">Tambah Pengeluaran Baru</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
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
                @forelse ($expenses as $expense)
                    <tr>
                        <td>{{ $expense->transaction_date->format('d M Y') }}</td>
                        <td>{{ $expense->bank->name }}</td>
                        <td>Rp {{ number_format($expense->amount, 2, ',', '.') }}</td>
                        <td>{{ $expense->description ?? '-' }}</td>
                        <td>
                            <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada pengeluaran yang dicatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
