<?php
// app/Http/Controllers/Admin/RedeemCodeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RedeemCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class RedeemCodeController extends Controller
{
    // Index: Tampilkan daftar kode redeem
    public function index(Request $request)
    {
        $query = RedeemCode::with('product');

        // Filter sederhana
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $redeemCodes = $query->orderBy('created_at', 'desc')->paginate(20);
        $products = Product::where('is_active', true)->get();

        return view('admin.redeem_codes.index', compact('redeemCodes', 'products'));
    }

    // Create: Tampilkan form tambah satu kode
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.redeem_codes.create', compact('products'));
    }

    // Store: Simpan satu kode baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'code' => 'required|string|unique:redeem_codes,code|max:100',
        ]);

        RedeemCode::create([
            'product_id' => $request->product_id,
            'code' => strtoupper($request->code), // Standarisasi ke huruf besar
            'status' => 'available',
        ]);

        return redirect()->route('admin.redeem-codes.index')
                         ->with('success', 'Satu kode redeem berhasil ditambahkan!');
    }

    // ==============================================
    // FUNGSI IMPORT MASSAL DARI CSV
    // ==============================================

    // Import Form: Tampilkan form upload CSV
    public function importForm()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.redeem_codes.import', compact('products'));
    }

    // Import Store: Proses upload dan simpan data dari CSV
    public function importStore(Request $request)
    {
        // === KEAMANAN: VALIDASI FILE ===
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5000', // Hanya izinkan CSV/TXT, maks 5MB
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();
        $data = [];

        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Kita asumsikan file CSV hanya berisi satu kolom: 'kode'
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (!empty($row[0])) { // Pastikan baris tidak kosong
                    $data[] = [
                        'product_id' => $request->product_id,
                        'code' => strtoupper(trim($row[0])),
                        'status' => 'available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            fclose($handle);
        }

        if (empty($data)) {
            return redirect()->back()->with('error', 'File CSV kosong atau tidak valid.');
        }

        // === PENCEGAHAN DUPLIKAT & TRANSAKSI DATABASE ===
        try {
            DB::beginTransaction();

            $codesToInsert = [];
            $existingCodes = RedeemCode::whereIn('code', array_column($data, 'code'))->pluck('code')->toArray();
            $duplicateCount = 0;

            foreach ($data as $item) {
                if (!in_array($item['code'], $existingCodes)) {
                    $codesToInsert[] = $item;
                } else {
                    $duplicateCount++;
                }
            }
            
            // Simpan massal (insert many)
            $insertedCount = 0;
            if (!empty($codesToInsert)) {
                $insertedCount = RedeemCode::insert($codesToInsert);
            }

            DB::commit();

            return redirect()->route('admin.redeem-codes.index')
                             ->with('success', "$insertedCount kode redeem baru berhasil diimport. $duplicateCount kode duplikat diabaikan.");

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage()); // Jika Anda ingin mencatat error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Pastikan format CSV benar.');
        }
    }

    // Edit, Update, Destroy (Mirip dengan Produk, fokus pada status)
    public function edit(RedeemCode $redeemCode)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.redeem_codes.edit', compact('redeemCode', 'products'));
    }

    public function update(Request $request, RedeemCode $redeemCode)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'code' => 'required|string|max:100|unique:redeem_codes,code,' . $redeemCode->id, // Abaikan kode sendiri saat update
            'status' => 'required|in:available,used,expired',
        ]);
        
        $redeemCode->update([
            'product_id' => $request->product_id,
            'code' => strtoupper($request->code),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.redeem-codes.index')
                         ->with('success', 'Kode redeem berhasil diperbarui.');
    }

    public function destroy(RedeemCode $redeemCode)
    {
        $redeemCode->delete();
        return redirect()->route('admin.redeem-codes.index')
                         ->with('success', 'Kode redeem berhasil dihapus.');
    }
}