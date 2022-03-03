<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Flash;
use Response;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Gate;

class UserController extends AppBaseController
{
    /** @var UserRepository $userRepository*/
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepo;
    }

    /**
     * Exibe todos os usuarios.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!Gate::allows('manager')) {
            abort(403);
        }

        $user = $this->userRepository->all();

        return view('users.index')->with('users', $user);
    }

    /**
     * Mostra formulario para criação de um usuario.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create')->with('users', new User());
    }

    /**
     * Criação de um usuario.
     *
     * @param CreateUsuarioRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $niceNames = array(
            'name' => 'Nome',
            'username' => 'Acesso',
            'password' => 'Senha'
        );

        $validator = validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validator->setAttributeNames($niceNames);
        $validator->validate();

        $input['password'] = Hash::make($request->password);

        $usuario = $this->userRepository->create($input);

        Flash::success('Usuário Alterado!');

        return redirect(route('users.index'));
    }

    /**
     * Mostra um usuario especifico.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('users', $usuario);
    }

    /**
     * Exibe um formlario para edição de um usuario.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('users', $usuario);
    }

    /**
     * Atualiza um usuario.
     *
     * @param int $id
     * @param UpdateUsuarioRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('users.index'));
        }

        $updateUser = [
            'name' => $request->name,
            'username' => $request->username,
            'manager' => $request->manager
        ];

        if(!isset($request->manager)) {
            $updateUser['manager'] = $usuario->manager;
        }


        if(!empty($request->password)) {
            $updateUser['password'] = Hash::make($request->password);
        }

        $usuario->fill($updateUser)->save();

        Flash::success('Usuário atualizado!');

        return redirect(route('users.index'));
    }

    /**
     * Remove um usuario.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuário não encontrado');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuario deletado!');

        return redirect(route('users.index'));
    }

}
