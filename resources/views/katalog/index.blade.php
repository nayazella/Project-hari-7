@extends('layouts.app')

@section('title', 'Katalog Produk - Kasir Ende')

@section('content')
    <h1>Daftar Produk Katalog</h1>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah Barang --}}
    <h3>Tambah Barang Baru</h3>
    <form method="POST" action="{{ route('katalog.store') }}" class="form-tambah">
        @csrf
        <input type="text" name="nama" placeholder="Nama barang (misal: Teh Tarik)" required>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Minuman">Minuman</option>
            <option value="Makanan">Makanan</option>
            <option value="Snack">Snack</option>
        </select>
        <input type="number" name="harga" placeholder="Harga (Rp)" min="0" required>
        <input type="number" name="stok" placeholder="Stok (angka)" min="0" required>
        <button type="submit" class="btn-tambah">+ Tambah</button>
    </form>

    {{-- Form Pencarian Keren & Modern --}}
    <form method="GET" action="{{ route('katalog.index') }}" class="search-bar">
        <div class="search-input-wrapper">
            <span class="search-icon">&#128269;</span>
            <input id="q" type="text" name="q" value="{{ $q }}" placeholder="Cari nama produk (misal: Kopi Ende, Roti)...">
            @if ($q !== '')
                <a href="{{ route('katalog.index') }}" class="search-clear" title="Hapus pencarian">&times;</a>
            @endif
        </div>
        <button type="submit" class="btn-cari">Cari Produk</button>
    </form>

    {{-- Tabel Daftar Barang & Kolom Aksi --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['kategori'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>
                        <x-status-stok :stok="(int) $item['stok']" />
                    </td>
                    <td class="aksi-group">
                        <a href="{{ route('katalog.show', $item['id']) }}">Detail</a>

                        <form method="POST" action="{{ route('katalog.destroy', $item['id']) }}" class="form-hapus" onsubmit="return confirm('Yakin ingin menghapus {{ $item['nama'] }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Produk tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
