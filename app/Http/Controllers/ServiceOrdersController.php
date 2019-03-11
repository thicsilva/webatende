<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceOrder;
use App\Equipment;
use App\Movement;
use App\Situation;
use App\Accessory;

class ServiceOrdersController extends Controller
{
    public function index(Request $request)
    {
        $os_number = $request->os_number;
        $customer = $request->customer;
        $entrance_date = $request->entrance_date;
        $situation = $request->situation;
        $serial = $request->serial;
        $status = $request->has('status');

        $situations = Situation::all();
        $orders = ServiceOrder::select('service_orders.*')
            ->join('customers', 'customers.id', '=', 'service_orders.customer_id')
            ->when($os_number, function($q, $os_number){
                return $q->where('service_orders.os_number', 'like', "%$os_number%");
            })
            ->when($customer, function($q, $customer){
                return $q->where('customers.name', 'like', "%$customer%");
            })
            ->when($entrance_date, function($q, $entrance_date){
                return $q->where('service_orders.entrance_date', $entrance_date);
            })
            ->when($situation, function($q, $situation){
                return $q->where('service_orders.situation_id', $situation);
            })
            ->when($serial, function($q, $serial){
                return $q->where('service_orders.serial', 'like', "%$serial%");
            })
            ->when(!$status, function($q, $status){
                return $q->where('service_orders.status', true);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('service-order.index', compact('orders', 'situations'));
    }

    public function create()
    {
        $equipments = Equipment::all();
        $movements = Movement::all();
        $situations = Situation::all();
        $accessories = Accessory::all();
        return view('service-order.create', compact('equipments', 'movements', 'situations', 'accessories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'equipment_id' => 'required',
            'entrance_date' => 'required',
            'entrance_movement_id' => 'required',
            'situation_id' => 'required'
        ]);

        $so = ServiceOrder::create([
            'os_number' => $request->os_number,
            'customer_id' => $request->customer_id,
            'contact' => $request->contact,
            'equipment_id' => $request->equipment_id,
            'serial' => $request->serial,
            'entrance_id' => $request->entrance_id,
            'factory' => $request->factory,
            'documents' => $request->documents,
            'fault' => $request->fault,
            'entrance_date' => $request->entrance_date,
            'entrance_movement_id' => $request->entrance_movement_id,
            'situation_id' => $request->situation_id,
            'status' => 1,
            'user_id' => auth()->user()->id
        ]);

        $accessories = $request->accessories;

        $ids = array();
        foreach ($accessories as $accessory){
            $exist = Accessory::find($accessory);
            if(!$exist){
                $new = Accessory::firstOrCreate(['description' => ucwords(mb_strtolower($accessory))]);
                if ($new){
                    $ids[] = $new->id;
                }
            } else {
                $ids[] = $accessory;
            }
        }

        $so->accessories()->sync($ids);

        session()->flash('alert', ['type'=>'success', 'message' => 'Entrada registrada com sucesso']);
        return redirect()->route('so.index');
    }

    public function edit(ServiceOrder $so)
    {
        $order = ServiceOrder::findOrFail($so->id);
        $equipments = Equipment::all();
        $movements = Movement::all();
        $situations = Situation::all();
        $accessories = Accessory::all();
        return view('service-order.edit', compact('order', 'equipments', 'movements', 'situations', 'accessories'));
    }

    public function show(ServiceOrder $so)
    {
        $order = ServiceOrder::findOrFail($so->id);
        return view('service-order.show', compact('order'));
    }

    public function update(Request $request, ServiceOrder $so)
    {
        $so = ServiceOrder::findOrFail($so->id);
        $request->validate([
            'customer_id' => 'required',
            'equipment_id' => 'required',
            'entrance_date' => 'required',
            'entrance_movement_id' => 'required',
            'situation_id' => 'required'
        ]);

        $so->fill([
            'os_number' => $request->os_number,
            'customer_id' => $request->customer_id,
            'contact' => $request->contact,
            'equipment_id' => $request->equipment_id,
            'serial' => $request->serial,
            'entrance_id' => $request->entrance_id,
            'factory' => $request->factory,
            'documents' => $request->documents,
            'fault' => $request->fault,
            'entrance_date' => $request->entrance_date,
            'exit_date' => $request->exit_date,
            'entrance_movement_id' => $request->entrance_movement_id,
            'exit_movement_id' => $request->exit_movement_id,
            'situation_id' => $request->situation_id,
            'user_id' => auth()->user()->id,
			'status' => !$request->has('status')
        ]);

        $so->save();

        $accessories = $request->accessories;

        $ids = array();
        foreach ($accessories as $accessory){
            $exist = Accessory::find($accessory);
            if(!$exist){
                $new = Accessory::firstOrCreate(['description' => ucwords(mb_strtolower($accessory))]);
                if ($new){
                    $ids[] = $new->id;
                }
            } else {
                $ids[] = $accessory;
            }
        }

        $so->accessories()->sync($ids);

        session()->flash('alert', ['type'=>'success', 'message' => 'Entrada alterada com sucesso']);
        return redirect()->route('so.index');
    }

    public function delete(ServiceOrder $so)
    {
        $so = ServiceOrder::findOrFail($so->id);
        $so->accessories()->detach();
        $so->delete();

        session()->flash('alert', ['type' => 'success', 'message' => 'Excluído com sucesso']);
        return redirect()->back();
    }

    public function status(ServiceOrder $so)
    {
        $so = ServiceOrder::findOrFail($so->id);
        $so->status = !$so->status;
        $so->save();
        return redirect()->back();
    }
}
