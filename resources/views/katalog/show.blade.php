@extends('layouts.app')

@section('title', $item['nama'] . ' - Kasir Ende')

@section('content')
    <h1>Detail Produk</h1>

    <p><strong>Nama:</strong> {{ $item['nama'] }}</p>
    <p><strong>Kategori:</strong> {{ $item['kategori'] }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
    <p><strong>Status Stok:</strong> <x-status-stok :stok="(int) $item['stok']" /></p>

    <a href="{{ route('katalog.index') }}">&larr; Kembali ke Katalog</a>
@endsection
