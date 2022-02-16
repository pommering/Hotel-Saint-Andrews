<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CleanRoom
 * @package App\Models
 * @version February 11, 2022, 3:00 am UTC
 *
 * @property id_clean_room_user
 * @property id_clean_room_activitie
 * @property string $room_number
 * @property unsignedBigInteger $user_id
 * @property unsignedBigInteger $activitie_id
 * @property string $start_date
 * @property string $end_date
 */
class CleanRoom extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'clean_rooms';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'room_number',
        'user_id',
        'activitie_id',
        'start_date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'room_number' => 'string',
        'start_date' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function tasks() {
        return $this->belongsToMany('App\Models\Tarefas')->as('time_execution')->withPivot('time_execution');;
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

}
