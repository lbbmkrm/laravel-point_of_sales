<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CashierTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unauthenticated_users_are_redirected_from_cashier_page()
    {
        $this->get(route('cashier'))->assertRedirect(route('login'));
    }

    #[Test]
    public function cashier_page_can_be_rendered_for_authenticated_users()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('cashier'))
            ->assertOk()
            ->assertSee('Pesanan Saat Ini');
    }

    #[Test]
    public function it_displays_products_on_the_cashier_page()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => 'Kopi Americano']);

        $this->actingAs($user)
            ->get(route('cashier'))
            ->assertSee('Kopi Americano');
    }

    #[Test]
    public function an_authenticated_user_can_add_a_product_to_the_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product->id)
            ->assertSet('cart.'.$product->id.'.quantity', 1);
    }

    #[Test]
    public function an_authenticated_user_can_remove_a_product_from_the_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product->id)
            ->assertSet('cart.'.$product->id.'.quantity', 1)
            ->call('removeFromCart', $product->id)
            ->assertSet('cart', []);
    }

    #[Test]
    public function an_authenticated_user_can_clear_the_cart()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product1->id)
            ->call('addToCart', $product2->id)
            ->assertSet('cart.'.$product1->id.'.quantity', 1)
            ->assertSet('cart.'.$product2->id.'.quantity', 1)
            ->call('clearCart')
            ->assertSet('cart', []);
    }

    #[Test]
    public function it_calculates_the_total_correctly()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create(['price' => 10000]);
        $product2 = Product::factory()->create(['price' => 15000]);

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product1->id)
            ->call('addToCart', $product2->id)
            ->assertSet('total', 27500.0); // (10000 + 15000) * 1.1
    }

    #[Test]
    public function it_can_process_a_transaction()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 20000]);

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product->id)
            ->set('paymentAmount', 25000)
            ->call('checkout');

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'total_price' => 22000, // 20000 * 1.1
        ]);

        $this->assertDatabaseHas('transaction_details', [
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 20000,
        ]);
    }

    #[Test]
    public function it_shows_an_error_if_payment_is_insufficient()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 20000]);

        Livewire::actingAs($user)
            ->test('dashboard.cashier')
            ->call('addToCart', $product->id)
            ->set('paymentAmount', 10000)
            ->call('checkout')
            ->assertHasErrors(['paymentAmount' => 'Uang yang diterima kurang dari total harga.']);
    }
}
