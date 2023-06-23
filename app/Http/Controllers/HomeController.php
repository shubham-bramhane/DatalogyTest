<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // getdata

    public function getdata()
    {
        $users = User::get();
        return response()->json($users);
    }


    // delete

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return response()->json();
    }

    // edit

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }

    // update

    public function update(Request $request)
    {
            $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'password' => 'required',
            'passwordConfirmation' => 'required | same:password',
        ]);

        // id: id,
            // firstName: firstName,
            // lastName: lastName,
            // email: email,
            // password: password,
            // passwordConfirmation: passwordConfirmation,


        $user = User::find($request->id);
        $user->name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json($user);
    }
}
