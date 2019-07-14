<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use	App\User;
use	Spatie\Permission\Models\Role;
use	Illuminate\Support\Facades\Hash;
use	App\Http\Requests\UserEditFormRequest;

class UsersController extends Controller
{
    //
    public	function index()
	{
		$users = User::all();
		return	view('backend.users.index',	compact('users'));
	}

	public function	edit($id)
	{
		$user =	User::whereId($id)->firstOrFail();

		// fetch all roles
		$roles = Role::all();
		// 
		$selectedRoles	= $user->roles()->pluck('name')->toArray();


		return	view('backend.users.edit',	compact('user',	'roles','selectedRoles'));
	}

	// Update Data
	public function	update($id,	UserEditFormRequest	$request)
	{
		$user =	User::whereId($id)->firstOrFail();

		$user->name	= $request->get('name');
		$user->email = $request->get('email');
		$password = $request->get('password');
		
		// save password only if New one was submitted
		if($password !=	"")	{
			$user->password	= Hash::make($password);
		}
		$user->save();

		// syncRoles() method will retrieve the $role array, which contains roles' ID, andattach the appropriate roles to the user
		$user->syncRoles($request->get('role'));
		
		return	redirect(action('Admin\UsersController@edit',	$user->id))->with('status',	'
		The	user	has	been	updated!');
	}


}
