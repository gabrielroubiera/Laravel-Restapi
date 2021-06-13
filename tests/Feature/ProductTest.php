<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
        $response = $this->getJson('/api/products/3');

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

        $response = $this->putJson('/api/products/3', $data);

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function test_destroy()
    {
        $product = factory(Product::class)->create();
        $product->id = 1;
        $response = $this->deleteJson('/api/products/3');

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
