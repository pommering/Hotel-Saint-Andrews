<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCleanRoomAPIRequest;
use App\Http\Requests\API\UpdateCleanRoomAPIRequest;
use App\Models\CleanRoom;
use App\Repositories\CleanRoomRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CleanRoomController
 * @package App\Http\Controllers\API
 */

class CleanRoomAPIController extends AppBaseController
{
    /** @var  CleanRoomRepository */
    private $cleanRoomRepository;

    public function __construct(CleanRoomRepository $cleanRoomRepo)
    {
        $this->cleanRoomRepository = $cleanRoomRepo;
    }

    /**
     * Display a listing of the CleanRoom.
     * GET|HEAD /cleanRooms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $cleanRooms = $this->cleanRoomRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($cleanRooms->toArray(), 'Clean Rooms retrieved successfully');
    }

    /**
     * Store a newly created CleanRoom in storage.
     * POST /cleanRooms
     *
     * @param CreateCleanRoomAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCleanRoomAPIRequest $request)
    {
        $input = $request->all();

        $cleanRoom = $this->cleanRoomRepository->create($input);

        return $this->sendResponse($cleanRoom->toArray(), 'Clean Room saved successfully');
    }

    /**
     * Display the specified CleanRoom.
     * GET|HEAD /cleanRooms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CleanRoom $cleanRoom */
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            return $this->sendError('Clean Room not found');
        }

        return $this->sendResponse($cleanRoom->toArray(), 'Clean Room retrieved successfully');
    }

    /**
     * Update the specified CleanRoom in storage.
     * PUT/PATCH /cleanRooms/{id}
     *
     * @param int $id
     * @param UpdateCleanRoomAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCleanRoomAPIRequest $request)
    {
        $input = $request->all();

        /** @var CleanRoom $cleanRoom */
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            return $this->sendError('Clean Room not found');
        }

        $cleanRoom = $this->cleanRoomRepository->update($input, $id);

        return $this->sendResponse($cleanRoom->toArray(), 'CleanRoom updated successfully');
    }

    /**
     * Remove the specified CleanRoom from storage.
     * DELETE /cleanRooms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CleanRoom $cleanRoom */
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            return $this->sendError('Clean Room not found');
        }

        $cleanRoom->delete();

        return $this->sendSuccess('Clean Room deleted successfully');
    }
}
