<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    protected $endpoint = '/categories';
    /**
     * get all categories.
     *
     * @return void
     */
    public function test_get_all_Categories()
    {

        Category::factory()->count(10)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(10, 'data');
        $response->assertStatus(200);
    }

    /**
     * erorr get all categories.
     *
     * @return void
     */

    public function test_error_get_single_category()
    {
        $category = 'fake-url';

        $response = $this->getJson("{$this->endpoint}/{$category}");

        $response->assertStatus(404);
    }
    /**
     * get all categories.
     *
     * @return void
     */

    public function test_get_single_category()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$category->url}");

        $response->assertStatus(200);
    }

    /**
     * validation store category.
     *
     * @return void
     */

    public function test_validation_store_category()
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'title' => '',
            'description' => ''
        ]);

        $response->dump();

        $response->assertStatus(422);
    }

    /**
     * store category.
     *
     * @return void
     */

    public function test_store_category()
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'title' => 'Category 01',
            'description' => 'Description of category'
        ]);

        $response->assertStatus(201);
    }

    /**
     * update category.
     *
     * @return void
     */

    public function test_update_category()
    {

        $category = Category::factory()->create();

        $data = [
            'title' => 'title updated',
            'description' => 'description updated'
        ];
        $response = $this->putJson("$this->endpoint/fake-category", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$category->url}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$category->url}", $data);
        $response->assertStatus(200);
    }

    /**
     * delete category.
     *
     * @return void
     */

    public function test_delete_category()
    {

        $category = Category::factory()->create();


        $response = $this->deleteJson("$this->endpoint/fake-category");
        $response->assertStatus(404);

        $response = $this->deleteJson("$this->endpoint/{$category->url}");
        $response->assertStatus(204);
    }
}
