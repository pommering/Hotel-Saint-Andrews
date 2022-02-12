<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCleanRoomRequest;
use App\Http\Requests\UpdateCleanRoomRequest;
use App\Repositories\CleanRoomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CleanRoomController extends AppBaseController
{
    /** @var CleanRoomRepository $cleanRoomRepository*/
    private $cleanRoomRepository;

    public function __construct(CleanRoomRepository $cleanRoomRepo)
    {
        $this->cleanRoomRepository = $cleanRoomRepo;
    }

    /**
     * Display a listing of the CleanRoom.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $cleanRooms = $this->cleanRoomRepository->all();

        return view('clean_rooms.index')
            ->with('cleanRooms', $cleanRooms);
    }

    /**
     * Show the form for creating a new CleanRoom.
     *
     * @return Response
     */
    public function create()
    {
        return view('clean_rooms.create');
    }

    /**
     * Store a newly created CleanRoom in storage.
     *
     * @param CreateCleanRoomRequest $request
     *
     * @return Response
     */
    public function store(CreateCleanRoomRequest $request)
    {
        $input = $request->all();

        $cleanRoom = $this->cleanRoomRepository->create($input);

        Flash::success('Clean Room saved successfully.');

        return redirect(route('cleanRooms.index'));
    }

    /**
     * Display the specified CleanRoom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        return view('clean_rooms.show')->with('cleanRoom', $cleanRoom);
    }

    /**
     * Show the form for editing the specified CleanRoom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        return view('clean_rooms.edit')->with('cleanRoom', $cleanRoom);
    }

    /**
     * Update the specified CleanRoom in storage.
     *
     * @param int $id
     * @param UpdateCleanRoomRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCleanRoomRequest $request)
    {
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        $cleanRoom = $this->cleanRoomRepository->update($request->all(), $id);

        Flash::success('Clean Room updated successfully.');

        return redirect(route('cleanRooms.index'));
    }

    /**
     * Remove the specified CleanRoom from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        $this->cleanRoomRepository->delete($id);

        Flash::success('Clean Room deleted successfully.');

        return redirect(route('cleanRooms.index'));
    }
}
