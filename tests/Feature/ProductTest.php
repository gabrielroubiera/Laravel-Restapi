<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );
    }

    public function test_index()
    {
        $response = $this->getJson('/api/products');
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_store(){
        $data = [
            'name' => 'Coca Cola',
            'description' => 'Resfresco',
            'inStock' => 10,
            'price' => 20.00
        ];

        $response = $this->postJson('/api/products', $data);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_show()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_update()
    {
        $product = factory(Product::class)->create();

        $data = [
            'name' => 'Coca Cola',
            'description' => 'Resfresco',
            'inStock' => 10,
            'price' => 20.00
        ];

        $response = $this->putJson("/api/products/{$product->getKey()}", $data);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_destroy()
    {
        $product = factory(Product::class)->create();
        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
