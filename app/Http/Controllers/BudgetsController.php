<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Customer;
use App\Budget;
use App\Call;

class BudgetsController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->term;
        $budgets = Budget::when($term, function($q, $term){
            return $q->where('customer_name', 'like', '%'. $term .'%')
            ->orWhere('customer_contact', 'like', '%'. $term .'%')
            ->orWhere('customer_document', 'like', '%'. $term .'%');
        })->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('budget.index', compact('budgets'));
    }

    public function create(Call $call)
    {
        $call = Call::findOrFail($call->id);

        return view('budget.create', compact('call'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_contact' => 'required',
            'filename' => 'mimes:pdf'
        ]);

        $filename ='';
        if ($request->hasFile('filename') && $request->file('filename')->isValid()){
            $extension = $request->file('filename')->extension();
            $filename = md5($request->file('filename')->getClientOriginalName() . microtime()) . '.' . $extension;
            $request->filename->storeAs('public/budgets', $filename);
        }

        $budget = Budget::create([
            'customer_name' => $request->customer_name,
            'customer_contact' => $request->customer_contact,
            'customer_document' => $request->customer_document,
            'description' => $request->description,
            'call_id' => $request->call_id,
            'user_id' => auth()->user()->id,
            'filename' => $filename,
        ]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Orçamento cadastrado']);
        return redirect()->route('call.show', $budget->call);
    }

    public function show(Budget $budget)
    {
        $budget = Budget::findOrFail($budget->id);
        return view('budget.show', compact('budget'));
    }

    public function edit(Budget $budget)
    {
        $budget = Budget::findOrFail($budget->id);
        return view('budget.edit', compact('budget'));
    }

    public function update(Request $request, Budget $budget)
    {
        $budget = Budget::findOrFail($budget->id);

        $request->validate([
            'customer_name' => 'required',
            'customer_contact' => 'required',
            'filename' => 'mimes:pdf'
        ]);

        $filename = $budget->filename;

        if ($request->hasFile('filename') && $request->file('filename')->isValid()){
            Storage::delete('public/budgets/' . $filename);
            $extension = $request->file('filename')->extension();
            $filename = md5($request->file('filename')->getClientOriginalName() . microtime()) . '.' . $extension;
            $request->filename->storeAs('public/budgets', $filename);
        }
        $budget->update([
            'customer_name' => $request->customer_name,
            'customer_contact' => $request->customer_contact,
            'customer_document' => $request->customer_document,
            'description' => $request->description,
            'filename' => $filename
        ]);

        $budget->save();

        session()->flash('alert', ['type' => 'success', 'message' => 'Orçamento alterado']);
        return redirect()->route('call.show', $budget->call);
    }

    public function delete(Budget $budget)
    {
        $budget = Budget::findOrFail($budget->id);
        Storage::delete('public/budgets/' . $budget->filename);
        $budget->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Orçamento excluído']);
        return redirect()->back();

    }


}
