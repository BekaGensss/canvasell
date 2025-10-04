<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// Pastikan Anda mengimpor AdminUserSeeder jika seeder ini ada di namespace yang berbeda
// use Database\Seeders\AdminUserSeeder; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder lain yang ingin Anda jalankan
        $this->call([
            AdminUserSeeder::class, // <-- Tambahkan ini
        ]);
        
        // Contoh pembuatan user bawaan yang masih bisa Anda pertahankan jika diperlukan
        // User::factory(10)->create(); 

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            // Catatan: Jika Anda sudah menambahkan kolom 'role', 
            // Anda mungkin perlu menentukannya di sini, atau biarkan default
        ]);
    }
}