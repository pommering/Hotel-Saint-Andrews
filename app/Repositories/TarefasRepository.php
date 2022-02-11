<?php

namespace App\Repositories;

use App\Models\Tarefas;
use App\Repositories\BaseRepository;

/**
 * Class TarefasRepository
 * @package App\Repositories
 * @version February 10, 2022, 11:45 pm UTC
*/

class TarefasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'assignment'
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
        return Tarefas::class;
    }
}
