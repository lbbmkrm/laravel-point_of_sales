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

    #[Test]
    public function unauthenticated_users_are_redirected_from_products_page()
    {
        $this->get(route('products'))->assertRedirect(route('login'));
    }

    #[Test]
    public function products_page_can_be_rendered_for_authenticated_users()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('products'))
            ->assertOk()
            ->assertSeeLivewire('dashboard.product')
            ->assertSee('Manajemen Produk');
    }

    #[Test]
    public function it_displays_products_from_database()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Kopi Susu Gula Aren']);

        $this->actingAs($user)
            ->get(route('products'))
            ->assertSee('Kopi Susu Gula Aren');
    }

    #[Test]
    public function an_authenticated_user_can_create_a_product()
    {
        $user = User::factory()->create();
        $category = \App\Models\Category::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.product')
            ->set('form.name', 'Espresso')
            ->set('form.description', 'Kopi hitam pekat.')
            ->set('form.price', 15000)
            ->set('form.category_id', $category->id)
            ->call('save');

        $this->assertDatabaseHas('products', [
            'name' => 'Espresso',
            'price' => 15000,
            'category_id' => $category->id,
        ]);
    }

    #[Test]
    public function product_creation_requires_a_name()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.product')
            ->set('form.name', '') // Invalid name
            ->set('form.description', 'Deskripsi valid.')
            ->set('form.price', 10000)
            ->call('save')
            ->assertHasErrors(['form.name' => 'required']);
    }

    #[Test]
    public function an_authenticated_user_can_update_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.product')
            ->call('edit', $product)
            ->set('form.name', 'Updated Name')
            ->set('form.price', 25000)
            ->call('save');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => '25000.00',
        ]);
    }

    #[Test]
    public function an_authenticated_user_can_delete_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', ['id' => $product->id]);

        Livewire::actingAs($user)
            ->test('dashboard.product')
            ->call('delete', $product)
            ->call('confirmDelete');

        $this->assertModelMissing($product);
    }
}
