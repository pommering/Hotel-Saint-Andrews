<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CleanRoom;

class CleanRoomApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/clean_rooms', $cleanRoom
        );

        $this->assertApiResponse($cleanRoom);
    }

    /**
     * @test
     */
    public function test_read_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/clean_rooms/'.$cleanRoom->id
        );

        $this->assertApiResponse($cleanRoom->toArray());
    }

    /**
     * @test
     */
    public function test_update_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();
        $editedCleanRoom = CleanRoom::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/clean_rooms/'.$cleanRoom->id,
            $editedCleanRoom
        );

        $this->assertApiResponse($editedCleanRoom);
    }

    /**
     * @test
     */
    public function test_delete_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/clean_rooms/'.$cleanRoom->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/clean_rooms/'.$cleanRoom->id
        );

        $this->response->assertStatus(404);
    }
}
