<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        if (!auth()->user()->is_admin) {
            return redirect()->route('home');
        }
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->fill([
            'name' => $request->get('name'),
            'is_admin' => $request->has('is_admin'),
            'show_notification' => $request->has('show_notification'),
            'play_sound' => $request->has('play_sound'),
        ]);
        $user->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Usuário alterado com sucesso!']);
        return redirect()->route('user.index');
    }

    public function delete(User $user)
    {
        $user = User::findOrFail($user->id);
        if ($user->avatar!='avatar.png'){
            Storage::delete($user->avatar);
        }
        $user->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Usuário excluído']);
        return redirect()->route('user.index');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        $avatar = auth()->user()->avatar;
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($user->avatar!=='avatar.png'){
                Storage::delete('public/'. $user->avatar);
            }
            $avatar = $request->file('avatar')->store('public');
            $avatar = explode('/', $avatar);
            $avatar = $avatar[1];

            if (!$avatar) {
                session()->flash('alert', ['type' => 'error', 'message' => 'Não foi possível enviar a imagem']);
                return redirect()->back();
            }
        }

        $user->fill([
            'name' => $request->get('name'),
            'avatar' => $avatar,
            'show_notification' => $request->has('show_notification'),
            'play_sound' => $request->has('play_sound'),
        ])->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Perfil atualizado']);
        return redirect()->back();
    }

    public function password()
    {
        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        $user->fill([
            'password' => bcrypt($request->password),
        ])->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Senha alterada']);
        return redirect()->back();
    }
}
