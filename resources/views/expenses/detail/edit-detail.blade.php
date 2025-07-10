@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Detail Pengeluaran {{ $expense->description }}</h4><br>
        <h4>Bank {{ $expense->bank->name }}</h4><br>
        <a href="{{ route('expenses.create-detail', $expense->id) }}" class="btn btn-primary">Tambah Pengeluaran Baru</a>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Rp {{ number_format($expense->amount, 2, ',', '.') }} - Rp
            {{ number_format($expenses->sum('amount'), 2, ',', '.') }}</h4>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Sisa = Rp {{ number_format($expense->amount - $expenses->sum('amount'), 2, ',', '.') }}</h4>
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    {{-- <th>Sumber/Bank</th> --}}
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $data)
                    <tr>
                        <td>{{ $data->transaction_date->format('d M Y') }}</td>
                        {{-- <td>{{ $data->bank->name }}</td> --}}
                        <td>Rp {{ number_format($data->amount, 2, ',', '.') }}</td>
                        <td>{{ $data->description ?? '-' }}</td>
                        <td>
                            <a href="{{ route('expenses.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('expenses.destroy', $data->id) }}" method="POST"
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
