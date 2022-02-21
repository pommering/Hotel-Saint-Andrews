<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {


        $dayBetweenNow = 1;

        $dateInitial = date("Y")."-".date('m')."-".$dayBetweenNow;
        $dateFinal = date('Y-m-d', strtotime($dateInitial. ' + 30 days'));

        //SELECT *,  FROM `clean_room_tarefas` INNER JOIN clean_rooms ON clean_room_id = clean_rooms.id GROUP BY day;

        if (Gate::allows('manager')) {
            $horasTrabalhadas = DB::table('clean_room_tarefas')
            ->selectRaw('*, SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))) as horas, DATE(start_date) as date, DAY(start_date) as day')
            ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
            ->whereBetween('clean_rooms.start_date', [$dateInitial , $dateFinal])
            ->groupBy('date')
            ->get();
        }else {
            $horasTrabalhadas = DB::table('clean_room_tarefas')
            ->selectRaw('*, SEC_TO_TIME(SUM(TIME_TO_SEC(`time_execution`))) as horas, DATE(start_date) as date, DAY(start_date) as day')
            ->join('clean_rooms', 'clean_room_tarefas.clean_room_id', '=', 'clean_rooms.id')
            ->whereBetween('clean_rooms.start_date', [$dateInitial , $dateFinal])
            ->where('user_id', Auth::user()->id)
            ->groupBy('date')
            ->get();
        }

        $horasDays = Array();

        foreach ($horasTrabalhadas as $hour) {
            $horasDays[(int)$hour->day] = $hour->horas;
        }

        $days = Array();
        $dados = Array();

        for( $i = $dayBetweenNow; $i < $dayBetweenNow+15; $i++ )  {

            if(array_key_exists($i,$horasDays)) {
                $parts = explode(':', $horasDays[$i]);
                $seconds = ($parts[0] * 60 * 60) + ($parts[1] * 60) + $parts[2];
                $dados[] = round($seconds/60/60, 3);
            }else {
                $dados[] = 0;
            }
            $days[] = 'Dia '.($dayBetweenNow);
            if($dayBetweenNow > (int)date('t')) {
                $dayBetweenNow = 1;
            }
            $dayBetweenNow++;
        }


        return Chartisan::build()
            ->labels($days)
            ->dataset('Horas', $dados);
    }
}
