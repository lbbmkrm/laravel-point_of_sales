<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Validate};
use App\Models\ApplicationSetting;
use App\Services\ApplicationSettingService;
use App\Models\ShopProfile;
use App\Services\ShopProfileService;

new #[Layout("layouts.app")] #[Title("Settings")] class extends Component {
    protected ?ApplicationSetting $settings = null;
    protected ?ShopProfile $shopProfile = null;

    // Shop Information
    #[Validate("required|string|max:255")]
    public ?string $shopName = null;

    public ?string $shopLogo = null;

    #[Validate("required|string")]
    public ?string $shopAddress = null;

    #[Validate("required|string|max:20")]
    public ?string $shopPhone = null;

    #[Validate("required|email|max:255")]
    public ?string $shopEmail = null;

    #[Validate("nullable|string|max:255")]
    public ?string $shopInstagram = null;

    #[Validate("nullable|string|max:255")]
    public ?string $shopFacebook = null;

    #[Validate("nullable|string|max:255")]
    public ?string $shopTiktok = null;

    // Cashier Settings
    #[Validate("required|string|max:10")]
    public string $currency = "IDR";

    #[Validate("required|string|max:10")]
    public string $currencySymbol = "Rp";

    public bool $taxEnabled = false;

    #[Validate("required|numeric|min:0|max:100")]
    public float $taxRate = 0;

    #[Validate("required|string|max:50")]
    public string $taxLabel = "PPN";

    public bool $serviceChargeEnabled = false;

    #[Validate("required|numeric|min:0|max:100")]
    public float $serviceChargeRate = 0;

    // Landing Page Settings
    #[Validate("nullable|string")]
    public ?string $landingDescription = null;

    #[Validate("required|string")]
    public string $operatingHours = "08:00 - 22:00";

    #[Validate("required|string")]
    public string $operatingDays = "Senin - Minggu";

    #[Validate("nullable|url")]
    public ?string $googleMapsUrl = null;

    // System Settings
    public string $timezone = "Asia/Jakarta";
    public string $dateFormat = "d/m/Y";
    public string $timeFormat = "H:i";

    public function mount(
        ApplicationSettingService $applicationSettingService,
        ShopProfileService $shopProfileService,
    ): void {
        $this->settings = $applicationSettingService->getSettings();
        $this->shopProfile = $shopProfileService->getShopProfile();
        $this->loadData();
    }

    private function loadData(): void
    {
        if (! $this->settings || ! $this->shopProfile) {
            return;
        }

        // Shop Information
        $this->shopLogo = $this->shopProfile->logo;
        $this->shopName = $this->shopProfile->name;
        $this->shopAddress = $this->shopProfile->address;
        $this->shopPhone = $this->shopProfile->phone;
        $this->shopEmail = $this->shopProfile->email;
        $this->shopInstagram = $this->shopProfile->instagram;
        $this->shopFacebook = $this->shopProfile->facebook;
        $this->shopTiktok = $this->shopProfile->tiktok;

        // Cashier Settings
        $this->currency = $this->settings->currency;
        $this->currencySymbol = $this->settings->currency_symbol;
        $this->taxEnabled = $this->settings->tax_enabled;
        $this->taxRate = $this->settings->tax_rate * 100;
        $this->taxLabel = $this->settings->tax_label;
        $this->serviceChargeEnabled = $this->settings->service_charge_enabled;
        $this->serviceChargeRate = $this->settings->service_charge_rate * 100;

        // Landing Page Settings
        $this->landingDescription = $this->shopProfile->landing_description;
        $this->operatingHours = $this->shopProfile->operating_hours;
        $this->operatingDays = $this->shopProfile->operating_days;
        $this->googleMapsUrl = $this->shopProfile->google_maps_url;

        // System Settings
        $this->timezone = $this->settings->timezone;
        $this->dateFormat = $this->settings->date_format;
        $this->timeFormat = $this->settings->time_format;
    }

    public function save(
        ShopProfileService $shopProfileService,
        ApplicationSettingService $applicationSettingService,
    ): void {
        $this->validate();

        try {
            $shopProfileService->updateShopProfile([
                "name" => $this->shopName,
                "logo" => $this->shopLogo,
                "address" => $this->shopAddress,
                "phone" => $this->shopPhone,
                "email" => $this->shopEmail,
                "instagram" => $this->shopInstagram,
                "facebook" => $this->shopFacebook,
                "tiktok" => $this->shopTiktok,
                "landing_description" => $this->landingDescription,
                "operating_hours" => $this->operatingHours,
                "operating_days" => $this->operatingDays,
                "google_maps_url" => $this->googleMapsUrl,
            ]);
            $applicationSettingService->updateSettings([
                "currency" => $this->currency,
                "currency_symbol" => $this->currencySymbol,
                "tax_enabled" => $this->taxEnabled,
                "tax_rate" => $this->taxRate / 100,
                "tax_label" => $this->taxLabel,
                "service_charge_enabled" => $this->serviceChargeEnabled,
                "service_charge_rate" => $this->serviceChargeRate / 100,
                "timezone" => $this->timezone,
                "date_format" => $this->dateFormat,
                "time_format" => $this->timeFormat,
            ]);

            session()->flash("success", "Pengaturan berhasil disimpan!");
        } catch (\Exception $e) {
            session()->flash(
                "error",
                "Gagal menyimpan pengaturan: " . $e->getMessage(),
            );
        }
    }

    public function resetForm(
        ApplicationSettingService $applicationSettingService,
    ): void {
        $this->settings = $applicationSettingService->getSettings();
        $this->loadData();
        session()->flash("success", "Form berhasil direset!");
    }

    public function getDateFormatPreviewProperty(): string
    {
        try {
            return now()->format($this->dateFormat);
        } catch (\Exception $e) {
            return "Format tidak valid";
        }
    }
}; ?>

