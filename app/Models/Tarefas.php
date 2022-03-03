<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tarefas
 * @package App\Models
 * @version February 10, 2022, 11:45 pm UTC
 *
 * @property string $assignment
 */
class Tarefas extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'activities';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $fillable = [
        'assignment',
        'mandatory'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'assignment' => 'string',
        'mandatory' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'assignment' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function clearRooms() {
        return $this->belongsToMany('App\Models\CleanRoom');
    }

}
