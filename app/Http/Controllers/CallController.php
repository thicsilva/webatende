<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Call;
use App\User;
use App\Events\CallCreated;
use App\Events\CallForYou;
use App\Http\Requests\CallRequest;

class CallController extends Controller
{
    public function __construct()
    {
        $users = User::all();
        view()->share('users', $users);
    }

    public function index(Request $request)
    {
        $customer = $request->get('customer');
        $toUser = $request->get('to_user');
        $initialDate = $request->get('initial_date');
        $finalDate = $request->get('final_date');

        $calls = Call::select('calls.*')
            ->join('customers', 'customers.id', '=', 'calls.customer_id')
            ->join('users', 'users.id', '=', 'calls.to_user_id')
            ->when($customer, function($q, $customer){
                return $q->where('customers.name', 'like', "%$customer%");
            })
            ->when($toUser, function($q, $toUser){
                return $q->where('users.name', 'like', "%$toUser%");
            })
            ->when($initialDate, function($q, $initialDate){
                return $q->whereRaw("date(calls.created_at)>='$initialDate'");
            })
            ->when($finalDate, function($q, $finalDate){
                return $q->whereRaw("date(calls.created_at)<='$finalDate'");
            })
            ->orderBy('calls.created_at', 'desc')
            ->paginate(10);
        return view('call.index', compact('calls'));
    }

    public function forYou()
    {
        $calls = Call::with('customer')
            ->where('to_user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('call.index', compact('calls'));
    }

    public function fetchAll()
    {
        $calls = Call::with('customer')
        ->with('toUser')
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->json($calls, 200);
    }

    public function create()
    {
        return view('call.create');
    }

    public function store(CallRequest $request)
    {
        $request->commit();
        session()->flash('alert', ['type' => 'success', 'message' => 'Chamada cadastrada com sucesso!']);
        return redirect()->back();
    }

    public function delete(Call $call)
    {
        $call = Call::findOrFail($call->id);
        $call->delete();
        return redirect()->back();
    }

    public function close(Request $request, Call $call)
    {
        $call = Call::findOrFail($call->id);
        $call->status=true;
        $call->save();
        if ($request->ajax()){
            return response(200);
        }
        session()->flash('alert', ['type' => 'success', 'message' => 'Chamada encerrada!']);
        return redirect()->back();
    }

    public function show(Call $call)
    {
        $call = Call::findOrFail($call->id);
        return view('call.show', compact('call'));
    }
}
