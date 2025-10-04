<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // Import Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk manajemen file gambar

class ProductController extends Controller
{
    // Tampilkan daftar semua produk (R: Read)
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form untuk membuat produk baru (C: Create View)
    public function create()
    {
        return view('admin.products.create');
    }

    // Simpan produk baru ke database (C: Create Store)
    public function store(Request $request)
    {
        // === KEAMANAN: LARAVEL VALIDATION ===
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000', // Minimal harga 1000
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['_token', 'image']);
        
        // Proses Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan gambar ke storage/app/public/products dan ambil path-nya
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        } else {
            $data['image'] = null;
        }

        Product::create($data); // Eloquent otomatis menggunakan Parameterized Queries

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Tampilkan detail produk (Opsional, bisa dilewati)
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    // Tampilkan form untuk mengedit produk (U: Update View)
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Perbarui produk di database (U: Update Store)
    public function update(Request $request, Product $product)
    {
        // === KEAMANAN: LARAVEL VALIDATION ===
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'nullable|boolean', // Diizinkan tidak ada jika checkbox tidak tercentang
        ]);

        $data = $request->except(['_token', '_method', 'image']);
        $data['is_active'] = $request->has('is_active'); // Pastikan boolean dari checkbox

        // Proses Upload Gambar Baru
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // 2. Simpan gambar baru
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk dari database (D: Delete)
    public function destroy(Product $product)
    {
        // Hapus gambar terkait dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}