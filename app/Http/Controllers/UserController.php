<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function index()
    {
        if (!auth()->user()->is_admin){
            return redirect()->route('home');
        }
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function delete(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Usuário excluído!']);
        return redirect()->route('user.index');
    }

    public function profile(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('user.profile', compact('user'));
    }
}
