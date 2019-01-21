<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('type.index', compact('types'));
    }

    public function store(Request $request)
    {
        $type = Type::create($request->all());
        session()->flash('alert', ['type' => 'success', 'message' => 'Tipo criado com sucesso']);
        return redirect()->back();
    }

    public function update(Request $request, Type $type)
    {
        $type = Type::findOrFail($type->id);
        $type->fill($request->all());
        $type->save();
        session()->flash('alert', ['type' => 'success', 'message' => 'Tipo alterado com sucesso']);
        if ($request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function delete(Type $type)
    {
        $type = Type::findOrFail($type->id);

        $type->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }


}
