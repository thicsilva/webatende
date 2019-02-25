<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;

class MovementsController extends Controller
{
    public function index()
    {
        $movements = Movement::all();
        return view('movement.index', compact('movements'));
    }

    public function store(Request $request)
    {
        $movement = Movement::create($request->all());
        session()->flash('alert', ['type' => 'success', 'message' => 'Situação criada com sucesso']);
        return redirect()->back();
    }

    public function update(Request $request, Movement $movement)
    {

        $movement = Movement::findOrFail($movement->id);
        $movement->fill($request->all());
        $movement->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Situação alterada com sucesso']);
        if ($request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function delete(Movement $movement)
    {
        $movement = Movement::findOrFail($movement->id);

        $movement->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }
}
