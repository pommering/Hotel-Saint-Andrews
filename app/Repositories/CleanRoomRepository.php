<?php

namespace App\Repositories;

use App\Models\CleanRoom;
use App\Repositories\BaseRepository;

/**
 * Class CleanRoomRepository
 * @package App\Repositories
 * @version February 11, 2022, 3:00 am UTC
*/

class CleanRoomRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'room_number',
        'user_id',
        'activitie_id',
        'start_date',
        'end_date'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CleanRoom::class;
    }
}
