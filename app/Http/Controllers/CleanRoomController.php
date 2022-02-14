<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCleanRoomRequest;
use App\Repositories\CleanRoomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;

class CleanRoomController extends AppBaseController
{
    /** @var CleanRoomRepository $cleanRoomRepository*/
    private $cleanRoomRepository;

    public function __construct(CleanRoomRepository $cleanRoomRepo)
    {
        $this->middleware('auth');
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

        $tasks = Array();

        foreach ($cleanRooms as &$room) {
            foreach ($room->tasks as $task) {
                $tasks[] = $task->assignment;
            }
            $room->tasksDone = $tasks;
            $tasks = [];
        }

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
        return view('clean_rooms.create')->with('tasks', []);;
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
        $tasks = Array();

        foreach ($input['activityItem'] as $valor) {
           $tasks[] = Array('tarefas_id' => (int)$valor);
        }

        if(!Gate::allows('manager')) {
            $input['user_id']	 = Auth::user()->id;
        }

        $cleanRoom = $this->cleanRoomRepository->create($input);

        $cleanRoom->tasks()->attach($tasks);

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

        $tasks = Array();

        foreach ($cleanRoom->tasks as $task) {
            $tasks[] = $task->assignment;
        }

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        return view('clean_rooms.show')->with('cleanRoom', $cleanRoom)->with('tasksDone', implode (", ", $tasks));
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

        $tasks = Array();

        foreach ($cleanRoom->tasks as $task) {
            $tasks[] = $task->id;
        }

        return view('clean_rooms.edit')->with('cleanRoom', $cleanRoom)->with('tasks', $tasks);
    }

    /**
     * Update the specified CleanRoom in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Clean Room not found');

            return redirect(route('cleanRooms.index'));
        }

        $cleanRoom = $this->cleanRoomRepository->update($request->all(), $id);

        $tasks = Array();

        foreach ($request->activityItem as $valor) {
           $tasks[] = $valor;
        }

        $cleanRoom->tasks()->sync($tasks);

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
