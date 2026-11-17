@props(['stok'])

@php
    $jumlahStok = (int) $stok;
@endphp

@if ($jumlahStok > 0)
    <span>Tersedia ({{ $jumlahStok }})</span>
@else
    <span style="color: red;">Habis</span>
@endif
