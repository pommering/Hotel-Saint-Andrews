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
     * Display a listing of the Usuario.
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
     * Show the form for creating a new Usuario.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create')->with('users', new User());
    }

    /**
     * Store a newly created Usuario in storage.
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

        Flash::success('Usuario saved successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified Usuario.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('users', $usuario);
    }

    /**
     * Show the form for editing the specified Usuario.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $usuario = $this->userRepository->find($id);

        if (empty($usuario)) {
            Flash::error('Usuario not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('users', $usuario);
    }

    /**
     * Update the specified Usuario in storage.
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
            Flash::error('Usuario não encontrado');
            return redirect(route('users.index'));
        }

        $updateUser = [
            'name' => $request->name,
            'username' => $request->username,
            'manager' => $request->manager,
        ];

        if(!empty($request->password)) {
            $updateUser['password'] = Hash::make($request->password);
        }

        $usuario->fill($updateUser)->save();

        Flash::success('Usuário atualizado!');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified Usuario from storage.
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
            Flash::error('Usuario not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuario deleted successfully.');

        return redirect(route('users.index'));
    }


}
