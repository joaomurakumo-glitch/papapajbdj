<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_list_displays_products_and_stock_status(): void
    {
        Product::create([
            'name' => 'Arroz Tio João 5kg',
            'category' => 'Mercearia',
            'price' => '28.90',
            'stock' => 5,
        ]);
        Product::create([
            'name' => 'Água mineral',
            'category' => 'Bebidas',
            'price' => '2.50',
            'stock' => 6,
        ]);

        $this->get('/products')
            ->assertOk()
            ->assertSee('Arroz Tio João 5kg')
            ->assertSee('Mercearia')
            ->assertSee('badge-danger')
            ->assertSee('Água mineral')
            ->assertSee('badge-success');
    }

    public function test_product_can_be_created(): void
    {
        $this->post('/products', [
            '_form' => 'create',
            'name' => 'Leite integral',
            'category' => 'Bebidas',
            'price' => '5.49',
            'stock' => 12,
        ])->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'name' => 'Leite integral',
            'category' => 'Bebidas',
            'price' => '5.49',
            'stock' => 12,
        ]);
    }

    public function test_invalid_product_is_not_created(): void
    {
        $this->from('/products')
            ->post('/products', [
                '_form' => 'create',
                'name' => '',
                'category' => 'Mercearia',
                'price' => '-2',
                'stock' => -1,
            ])
            ->assertRedirect('/products')
            ->assertSessionHasErrors(['name', 'price', 'stock']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_can_be_updated(): void
    {
        $product = Product::create([
            'name' => 'Feijão',
            'category' => 'Mercearia',
            'price' => '8.00',
            'stock' => 3,
        ]);

        $this->put("/products/{$product->id}", [
            '_form' => "edit:{$product->id}",
            'name' => 'Feijão carioca',
            'category' => 'Mercearia',
            'price' => '9.25',
            'stock' => 20,
        ])->assertRedirect('/products');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Feijão carioca',
            'price' => '9.25',
            'stock' => 20,
        ]);
    }

    public function test_product_can_be_deleted(): void
    {
        $product = Product::create([
            'name' => 'Detergente',
            'category' => 'Limpeza',
            'price' => '2.50',
            'stock' => 8,
        ]);

        $this->delete("/products/{$product->id}")->assertRedirect('/products');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
