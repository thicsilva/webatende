<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accessory;

class AccessoriesController extends Controller
{
    public function index()
    {
        $accessories = Accessory::all();
        return view('accessory.index', compact('accessories'));
    }

    public function store(Request $request)
    {
        $accessory = Accessory::create($request->all());
        session()->flash('alert', ['accessory' => 'success', 'message' => 'Acessório criado com sucesso']);
        return redirect()->back();
    }

    public function update(Request $request, Accessory $accessory)
    {
        $accessory = Accessory::findOrFail($accessory->id);
        $accessory->fill($request->all());
        $accessory->save();
        session()->flash('alert', ['accessory' => 'success', 'message' => 'Acessório alterado com sucesso']);
        if ($request->ajax()){
            return response()->json(['success' => true]);
        }
        return redirect()->back();
    }

    public function delete(Accessory $accessory)
    {
        $accessory = Accessory::findOrFail($accessory->id);

        $accessory->delete();
        session()->flash('alert', ['accessory' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }
}
