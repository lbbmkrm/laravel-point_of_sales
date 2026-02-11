<?php

use App\Models\ShopProfile;
use App\Models\Gallery;
use App\Services\ShopProfileService;
use App\Services\ProductService;
use App\Services\CategoryService;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout};
use Illuminate\Database\Eloquent\Collection;

new #[Layout("layouts.landing")] class extends Component {
    public ShopProfile $shopProfile;
    public Collection $products;
    public Collection $categories;
    public Collection $testimonials;
    public Collection $galleries;
    public array $stats = [];
    public ?string $selectedCategory = null;

    public function mount(
        ShopProfileService $shopProfileService,
        ProductService $productService,
        CategoryService $categoryService,
    ): void {
        $this->shopProfile = $shopProfileService->getShopProfile();
        $this->products = $productService->getAllProducts();
        $this->categories = $categoryService->getAllCategories();

        // Fetch Testimonials
        $this->testimonials = \App\Models\Testimonial::where("is_active", true)
            ->orderBy("sort_order")
            ->get();

        // Fetch Stats
        $totalOrders = \App\Models\Transaction::count();
        $totalCups = \App\Models\Transaction::sum("total_quantity");

        $this->stats = [
            "google_rating" => $this->shopProfile->google_rating ?? 4.9,
            "happy_customers" =>
                $totalOrders > 500 ? $totalOrders . "+" : $totalOrders,
            "cups_served" =>
                $totalCups > 1000
                    ? number_format($totalCups / 1000, 1) . "K+"
                    : $totalCups,
            "years_experience" => $this->shopProfile->years_experience ?? 3,
        ];

        $this->galleries = Gallery::orderBy("created_at", "desc")->get();
    }

    public function filterByCategory(
        ProductService $productService,
        ?string $categoryName = null,
    ): void {
        $this->selectedCategory = $categoryName;
        $this->products = $productService->getAllProducts(
            $this->selectedCategory,
        );
    }
}; ?>

<div class="min-h-screen font-Montserrat text-primary-text">
    <!-- Navigation Header -->
    <x-landing.navbar-component :shopProfile="$shopProfile" />
    <main id="home">
        <!-- Hero Section -->
        <x-landing.hero-component :shopProfile="$shopProfile" />

        <!-- About Section -->
        <x-landing.about-component :shopProfile="$shopProfile" />

        <!-- Menu Section -->
        <x-landing.menu-component
            :products="$products"
            :categories="$categories"
            :selectedCategory="$selectedCategory"
        />

        <!-- Testimonials Section -->
        <x-landing.testimonial-component
            :shopProfile="$shopProfile"
            :testimonials="$testimonials"
            :stats="$stats"
        />

        <!-- Gallery Section -->
        <x-landing.gallery-component
            :shopProfile="$shopProfile"
            :galleries="$galleries"
        />

        <!-- Contact & Location Section -->
        <x-landing.contact-component :shopProfile="$shopProfile" />
    </main>

    <!-- Footer -->
    <x-landing.footer-component :shopProfile="$shopProfile" />
</div>
