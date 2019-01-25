<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Equipment;
use App\Type;

class EquipmentsController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        $types = Type::all();
        return view('equipment.index', compact('equipments', 'types'));
    }

    public function store(Request $request)
    {
        $equipment = Equipment::create($request->all());
        session()->flash('alert', ['type' => 'success', 'message' => 'Equipamento criado com sucesso']);
        return redirect()->back();
    }

    public function update(Request $request, Equipment $equipment)
    {

        $equipment = Equipment::findOrFail($equipment->id);
        $equipment->fill($request->all());
        $equipment->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Equipamento alterado com sucesso']);
        if ($request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function delete(Equipment $equipment)
    {
        $equipment = Equipment::findOrFail($equipment->id);

        $equipment->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }
}
