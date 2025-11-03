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
            $this->command->info('Tidak ada user atau produk, TransactionSeeder dilewati.');
            return;
        }

        $this->command->getOutput()->progressStart(50);

        // Buat 50 transaksi acak
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $transactionProducts = $products->random(rand(1, 5));

            $totalPrice = 0;
            $totalQuantity = 0;
            $transactionDetails = [];

            foreach ($transactionProducts as $product) {
                $quantity = rand(1, 3);
                $totalPrice += $product->price * $quantity;
                $totalQuantity += $quantity;

                $transactionDetails[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            // Buat transaksi menggunakan service
            $transaction = $this->transactionService->createTransaction([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'total_quantity' => $totalQuantity,
                'transaction_details' => $transactionDetails,
            ]);

            // Atur tanggal pembuatan secara acak dalam 30 hari terakhir
            $randomDate = Carbon::now()->subDays(rand(0, 30));
            $transaction->created_at = $randomDate;
            $transaction->updated_at = $randomDate;
            $transaction->save();

            $this->command->getOutput()->progressAdvance();
        }

        $this->command->getOutput()->progressFinish();
        $this->command->info('TransactionSeeder selesai.');
    }
}