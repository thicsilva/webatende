<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(CustomerRequest $request)
    {
        $request->commit();
        session()->flash('alert', ['type' => 'success', 'message' => 'Cliente cadastrado com sucesso!']);
        return redirect()->route('customer.index');
    }

    public function edit(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        return view('customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $request->update($customer);
        session()->flash('alert', ['type' => 'success', 'message' => 'Cliente atualizado com sucesso!']);
        return redirect()->route('customer.index');
    }

    public function delete(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        $customer->delete();
        return redirect()->route('customer.index')->with(['success', 'Cliente excluído com sucesso']);
    }

    public function search($query)
    {
        $customer = Customer::where('name', 'like', '%' . $query .'%')
            ->orWhere('fantasy_name', 'like', '%' . $query .'%')
            ->orWhere('doc_number', 'like', '%' . $query .'%')
            ->get();
        return json_encode($customer);
    }

}
