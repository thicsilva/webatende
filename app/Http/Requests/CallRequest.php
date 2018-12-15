<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Call;
use App\Events\CallCreated;

class CallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|numeric',
            'contact' => 'required',
            'subject' => 'required',
            'to_user_id' => 'required|numeric'
        ];
    }

    public function commit()
    {
        $data = $this->all();
        $data['from_user_id'] = auth()->user()->id;
        $call = Call::create($data);
        event(new CallCreated($call));
    }
}
