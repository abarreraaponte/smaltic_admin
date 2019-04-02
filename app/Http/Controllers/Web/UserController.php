<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::active()->get();
        $roles = User::roles();
        return view('web.users.index', compact('users', 'roles'));
    }

    /**
     * List Inactive records
     */
    public function inactives()
    {
        $users = User::inactive()->orderBy('name', 'asc')->get();
        return view('web.users.inactives', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'string|required|max:100',
            'email' => 'email|required|unique:users',
            'role' => 'string|required|max:10',
        ]);

        $user = new User;
        $user->uuid = Str::uuid();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role = $request->get('role');
        $user->password = Hash::make('Smaltic2019');
        $user->save();

        return redirect('/web/users')->with('success', 'The user has been created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'string|required|max:100',
            'email' => 'email|required|unique:users',
            'role' => 'string|required|max:10',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->role = $request->get('role');
        $user->save();
        
        return redirect('/web/users')->with('success', 'The user has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if($user->canBeDeleted() === true)
        {
           if($user->id === $request->user()->id)
            {
                return back()->with('warning', 'A user cannot delete himself');
            }

            else 
            {
                 $user->delete();
            }

            return redirect('/web/users')->with('success', 'The user has been deleted successfully');
        }
        else
        {
            return back()->with('errors', 'This user cannot be deleted due to related records. Use inactivate instead');
        }
    }

    public function inactivate(Request $request, User $user)
    {
        if($user->id === $request->user()->id)
        {
            return back()->with('warning', 'A user cannot deactivate himself');
        }

        else 
        {
             $user->inactivate();
        }
       
        return back()->with('success', 'The user has been deactivated');
    }

    public function reactivate(User $user)
    {
        $user->reactivate();
        return redirect('/web/users')->with('success', 'The user has been reactivated');
    }
}
