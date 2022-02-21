<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCleanRoomRequest;
use App\Repositories\CleanRoomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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

            $room->end_date = strtotime($room->start_date);
            foreach ($room->tasks as $task) {
                $tasks[] = $task->assignment;

                $parts = explode(':', $task->time_execution->time_execution);

                $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];

                $room->end_date += $seconds;

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
        return view('clean_rooms.create')->with('tasks', Array('id' => [], 'timeTask' => []));;
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

        $niceNames = array(
            'room_number' => 'Numero do Quarto',
            'start_date' => 'Data de início',
            'activityItem' => 'Atividades'
        );

        $validator = validator::make($input, [
            'room_number' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'max:255'],
            'activityItem' => ['required', 'exists'],
        ]);

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $tasks = Array();

        foreach ($input['activityItem']['task'] as $key => $task) {
            $tasks[$key]['tarefas_id'] = (int)$task;
        }

        foreach ($input['activityItem']['timeTask'] as $key => $taskTime) {
            $tasks[$key]['time_execution'] = $taskTime;
        }

        if(!Gate::allows('manager')) {
            $input['user_id'] = Auth::user()->id;
        }

        $cleanRoom = $this->cleanRoomRepository->create($input);

        $cleanRoom->tasks()->attach($tasks);

        Flash::success('Limpeza criada com sucesso.');

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
            Flash::error('Limpeza não encontrada.');

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
            Flash::error('Limpeza não encontrada.');

            return redirect(route('cleanRooms.index'));
        }

        $tasks = Array();

        foreach ($cleanRoom->tasks as $key => $task) {
            $tasks['id'][] = $task->id;
            $tasks['time'][$task->id] = $task->time_execution->time_execution;
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
        $input = $request->all();
        $cleanRoom = $this->cleanRoomRepository->find($id);

        if (empty($cleanRoom)) {
            Flash::error('Limpeza não encontrada');

            return redirect(route('cleanRooms.index'));
        }

        $niceNames = array(
            'room_number' => 'Numero do Quarto',
            'start_date' => 'Data de início',
            'activityItem' => 'Atividades'
        );

        $validator = validator::make($input, [
            'room_number' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'max:255'],
            'activityItem' => ['required', 'exists'],
        ]);

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $cleanRoom = $this->cleanRoomRepository->update($request->all(), $id);

        $tasks = [];

        for($i = 0; $i < count($input['activityItem']['task']); $i++) {
            $tasks[$input['activityItem']['task'][$i]] = Array('time_execution' => $input['activityItem']['timeTask'][$i]);
        }

        $cleanRoom->tasks()->sync($tasks);

        Flash::success('Limpeza alterada.');

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

        Flash::success('Limpeza removida!');

        return redirect(route('cleanRooms.index'));
    }
}
