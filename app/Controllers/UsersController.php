<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(){
        $users = $this->user->paginate(15);

        foreach($users as $user){
            $user->users_perfil;
        }

        return view('auth.users')->with(compact('users'));
    }

    public function create(){
        return view('auth.users_form');
    }

    public function edit(User $users){
        return "edit";
    }

    public function store(Request $request){
        $data = $request->all();
        return $data;
    }

    public function update(User $users, Request $request){
        return "update";
    }

    public function destroy(User $users){
        return "destroy";
    }
}