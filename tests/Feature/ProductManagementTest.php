<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;
    private User $cashier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::factory()->create(['role' => 'owner']);
        $this->cashier = User::factory()->create(['role' => 'cashier']);
    }

    #[Test]
    public function unauthenticated_users_are_redirected_from_products_page()
    {
        $this->get(route('products'))->assertRedirect(route('login'));
    }

    #[Test]
    public function products_page_can_be_rendered_for_owner()
    {
        $this->actingAs($this->owner)
            ->get(route('products'))
            ->assertOk()
            ->assertSeeLivewire('dashboard.product')
            ->assertSee('Daftar Produk');
    }

    #[Test]
    public function it_displays_products_from_database_for_owner()
    {
        $product = Product::factory()->create(['name' => 'Kopi Susu Gula Aren']);

        $this->actingAs($this->owner)
            ->get(route('products'))
            ->assertSee('Kopi Susu Gula Aren');
    }

    #[Test]
    public function an_owner_can_create_a_product()
    {
        $category = \App\Models\Category::factory()->create();

        Livewire::actingAs($this->owner)
            ->test('dashboard.product')
            ->set('name', 'Espresso')
            ->set('description', 'Kopi hitam pekat.')
            ->set('price', 15000)
            ->set('category_id', $category->id)
            ->call('save');

        $this->assertDatabaseHas('products', [
            'name' => 'Espresso',
            'price' => 15000,
            'category_id' => $category->id,
        ]);
    }

    #[Test]
    public function product_creation_requires_a_name_for_owner()
    {
        $category = \App\Models\Category::factory()->create();
        Livewire::actingAs($this->owner)
            ->test('dashboard.product')
            ->call('openModal')
            ->set('name', '')
            ->set('description', 'Deskripsi valid.')
            ->set('price', 10000)
            ->set('category_id', $category->id)
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }

    #[Test]
    public function an_owner_can_update_a_product()
    {
        $product = Product::factory()->create();
        $category = \App\Models\Category::factory()->create();

        Livewire::actingAs($this->owner)
            ->test('dashboard.product')
            ->call('edit', $product)
            ->set('name', 'Updated Name')
            ->set('price', 25000)
            ->set('category_id', $category->id)
            ->call('save');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => '25000',
        ]);
    }

    #[Test]
    public function an_owner_can_delete_a_product()
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', ['id' => $product->id]);

        Livewire::actingAs($this->owner)
            ->test('dashboard.product')
            ->call('delete', $product)
            ->call('confirmDelete');

        $this->assertModelMissing($product);
    }
}
