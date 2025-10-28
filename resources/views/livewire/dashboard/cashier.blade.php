<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Computed, Validate};
use App\Services\{ProductService, TransactionService};

new
#[Layout('layouts.app')]
#[Title('Cashier')]
class extends Component {
    public array $products = [];
    public array $cart = [];
    public bool $showCheckout = false;
    public bool $showSuccess = false;
    
    #[Validate('required|numeric|min:0')]
    public int|float|null $paymentAmount = null;
    
    public ?float $change = null;
    public ?float $successTotal = null;
    public ?float $successPayment = null;
    public ?float $successChange = null;

    public function mount(ProductService $productService): void 
    {
        $this->products = $productService->getAllProducts()->toArray();
    }

    #[Computed]
    public function subtotal(): float
    {
        return collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    #[Computed]
    public function tax(): float
    {
        return $this->subtotal() * config('services.tax_rate');
    }

    #[Computed]
    public function taxRateLabel():string {
        $rate = config('services.tax_rate') * 100;
        return "PPN $rate%";
    }

    #[Computed]
    public function total(): float
    {
        return $this->subtotal() + $this->tax();
    }

    public function addToCart($productId): void
    {
        $product = collect($this->products)->firstWhere('id', $productId);

        if (!$product) {
            $this->dispatch('alert', 'Produk tidak ditemukan');
            return;
        }

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
            ];
        }
    }

    public function removeFromCart($productId): void
    {
        unset($this->cart[$productId]);
    }

    public function clearCart(): void
    {
        $this->cart = [];
    }

    public function openCheckoutModal(): void
    {
        if (empty($this->cart)) {
            $this->dispatch('alert', 'Keranjang masih kosong!');
            return;
        }
        $this->showCheckout = true;
    }

    public function closeAndResetModal():void {
        $this->showCheckout = false;
        $this->resetErrorBag();
        $this->reset('paymentAmount', 'change');
    }

    public function updatedPaymentAmount($value):void {
        if(is_numeric($value) && $value > 0) {
            $this->change = (float) $value - $this->total();
            $this->resetErrorBag('paymentAmount');
        }else{
            $this->reset('change');
        }
    }

    public function setQuickAmount($amount): void
    {
        $this->paymentAmount = $amount;
        $this->change = (float) $this->paymentAmount - $this->total();
        $this->resetErrorBag('paymentAmount');
    }

    public function setExactAmount(): void
    {
        $this->paymentAmount = ceil($this->total());
        $this->change = (float) $this->paymentAmount - $this->total();
        $this->resetErrorBag('paymentAmount');
    }

   public function checkout(TransactionService $transactionService): void
    { 
        $this->validate();
        
        if ($this->paymentAmount < $this->total()) {
            $this->addError('paymentAmount', 'Uang yang diterima kurang dari total harga.');
            return;
        }

        try {
            $finalTotal = $this->total();
            $finalPaymentAmount = $this->paymentAmount;
            $finalChange = $this->change;

            $transaction = $transactionService->createTransaction([
                'user_id' => auth()->id(),
                'total_price' => $finalTotal,
                'total_quantity' => collect($this->cart)->sum('quantity'),
                'transaction_details' => collect($this->cart)->map(fn($item) => [
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ])->toArray(),
            ]); 
            
            $this->reset(['cart', 'paymentAmount', 'change', 'showCheckout']);
            
            $this->showSuccess = true;

            $this->successTotal = $finalTotal;
            $this->successPayment = $finalPaymentAmount;
            $this->successChange = $finalChange;

            session()->flash('success', 'Transaksi berhasil #' . $transaction->id);
            
        } catch (\Exception $e) {
            logger()->error('Checkout failed', ['error' => $e->getMessage()]);
            $this->addError('checkout', 'Gagal melakukan transaksi: ' . $e->getMessage());
        }
    }
};
?>
<div x-data>
    <!-- Content Area -->
    <div class="flex flex-col overflow-hidden md:flex-row">
        <!-- Menu Section -->
        <div class="md:w-[70%] flex-1 p-4 overflow-y-auto md:p-6">
            <!-- Menu Grid -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($products as $product)
                    <div
                        wire:click="addToCart({{ $product['id'] }})"
                        wire:loading.class="opacity-50 pointer-events-none"
                        wire:target="addToCart({{ $product['id'] }})"
                        class="menu-item bg-white rounded-xl p-3 cursor-pointer hover:shadow-lg transition-all duration-200 md:p-4 relative"
                    >
                        <div wire:loading wire:target="addToCart({{ $product['id'] }})" 
                             class="absolute inset-0 flex items-center justify-center bg-white/80 rounded-xl z-10">
                            <svg class="animate-spin h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        
                        <div class="bg-amber-100 rounded-lg h-24 flex items-center justify-center mb-2 md:h-32 md:mb-3">
                           <img src="{{ $product['image'] ?? asset('images/default-coffee-menu.jpg') }}"
                8              alt="{{ $product['name'] }}"
                9              class="w-full h-full object-cover rounded-lg">
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1 text-sm md:text-base">
                            {{ $product['name'] }}
                        </h3>
                        <p class="text-amber-600 font-bold text-sm md:text-base">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart Section -->
        <div class="md:w-[30%] bg-white p-4 shadow-lg flex flex-col">
            <div class="mb-4 md:mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-2 md:text-xl">
                    Pesanan Saat Ini
                </h2>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto mb-4 md:mb-6">
                @forelse ($cart as $item)
                    <div wire:key="{{ $item['id'] }}" class="flex justify-between items-center py-3 border-b last:border-0">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">
                                Qty: {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="text-right ml-4">
                            <p class="font-semibold text-gray-800">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </p>
                            <button 
                                wire:click="removeFromCart({{ $item['id'] }})" 
                                class="text-red-500 cursor-pointer text-xs mt-1 hover:text-red-700 hover:underline transition"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                        <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <p class="font-medium">Belum ada pesanan</p>
                        <p class="text-sm mt-1">Pilih menu untuk memulai</p>
                    </div>
                @endforelse
            </div>

            <!-- Summary -->
            <div class="border-t pt-4 space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>{{$this->taxRateLabel}}</span>
                    <span>Rp {{ number_format($this->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800 border-t pt-3">
                    <span>Total</span>
                    <span>Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 mt-4 md:mt-6">
                <button
                    wire:click="clearCart"
                    @disabled(empty($cart))
                    class="w-full py-3 border-2 cursor-pointer border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Hapus Semua
                </button>
                <button
                    wire:click="openCheckoutModal"
                    @disabled(empty($cart))
                    class="w-full py-3 cursor-pointer bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-700 transition text-sm md:text-base disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div 
        x-show="$wire.showCheckout"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        role="dialog"
        aria-modal="true"
        aria-labelledby="checkout-title"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    >
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl"
        >
            <div class="flex justify-between items-center mb-6">
                <h3 id="checkout-title" class="text-xl font-bold text-gray-800">
                    Konfirmasi Pembayaran
                </h3>
                <button 
                    wire:click="closeAndResetModal" 
                    aria-label="Tutup modal"
                    class="text-gray-400 cursor-pointer hover:text-gray-600 transition"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            @if($errors->has('checkout'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ $errors->first('checkout') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-amber-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="font-semibold">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">{{$this->taxRateLabel}}</span>
                    <span class="font-semibold">Rp {{ number_format($this->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-amber-600 border-t border-amber-200 pt-2 mt-2">
                    <span>Total Bayar:</span>
                    <span>Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mb-4">
                <label for="paymentAmount" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jumlah Uang Diterima
                </label>
                <input
                    id="paymentAmount"
                    type="number"
                    wire:model.live.debounce.1000ms="paymentAmount"
                    @class([
                        'w-full px-4 py-3 border-2 rounded-lg focus:outline-none text-lg transition',
                        'border-red-300 focus:border-red-500' => $errors->has('paymentAmount'),
                        'border-gray-300 focus:border-amber-500' => !$errors->has('paymentAmount'),
                    ])
                    placeholder="Masukkan jumlah"
                    min="0"
                    step="1000"
                />
                @error('paymentAmount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($change !== null && $change >= 0)
                <div class="bg-green-50 rounded-lg p-3 border-2 border-green-200 mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-semibold">Kembalian:</span>
                        <span class="text-xl font-bold text-green-600">
                            Rp {{ number_format($change, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @elseif($paymentAmount && $change < 0)
                <div class="bg-red-50 rounded-lg p-3 border-2 border-red-200 mb-4">
                    <p class="text-red-600 font-semibold text-center">
                        Uang tidak cukup! Kurang Rp {{ number_format(abs($change), 0, ',', '.') }}
                    </p>
                </div>
            @endif

            <div class="grid grid-cols-3 gap-2 mb-6">
                <button 
                    type="button"
                    wire:click="setQuickAmount(50000)" 
                    @class([
                        'px-3 py-2 cursor-pointer rounded-lg font-semibold text-sm transition',
                        'bg-amber-100 border-2 border-amber-500 text-amber-700' => $paymentAmount == 50000,
                        'bg-gray-100 hover:bg-gray-200' => $paymentAmount != 50000,
                    ])
                >
                    50k
                </button>
                <button 
                    type="button"
                    wire:click="setQuickAmount(100000)" 
                    @class([
                        'px-3 py-2 cursor-pointer rounded-lg font-semibold text-sm transition',
                        'bg-amber-100 border-2 border-amber-500 text-amber-700' => $paymentAmount == 100000,
                        'bg-gray-100 hover:bg-gray-200' => $paymentAmount != 100000,
                    ])
                >
                    100k
                </button>
                <button 
                    type="button"
                    wire:click="setExactAmount" 
                    @class([
                        'px-3 py-2 cursor-pointer rounded-lg font-semibold text-sm transition',
                        'bg-amber-100 border-2 border-amber-500 text-amber-700' => $paymentAmount == ceil($this->total),
                        'bg-gray-100 hover:bg-gray-200' => $paymentAmount != ceil($this->total),
                    ])
                >
                    Pas
                </button>
            </div>

            <button
                wire:click="checkout"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-75 cursor-wait"
                @disabled($paymentAmount === null || ($change !== null && $change < 0))
                @class([
                    'w-full py-3 rounded-lg cursor-pointer font-semibold transition relative',
                    'bg-green-500 text-white hover:bg-green-600' => $paymentAmount !== null && ($change === null || $change >= 0),
                    'bg-gray-300 text-gray-500 cursor-not-allowed' => $paymentAmount === null || ($change !== null && $change < 0),
                ])
            >
                <span wire:loading.remove wire:target="checkout">
                    Konfirmasi Pembayaran
                </span>
                <span wire:loading wire:target="checkout" class="flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>
    </div>

    <!-- Success Modal -->
    <div 
        x-show="$wire.showSuccess"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        role="dialog"
        aria-modal="true"
        aria-labelledby="success-title"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    >
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl text-center md:p-8"
        >
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 md:w-20 md:h-20">
                <svg class="w-8 h-8 text-green-500 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 id="success-title" class="text-xl font-bold text-gray-800 mb-2 md:text-2xl">
                Pembayaran Berhasil!
            </h3>
            <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">
                Transaksi telah berhasil diproses
            </p>

            <div class="bg-gray-50 rounded-lg p-3 mb-4 md:p-4 md:mb-6">
                <div class="flex justify-between mb-2 text-sm md:text-base">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold">Rp {{ number_format($this->successTotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-2 text-sm md:text-base">
                    <span class="text-gray-600">Dibayar:</span>
                    <span class="font-bold">Rp {{ number_format($this->successPayment, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-green-600 font-bold text-sm md:text-base">
                    <span>Kembalian:</span>
                    <span>Rp {{ number_format($successChange ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

             <button 
                    wire:click="$set('showSuccess', false)" 
                    aria-label="Tutup modal"
                    class="text-gray-400 cursor-pointer hover:text-gray-600 transition"
                >
                Selesai
            </button>
        </div>
    </div>
</div>