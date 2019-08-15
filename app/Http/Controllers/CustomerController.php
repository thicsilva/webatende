<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRequest;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $users = User::active()->orderBy('name')->get();
        view()->share('users', $users);
    }

    public function index(Request $request)
    {
        $name = $request->name;
        $fantasyName = $request->fantasy_name;
        $docNumber = preg_replace("/\D/",'',$request->doc_number);
        $city = $request->city;
        $customers = Customer::when($name, function ($q, $name) {
            return $q->where('name', 'like', '%' . $name . '%');
        })->when($fantasyName, function ($q, $fantasyName) {
            return $q->where('fantasy_name', 'like', '%' . $fantasyName . '%');
        })->when($docNumber, function ($q, $docNumber) {
            return $q->where('doc_number', 'like', '%' . $docNumber . '%');
        })->when($city, function ($q, $city) {
            return $q->where('city', 'like', '%' . $city . '%');
        })->paginate(10);
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
        return redirect()->back();
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
        return redirect()->back();
    }

    public function delete(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        if ($customer->calls->count()>0){
            session()->flash('alert', [
                'type' => 'error',
                'message' => "O cliente $customer->name não pode ser excluído pois possuí lançamentos associados a ele!"
            ]);
            return redirect()->back();
        }
        $customer->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Cliente excluído com sucesso!']);
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->get('term');        
        $customer = Customer::where('name', 'like', '%' . $query . '%')
            ->orWhere('fantasy_name', 'like', '%' . $query . '%')
            ->orWhere('doc_number', 'like', '%' . $query . '%')
            ->get();
        return json_encode($customer);
    }
}
