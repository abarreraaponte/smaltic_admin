<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
    	return view('web.profile');
    }

    public function update(Request $request)
    {
    	$request->validate([
    		'name' => 'string|required|max:255',
    		'email' => 'email|required',
    		'password' => 'string|nullable|max:100',
    	]);

    	$user = $request->user();
    	$password = $request->get('password');
    	$email = $request->get('email');

    	$user->name = $request->get('name');

    	if($email != $user->email)
    	{
    		
    		$email_verification = User::where('email', $email)->first();

    		if($email_verification === null)
    		{
    			$user->email = $email;
    		}
    		
    	}

    	if($password != null)
    	{
    		$user->password = Hash::make($password);
    	}

    	$user->save();

    	return redirect('/web/profile/#profile')->with('success', __('Your profile has been updated successfully'));


    }
}
