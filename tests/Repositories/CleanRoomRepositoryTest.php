<?php namespace Tests\Repositories;

use App\Models\CleanRoom;
use App\Repositories\CleanRoomRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CleanRoomRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CleanRoomRepository
     */
    protected $cleanRoomRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->cleanRoomRepo = \App::make(CleanRoomRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->make()->toArray();

        $createdCleanRoom = $this->cleanRoomRepo->create($cleanRoom);

        $createdCleanRoom = $createdCleanRoom->toArray();
        $this->assertArrayHasKey('id', $createdCleanRoom);
        $this->assertNotNull($createdCleanRoom['id'], 'Created CleanRoom must have id specified');
        $this->assertNotNull(CleanRoom::find($createdCleanRoom['id']), 'CleanRoom with given id must be in DB');
        $this->assertModelData($cleanRoom, $createdCleanRoom);
    }

    /**
     * @test read
     */
    public function test_read_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();

        $dbCleanRoom = $this->cleanRoomRepo->find($cleanRoom->id);

        $dbCleanRoom = $dbCleanRoom->toArray();
        $this->assertModelData($cleanRoom->toArray(), $dbCleanRoom);
    }

    /**
     * @test update
     */
    public function test_update_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();
        $fakeCleanRoom = CleanRoom::factory()->make()->toArray();

        $updatedCleanRoom = $this->cleanRoomRepo->update($fakeCleanRoom, $cleanRoom->id);

        $this->assertModelData($fakeCleanRoom, $updatedCleanRoom->toArray());
        $dbCleanRoom = $this->cleanRoomRepo->find($cleanRoom->id);
        $this->assertModelData($fakeCleanRoom, $dbCleanRoom->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_clean_room()
    {
        $cleanRoom = CleanRoom::factory()->create();

        $resp = $this->cleanRoomRepo->delete($cleanRoom->id);

        $this->assertTrue($resp);
        $this->assertNull(CleanRoom::find($cleanRoom->id), 'CleanRoom should not exist in DB');
    }
}
