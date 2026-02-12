<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Services\TransactionService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user dan produk yang ada
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info(
                "Tidak ada user atau produk, TransactionSeeder dilewati.",
            );
            return;
        }

        $count = 150;
        $this->command->getOutput()->progressStart($count);

        // Awal tahun ini
        $startOfYear = Carbon::now()->startOfYear();
        $today = Carbon::now();

        // Buat transaksi acak
        for ($i = 0; $i < $count; $i++) {
            $user = $users->random();
            // Lebih beragam: 1 sampai 8 jenis produk per transaksi
            $transactionProducts = $products->random(rand(1, min(8, $products->count())));

            $totalPrice = 0;
            $totalQuantity = 0;
            $transactionDetails = [];

            foreach ($transactionProducts as $product) {
                // Kuantitas beragam 1-5
                $quantity = rand(1, 5);
                $totalPrice += $product->price * $quantity;
                $totalQuantity += $quantity;

                $transactionDetails[] = [
                    "product_id" => $product->id,
                    "quantity" => $quantity,
                    "price" => $product->price,
                ];
            }

            // Buat transaksi menggunakan service
            $transaction = $this->transactionService->createTransaction([
                "user_id" => $user->id,
                "total_price" => $totalPrice,
                "total_quantity" => $totalQuantity,
                "transaction_details" => $transactionDetails,
            ]);

            // Distribusi tanggal yang lebih merata sepanjang tahun ini
            // 70% di bulan ini dan bulan lalu, 30% sisanya tersebar sejak awal tahun
            if (rand(1, 100) <= 70) {
                $randomDate = Carbon::now()->subDays(rand(0, 45));
            } else {
                $daysSinceYearStart = $startOfYear->diffInDays($today);
                $randomDate = Carbon::now()->subDays(rand(0, $daysSinceYearStart));
            }
            
            // Tambahkan jam acak agar lebih realistik
            $randomDate->setHour(rand(8, 22))->setMinute(rand(0, 59));

            $transaction->created_at = $randomDate;
            $transaction->updated_at = $randomDate;
            $transaction->save();

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info("TransactionSeeder selesai dengan {$count} data beragam.");
    }
}