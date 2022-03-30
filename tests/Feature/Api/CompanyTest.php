<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $endpoint = '/companies';
    /**
     * get all companies.
     *
     * @return void
     */
    public function test_get_all_Categories()
    {

        Company::factory()->count(10)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertJsonCount(10, 'data');
        $response->assertStatus(200);
    }

    /**
     * erorr get all company.
     *
     * @return void
     */

    public function test_error_get_single_company()
    {
        $company = 'fake-uuid';

        $response = $this->getJson("{$this->endpoint}/{$company}");

        $response->assertStatus(404);
    }
    /**
     * get all company.
     *
     * @return void
     */

    public function test_get_single_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$company->uuid}");

        $response->assertStatus(200);
    }

    /**
     * validation store company.
     *
     * @return void
     */

    public function test_validation_store_company()
    {
        $company = Company::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'name' => '',

        ]);

        $response->dump();

        $response->assertStatus(422);
    }

    /**
     * store company.
     *
     * @return void
     */

    public function test_store_company()
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'category_id' => $category->id,
            'name' => 'Empresa 01',
            'email' => 'empresa01@empresa1.com.br',
            'whatsapp' => '999999999'
        ]);

        $response->assertStatus(201);
    }

    /**
     * update company.
     *
     * @return void
     */

    public function test_update_company()
    {

        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'Empresa 01',
            'email' => 'empresa01@empresa1.com.br',
            'whatsapp' => '999999999'
        ];
        $response = $this->putJson("$this->endpoint/fake-company", $data);
        $response->assertStatus(404);

        $response = $this->putJson("$this->endpoint/{$company->uuid}", []);
        $response->assertStatus(422);

        $response = $this->putJson("$this->endpoint/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * delete company.
     *
     * @return void
     */

    public function test_delete_company()
    {

        $company = Company::factory()->create();


        $response = $this->deleteJson("$this->endpoint/fake-company");
        $response->assertStatus(404);

        $response = $this->deleteJson("$this->endpoint/{$company->uuid}");
        $response->assertStatus(204);
    }
}