<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            Pengaturan Aplikasi POS
        </h1>
        <p class="text-gray-600 mt-2">
            Kelola informasi toko, pengaturan kasir, dan konfigurasi sistem
        </p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has("success"))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="ri-check-circle-line text-green-500 text-xl mr-2"></i>
                <span class="text-green-800">{{ session("success") }}</span>
            </div>
        </div>
    @endif

    @if (session()->has("error"))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="ri-error-warning-line text-red-500 text-xl mr-2"></i>
                <span class="text-red-800">{{ session("error") }}</span>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex gap-3 justify-end mb-6">
        <button
            wire:click="resetForm"
            class="px-6 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2"
        >
            <i class="ri-refresh-line"></i>
            Reset
        </button>
        <button
            wire:click="save"
            wire:loading.attr="disabled"
            wire:target="save"
            class="px-6 py-2.5 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors flex items-center gap-2"
        >
            <i class="ri-save-line" wire:loading.remove wire:target="save"></i>
            <i
                class="ri-loader-4-line animate-spin"
                wire:loading
                wire:target="save"
            ></i>
            <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </button>
    </div>

    <!-- Informasi Toko -->
    <section
        class="mb-6 bg-white rounded-xl shadow-md p-6 border border-gray-100"
    >
        <h2
            class="text-xl font-semibold mb-6 flex items-center gap-2 text-gray-800"
        >
            <i class="ri-store-2-line text-amber-500 text-2xl"></i>
            Informasi Toko
        </h2>
        <div class="space-y-5">
            <!-- Logo -->
            <div class="pb-5 border-b border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Logo Toko
                </label>
                <div class="flex items-center gap-4">
                    <div
                        class="w-24 h-24 rounded-xl border-2 border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden"
                    >
                        <svg
                            class="w-12 h-12 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M18.5 2c1.38 0 2.5 1.12 2.5 2.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H8V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H4V4.5C4 3.12 5.12 2 6.5 2h12zM4 19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8H4v11zm8-9c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z"
                            />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <button
                            class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors text-sm"
                            disabled
                        >
                            <i class="ri-upload-2-line mr-1"></i>
                            Upload Logo
                        </button>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="ri-information-line"></i>
                            Format: JPG, PNG (Max 2MB, Rekomendasi: 512x512px)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Nama Toko -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Toko
                </label>
                <input
                    type="text"
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopName") border-red-500 @enderror"
                    wire:model="shopName"
                />
                @error("shopName")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Lengkap
                </label>
                <textarea
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopAddress") border-red-500 @enderror"
                    rows="2"
                    wire:model="shopAddress"
                ></textarea>
                @error("shopAddress")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kontak -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-phone-line text-gray-500"></i>
                        Nomor Telepon
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopPhone") border-red-500 @enderror"
                        wire:model="shopPhone"
                        placeholder="0812-3456-7890"
                    />
                    @error("shopPhone")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-mail-line text-gray-500"></i>
                        Email
                    </label>
                    <input
                        type="email"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopEmail") border-red-500 @enderror"
                        wire:model="shopEmail"
                        placeholder="hello@qiocoffee.com"
                    />
                    @error("shopEmail")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Social Media -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-instagram-line text-gray-500"></i>
                        Instagram
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopInstagram") border-red-500 @enderror"
                        wire:model="shopInstagram"
                        placeholder="@qiocoffee"
                    />
                    @error("shopInstagram")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-facebook-box-line text-gray-500"></i>
                        Facebook
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopFacebook") border-red-500 @enderror"
                        wire:model="shopFacebook"
                        placeholder="Qio Coffee Official"
                    />
                    @error("shopFacebook")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-global-line text-gray-500"></i>
                        Tiktok
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("shopTiktok") border-red-500 @enderror"
                        wire:model="shopTiktok"
                        placeholder="https://www.qiocoffee.com"
                    />
                    @error("shopTiktok")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </section>

    <!-- Pengaturan Kasir -->
    <section
        class="mb-6 bg-white rounded-xl shadow-md p-6 border border-gray-100"
    >
        <h2
            class="text-xl font-semibold mb-6 flex items-center gap-2 text-gray-800"
        >
            <i class="ri-shopping-cart-line text-amber-500 text-2xl"></i>
            Pengaturan Kasir
        </h2>
        <div class="space-y-5">
            <!-- Currency Settings -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-5 border-b border-gray-200"
            >
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mata Uang
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("currency") border-red-500 @enderror"
                        wire:model="currency"
                        placeholder="IDR"
                    />
                    @error("currency")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Simbol Mata Uang
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("currencySymbol") border-red-500 @enderror"
                        wire:model="currencySymbol"
                        placeholder="Rp"
                    />
                    @error("currencySymbol")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tax Section -->
            <div
                class="border-2 border-amber-100 rounded-xl p-4 bg-amber-50/30"
            >
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-800">
                            Pajak Penjualan (PPN)
                        </label>
                        <p class="text-xs text-gray-600 mt-0.5">
                            Aktifkan untuk menambahkan pajak pada transaksi
                        </p>
                    </div>
                    <div
                        class="relative inline-block w-14 h-7 rounded-full cursor-pointer transition-colors"
                        :class="$wire.taxEnabled ? 'bg-amber-500' : 'bg-gray-300'"
                        wire:click="$toggle('taxEnabled')"
                    >
                        <div
                            class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-md transition-all"
                            :class="$wire.taxEnabled ? 'right-1' : 'left-1'"
                        ></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-xs font-medium text-gray-600 mb-1"
                        >
                            Tarif Pajak (0-100%)
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-amber-500 focus:outline-none text-sm @error("taxRate") border-red-500 @enderror"
                            wire:model="taxRate"
                            :disabled="!$wire.taxEnabled"
                        />
                        @error("taxRate")
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-xs font-medium text-gray-600 mb-1"
                        >
                            Label Pajak
                        </label>
                        <input
                            type="text"
                            class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-amber-500 focus:outline-none text-sm @error("taxLabel") border-red-500 @enderror"
                            wire:model="taxLabel"
                            :disabled="!$wire.taxEnabled"
                        />
                        @error("taxLabel")
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Service Charge Section -->
            <div class="border-2 border-gray-200 rounded-xl p-4 bg-gray-50/30">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-800">
                            Service Charge
                        </label>
                        <p class="text-xs text-gray-600 mt-0.5">
                            Biaya layanan tambahan (opsional)
                        </p>
                    </div>
                    <div
                        class="relative inline-block w-14 h-7 rounded-full cursor-pointer transition-colors"
                        :class="$wire.serviceChargeEnabled ? 'bg-amber-500' : 'bg-gray-300'"
                        wire:click="$toggle('serviceChargeEnabled')"
                    >
                        <div
                            class="absolute top-1 w-5 h-5 bg-white rounded-full shadow-md transition-all"
                            :class="$wire.serviceChargeEnabled ? 'right-1' : 'left-1'"
                        ></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label
                            class="block text-xs font-medium text-gray-600 mb-1"
                        >
                            Tarif Service Charge (0-100%)
                        </label>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:border-amber-500 focus:outline-none text-sm @error("serviceChargeRate") border-red-500 @enderror"
                            wire:model="serviceChargeRate"
                            :disabled="!$wire.serviceChargeEnabled"
                        />
                        @error("serviceChargeRate")
                            <p class="text-red-500 text-xs mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                <p class="text-sm text-blue-800 flex items-start gap-2">
                    <i class="ri-information-line text-lg mt-0.5"></i>
                    <span>
                        Pengaturan ini akan diterapkan secara otomatis pada
                        perhitungan di halaman kasir.
                    </span>
                </p>
            </div>
        </div>
    </section>

    <!-- Informasi untuk Landing Page -->
    <section
        class="mb-6 bg-white rounded-xl shadow-md p-6 border border-gray-100"
    >
        <h2
            class="text-xl font-semibold mb-6 flex items-center gap-2 text-gray-800"
        >
            <i class="ri-global-line text-amber-500 text-2xl"></i>
            Informasi untuk Halaman Landing Page
        </h2>
        <div class="space-y-5">
            <div
                class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded mb-4"
            >
                <p class="text-sm text-amber-800 flex items-start gap-2">
                    <i class="ri-lightbulb-line text-lg mt-0.5"></i>
                    <span>
                        Informasi di bawah akan otomatis ditampilkan di halaman
                        publik. Pastikan data selalu akurat untuk kredibilitas
                        toko.
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Toko
                </label>
                <textarea
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("landingDescription") border-red-500 @enderror"
                    rows="3"
                    wire:model="landingDescription"
                    placeholder="Deskripsi singkat tentang toko Anda..."
                    maxlength="200"
                ></textarea>
                @error("landingDescription")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-gray-500 mt-1">Maksimal 200 karakter</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Operasional
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("operatingHours") border-red-500 @enderror"
                        wire:model="operatingHours"
                        placeholder="08:00 - 22:00"
                    />
                    @error("operatingHours")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Hari Operasional
                    </label>
                    <input
                        type="text"
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("operatingDays") border-red-500 @enderror"
                        wire:model="operatingDays"
                        placeholder="Senin - Minggu"
                    />
                    @error("operatingDays")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ri-map-pin-line text-gray-500"></i>
                    Link Google Maps
                </label>
                <input
                    type="url"
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors @error("googleMapsUrl") border-red-500 @enderror"
                    wire:model="googleMapsUrl"
                    placeholder="https://maps.google.com/?q=Qio+Coffee"
                />
                @error("googleMapsUrl")
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-gray-500 mt-1.5">
                    <i class="ri-information-line"></i>
                    Link ini akan muncul sebagai tombol navigasi di landing page
                    untuk memudahkan pelanggan menemukan lokasi toko.
                </p>
            </div>
        </div>
    </section>

    <!-- Pengaturan Sistem -->
    <section
        class="mb-6 bg-white rounded-xl shadow-md p-6 border border-gray-100"
    >
        <h2
            class="text-xl font-semibold mb-6 flex items-center gap-2 text-gray-800"
        >
            <i class="ri-settings-3-line text-amber-500 text-2xl"></i>
            Pengaturan Sistem
        </h2>
        <div class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-time-zone-line text-gray-500"></i>
                        Zona Waktu
                    </label>
                    <select
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors"
                        wire:model="timezone"
                    >
                        <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar">
                            Asia/Makassar (WITA)
                        </option>
                        <option value="Asia/Jayapura">
                            Asia/Jayapura (WIT)
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ri-calendar-line text-gray-500"></i>
                        Format Tanggal
                    </label>
                    <select
                        class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 focus:outline-none transition-colors"
                        wire:model="dateFormat"
                    >
                        <option value="d/m/Y">DD/MM/YYYY (14/11/2025)</option>
                        <option value="m/d/Y">MM/DD/YYYY (11/14/2025)</option>
                        <option value="Y-m-d">YYYY-MM-DD (2025-11-14)</option>
                        <option value="d-m-Y">DD-MM-YYYY (14-11-2025)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Preview:
                        <span class="font-semibold">
                            {{ $this->dateFormatPreview }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Status Footer -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-between text-sm text-gray-500">
            <div class="flex items-center gap-2">
                <i class="ri-information-line text-gray-400"></i>
                <span>
                    Pengaturan akan otomatis diterapkan setelah disimpan
                </span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ri-time-line text-gray-400"></i>
                <span>
                    Terakhir diperbarui:
                    {{ $this->settings?->updated_at?->format("d M Y, H:i") ?? "Belum diperbarui" }}
                </span>
            </div>
        </div>
    </div>
</div>
