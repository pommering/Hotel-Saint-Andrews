<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Exibindo dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Gate::allows('manager')) {
            $time_work = DB::table('clean_room_tarefas')
                ->selectRaw('* ,SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))) as time_work')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->first();

            if(empty($time_work->time_work)) {
                $time_work->time_work = 0;
            }

            $all_clear = DB::table('clean_room_tarefas')
                ->selectRaw('count(*) as all_clear')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->first();

            if(empty($all_clear->all_clear)) {
                $all_clear->all_clear = 0;
            }

            $fast_time = DB::table('clean_room_tarefas')
                ->selectRaw('MIN(time_execution) as fast_time')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->first();

            if(empty($fast_time->fast_time)) {
                $fast_time->fast_time = 0;
            }

        } else {

            $time_work = DB::table('clean_room_tarefas')
                ->selectRaw('* ,SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))) as time_work')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->join('users', 'users.id', '=', 'clean_rooms.user_id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->where('user_id', Auth::user()->id)
                ->first();

            if(empty($time_work->time_work)) {
                $time_work->time_work = 0;
            }

            $all_clear = DB::table('clean_room_tarefas')
                ->selectRaw('count(*) as all_clear')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->join('users', 'users.id', '=', 'clean_rooms.user_id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->where('user_id', Auth::user()->id)
                ->first();

            if(empty($all_clear->all_clear)) {
                $all_clear->all_clear = 0;
            }

            $fast_time = DB::table('clean_room_tarefas')
                ->selectRaw('MIN(time_execution) as fast_time')
                ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
                ->join('users', 'users.id', '=', 'clean_rooms.user_id')
                ->whereYear('start_date', date('Y'))
                ->whereMonth('start_date', date('m'))
                ->whereNull('clean_rooms.deleted_at')
                ->where('user_id', Auth::user()->id)
                ->first();

            if(empty($fast_time->fast_time)) {
                $fast_time->fast_time = 0;
            }
        }

        return view('home')
            ->with('dataInformation',$time_work->time_work)
            ->with('clears', $all_clear->all_clear)
            ->with('fast_time', $fast_time->fast_time);
    }
}
