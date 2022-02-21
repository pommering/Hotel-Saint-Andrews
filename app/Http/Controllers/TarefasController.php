<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTarefasRequest;
use App\Http\Requests\UpdateTarefasRequest;
use App\Repositories\TarefasRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Facades\Validator;

class TarefasController extends AppBaseController
{
    /** @var TarefasRepository $tarefasRepository*/
    private $tarefasRepository;

    public function __construct(TarefasRepository $tarefasRepo)
    {
        $this->middleware('auth');
        $this->tarefasRepository = $tarefasRepo;
    }

    /**
     * Mostrando todas tarefas registradas.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tarefas = $this->tarefasRepository->all();

        return view('tarefas.index')
            ->with('tarefas', $tarefas);
    }

    /**
     * Exibindo formulario de criação de tarefas.
     *
     * @return Response
     */
    public function create()
    {
        return view('tarefas.create');
    }

    /**
     * Criação de uma nova tarefa.
     *
     * @param CreateTarefasRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $niceNames = array(
            'assignment' => 'Tarefa',
        );

        $validator = validator::make($input, [
            'assignment' => ['required', 'string', 'max:255']
        ]);

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $tarefas = $this->tarefasRepository->create($input);

        Flash::success('Tarefa criada!');

        return redirect(route('tarefas.index'));
    }

    /**
     * Exibe uma tarefa espeficifa.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Exibe o formulario de edição de uma tarefa.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tarefas = $this->tarefasRepository->find($id);

        if (empty($tarefas)) {
            Flash::error('Tarefa não encontrada');

            return redirect(route('tarefas.index'));
        }

        return view('tarefas.edit')->with('tarefas', $tarefas);
    }

    /**
     * Atualiza uma tarefa.
     *
     * @param int $id
     * @param UpdateTarefasRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $input = $request->all();

        $niceNames = array(
            'assignment' => 'Tarefa',
        );

        $validator = validator::make($input, [
            'assignment' => ['required', 'string', 'max:255']
        ]);

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $tarefas = $this->tarefasRepository->find($id);

        if (empty($tarefas)) {
            Flash::error('Tarefas não encontrada');

            return redirect(route('tarefas.index'));
        }

        $tarefas = $this->tarefasRepository->update($request->all(), $id);

        Flash::success('Tarefa alterada.');

        return redirect(route('tarefas.index'));
    }

    /**
     * Remove uma tarefa especifica.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tarefas = $this->tarefasRepository->find($id);

        if (empty($tarefas)) {
            Flash::error('Tarefa não encontrada');

            return redirect(route('tarefas.index'));
        }

        $this->tarefasRepository->delete($id);

        Flash::success('Tarefa deletada!');

        return redirect(route('tarefas.index'));
    }
}
