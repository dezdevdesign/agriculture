<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        if(auth()->user()->position == 'Admin') {
            return $dataTable->render('users.index');
        }else {
            return redirect('/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|min:6|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'contact' => 'nullable',
            'municipality' => 'required', 
            'position' => 'required'
        ]);

        User::create([
            'name' => request('name'),
            'username' => request('username'),
            'password' => bcrypt(request('password')),
            'contact' => request('contact'),
            'municipality' => request('municipality'),
            'position' => request('position')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(auth()->user()->position == 'Admin') {
            return view('users.edit', compact('user'));
        }else {
            return redirect('/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'contact' => 'nullable',
            'municipality' => 'required', 
            'position' => 'required'
        ]);

        $user->update([
            'name' => request('name'),
            'contact' => request('contact'),
            'municipality' => request('municipality'),
            'position' => request('position')
        ]);
    }
}
