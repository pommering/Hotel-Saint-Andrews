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
use DateTime;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function validateDate($date, $format = 'Y-m-d') {
        $dateFormat = DateTime::createFromFormat($format, $date);
        return $dateFormat && $dateFormat->format($format) === $date;
    }

    /**
     * Mostrando na tela o ranking de faxineiras.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $old_date = DB::table('clean_rooms')
            ->selectRaw('start_date')
            ->orderBy('start_date', 'asc')
            ->limit(1)
            ->first();

        $old_date = is_null($old_date->start_date) ? ((int)date('Y')+1) : date('Y', strtotime($old_date->start_date));

        $intervalYears = ((int)date('Y')+1) - (int)$old_date;

        $years_filter = Array();

        for ($i = 0; $i < $intervalYears; $i ++) {
            $years_filter[$old_date+$i] = $old_date+$i;
        }

        $input = $request->all();

        if(array_key_exists('anos', $input) &&
            array_key_exists('mes', $input) &&
            $this->validateDate($input['anos'], 'Y') &&
            $this->validateDate($input['mes'], 'n')
        ) {

            $date_search = [
                date('Y-m-d', strtotime($input['anos'].'-'.$input['mes'].'-01')),
                date('Y-m-t', (strtotime($input['anos'].'-'.$input['mes'].'-01')))
            ];

        } else {

            $date_search = [date('Y-m').'-01', date('Y-m-t')];

        }

        $ranking = DB::table('users')
                    ->selectRaw('user_id, users.name, count(*) as total_tasks, SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))) as total_works_time,  SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))/COUNT(*)) as avg_tasks')
                    ->join('clean_rooms', 'users.id', '=', 'clean_rooms.user_id')
                    ->join('clean_room_tarefas', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                    ->whereBetween('clean_rooms.start_date', $date_search)
                    ->groupBy('users.id')
                    ->orderBy('avg_tasks', 'asc')
                    ->get();

        $rankingInformation = Array();

        foreach ($ranking as $key => $rank) {

            $rankingInformation[$key]['name'] = $rank->name;
            $rankingInformation[$key]['total_tasks'] = $rank->total_tasks;
            $rankingInformation[$key]['total_works_time'] = $rank->total_works_time;

            $max_avg_time = DB::table('clean_room_tarefas')
                    ->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))/COUNT(*)) as avg_task_max, activities.assignment as name_task')
                    ->join('clean_rooms', 'clean_rooms.id', '=', 'clean_room_tarefas.clean_room_id')
                    ->join('activities', 'activities.id', '=', 'clean_room_tarefas.tarefas_id')
                    ->where('user_id', $rank->user_id)
                    ->groupBy('tarefas_id',`user_id`)
                    ->limit(1)
                    ->orderBy('avg_task_max', 'asc')
                    ->first();

            $rankingInformation[$key]['task_max']['time'] = $max_avg_time->avg_task_max;
            $rankingInformation[$key]['task_max']['name_task'] = $max_avg_time->name_task;

            $min_avg_time = DB::table('clean_room_tarefas')
                    ->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))/COUNT(*)) as avg_task_min, activities.assignment as name_task')
                    ->join('clean_rooms', 'clean_rooms.id', '=', 'clean_room_tarefas.clean_room_id')
                    ->join('activities', 'activities.id', '=', 'clean_room_tarefas.tarefas_id')
                    ->where('user_id', $rank->user_id)
                    ->groupBy('tarefas_id',`user_id`)
                    ->limit(1)
                    ->orderBy('avg_task_min', 'desc')
                    ->first();

            $rankingInformation[$key]['task_min']['time'] = $min_avg_time->avg_task_min;
            $rankingInformation[$key]['task_min']['name_task'] = $min_avg_time->name_task;
        }

        return view('ranking.index')->with('ranking', $rankingInformation)->with('years', $years_filter)->with('searchLast', $input);
    }



}
