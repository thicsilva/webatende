<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertCustomerRequest;
use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.index');
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(InsertCustomerRequest $request)
    {

        $customer = Customer::create($request->all());
        return redirect()->route('customer.index')->with(['success', 'Cliente cadastrado com sucesso!']);
    }

    public function edit(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->fill($request->all());
        return redirect()->route('customer.index')->with(['success','Cliente atualizado com sucesso!']);
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
