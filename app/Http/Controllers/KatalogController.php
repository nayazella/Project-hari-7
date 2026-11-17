<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    /**
     * Mengambil data produk dari session (atau mengisi data awal jika belum ada).
     */
    private function getProduk(): array
    {
        if (! session()->has('produk')) {
            session([
                'produk' => [
                    [
                        'id' => 1,
                        'nama' => 'Kopi Ende',
                        'kategori' => 'Minuman',
                        'harga' => 15000,
                        'stok' => 12,
                    ],
                    [
                        'id' => 2,
                        'nama' => 'Roti Cokelat',
                        'kategori' => 'Makanan',
                        'harga' => 8000,
                        'stok' => 0,
                    ],
                ],
            ]);
        }

        return session('produk', []);
    }

    public function index(Request $request): View
    {
        $produk = $this->getProduk();
        $q = $request->query('q', '');

        // Jika kata kunci pencarian diisi, filter array produk berdasarkan nama
        if ($q !== '') {
            $produk = collect($produk)
                ->filter(fn ($item) => str_contains(strtolower($item['nama']), strtolower($q)))
                ->values()
                ->all();
        }

        return view('katalog.index', compact('produk', 'q'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $produk = $this->getProduk();
        $nextId = collect($produk)->max('id') ? (int) collect($produk)->max('id') + 1 : 1;

        $produk[] = [
            'id' => (int) $nextId,
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'harga' => (int) $validated['harga'],
            'stok' => (int) $validated['stok'],
        ];

        session(['produk' => $produk]);

        return redirect()->route('katalog.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(int $id): View
    {
        $produk = $this->getProduk();

        $item = collect($produk)->firstWhere('id', $id);

        if (! $item) {
            abort(404);
        }

        return view('katalog.show', compact('item'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $produk = $this->getProduk();

        $produkBaru = collect($produk)
            ->reject(fn ($item) => (int) $item['id'] === $id)
            ->values()
            ->all();

        session(['produk' => $produkBaru]);

        return redirect()->route('katalog.index')->with('success', 'Barang berhasil dihapus!');
    }
}
