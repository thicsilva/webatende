<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Situation;

class SituationsController extends Controller
{
    public function index()
    {
        $situations = Situation::all();
        return view('situation.index', compact('situations'));
    }

    public function store(Request $request)
    {
        $situation = Situation::create($request->all());
        session()->flash('alert', ['type' => 'success', 'message' => 'Situação criada com sucesso']);
        return redirect()->back();
    }

    public function update(Request $request, Situation $situation)
    {

        $situation = Situation::findOrFail($situation->id);
        $situation->fill($request->all());
        $situation->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Situação alterada com sucesso']);
        if ($request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function delete(Situation $situation)
    {
        $situation = Situation::findOrFail($situation->id);

        $situation->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }
}
