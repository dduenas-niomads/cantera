<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $userList = User::whereNull(User::TABLE_NAME . '.deleted_at')->with('role')->get();
        return view('users.index', compact('userList'));
    }

    public function showReport(Request $request)
    {
        return view('users.report');
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::whereNull(Role::TABLE_NAME . '.deleted_at')->get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function create()
    {
        $roles = Role::whereNull(Role::TABLE_NAME . '.deleted_at')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $user = DB::table('users')->insert([
            'name' => (isset($params['name']) ? $params['name'] : 'Asesor'),
            'lastname' => (isset($params['lastname']) ? $params['lastname'] : 'Asesor'),
            'email' => (isset($params['email']) ? $params['email'] : null),
            'rols_id' => (isset($params['rols_id']) ? $params['rols_id'] : 1),
            'email_verified_at' => now(),
            'password' => Hash::make($params['password']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $message = "Usuario creado correctamente";
        $messageClass = "success";

        return redirect()->route(User::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, ProfileRequest $request)
    {
        $user = User::find($id);
        $message = "Usuario no pudo ser actualizado";
        if (!is_null($user)) {
            $params = $request->all();
            $user->update($request->all());
            $message = "Usuario actualizado correctamente";
        }
        return back()->withStatus($message);
    }
    
    public function destroy($id)
    {
        $user = User::find($id);
        $message = "Usuario no pudo ser eliminado";
        $messageClass = "danger";
        
        if (!is_null($user)) {
            $user->deleted_at = date("Y-m-d H:i:s");
            $user->password = "-";
            $user->save();
            $message = "Usuario eliminado correctamente";
            $messageClass = "success";
        }

        return redirect()->route(User::MODULE_NAME . '.index')
            ->with( ['message' => $message, 'messageClass' => $messageClass ] );
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password($id, PasswordRequest $request)
    {
        $user = User::find($id);
        $message = "Contraseña de usuario no pudo ser actualizada";
        if (!is_null($user)) {   
            $user->update(['password' => Hash::make($request->get('password'))]);
            $message = "Contraseña de usuario actualizada correctamente";
        }
        return back()->withPasswordStatus(__($message));
    }
    
    public function createNewUserService(Request $request)
    {
        $params = $request->all();
        $user = DB::table('users')->insert([
            'name' => (isset($params['name']) ? $params['name'] : 'Asesor'),
            'email' => (isset($params['email']) ? $params['email'] : null),
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $user;
    }
}
