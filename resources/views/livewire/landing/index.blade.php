<?php

use App\Models\ShopProfile;
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
    public ?string $selectedCategory = null;

    public function mount(
        ShopProfileService $shopProfileService,
        ProductService $productService,
        CategoryService $categoryService,
    ): void {
        $this->shopProfile = $shopProfileService->getShopProfile();
        $this->products = $productService->getAllProducts();
        $this->categories = $categoryService->getAllCategories();
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
        <x-landing.testimonial-component :shopProfile="$shopProfile" />

        <!-- Gallery Section -->
        <x-landing.gallery-component :shopProfile="$shopProfile" />

        <!-- Contact & Location Section -->
        <x-landing.contact-component :shopProfile="$shopProfile" />
    </main>

    <!-- Footer -->
    <x-landing.footer-component :shopProfile="$shopProfile" />
</div>
