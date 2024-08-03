<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Place;

class PlaceControllerTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
     public function it_returns_all_places()
     {
         Place::factory()->count(3)->create();

         $response = $this->getJson('http://localhost:8085/api/places');

         $response->assertStatus(200)
                  ->assertJsonStructure([
                      'status',
                      'places' => [
                          '*' => [
                              'id',
                              'name',
                              'city',
                              'slug',
                              'created_at',
                              'updated_at'
                          ]
                      ]
                  ]);
     }

     /** @test */
     public function it_returns_not_found_when_no_places_exist()
     {
         $response = $this->getJson('http://localhost:8085/api/places');

         $response->assertStatus(404)
                  ->assertJson([
                      'status' => 404,
                      'message' => 'Places not found'
                  ]);
     }

    /** @test */
    public function it_creates_a_place_successfully()
    {
        $data = [
            'name' => 'Test Place',
            'city' => 'Test City',
            'slug' => 'test-place'
        ];

        $response = $this->postJson('http://localhost:8085/api/place/create', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Place created successfully']);

        $this->assertDatabaseHas('places', [
            'name' => 'Test Place',
            'city' => 'Test City',
            'slug' => 'test-place'
        ]);
    }

    /** @test */
    public function it_returns_validation_errors()
    {
        $data = [
            'name' => '',
            'city' => '',
            'slug' => ''
        ];

        $response = $this->postJson('http://localhost:8085/api/place/create', $data);

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors']);
    }

    /** @test */
    public function it_updates_a_place_successfully()
    {
        $place = Place::factory()->create();

        $data = [
            'name' => 'Updated Place',
            'city' => 'Updated City',
            'slug' => 'updated-place'
        ];

        $response = $this->putJson("http://localhost:8085/api/place/update/{$place->id}", $data);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Place updated successfully']);

        $this->assertDatabaseHas('places', [
            'id' => $place->id,
            'name' => 'Updated Place',
            'city' => 'Updated City',
            'slug' => 'updated-place'
        ]);
    }

    /** @test */
    public function it_returns_not_found_when_updating_non_existent_place()
    {
        $nonExistentPlaceId = 999; // Certifique-se de que este ID não existe no banco de dados

        $data = [
            'name' => 'Updated Place',
            'city' => 'Updated City',
            'slug' => 'updated-place'
        ];

        $response = $this->putJson("http://localhost:8085/api/place/update/{$nonExistentPlaceId}", $data);

        $response->assertStatus(404)
                ->assertJson(['error' => 'Place not found']);
    }

    /** @test */
    public function it_deletes_a_place_successfully()
    {
        $place = Place::factory()->create();

        $response = $this->deleteJson("http://localhost:8085/api/place/delete/{$place->id}");

        $response->assertStatus(200)
                ->assertJson(['message' => 'excluido com sucesso']);

        $this->assertSoftDeleted('places', ['id' => $place->id]);
    }

    /** @test */
    public function it_returns_not_found_when_deleting_non_existent_place()
    {
        $response = $this->deleteJson('http://localhost:8085/api/place/delete/999');

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Place not found']);
    }
}
