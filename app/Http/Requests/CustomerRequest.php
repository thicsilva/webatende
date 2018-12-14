<?php

namespace App\Http\Requests;

use App\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        if ($this->method()=='PUT'){
            return [
                'name' => 'required',
                'doc_number' => 'required|formato_cpf_cnpj|cpf_cnpj|unique:customers,doc_number,' . $this->segment(2),
                'city' => 'required',
                'phone' => 'required|regex:/\(\d{2,}\)\d{4,}\-\d{4}/',
                'email' => 'required|email',
            ];
        }
        return [
            'name' => 'required',
            'doc_number' => 'required|formato_cpf_cnpj|cpf_cnpj|unique:customers,doc_number',
            'city' => 'required',
            'phone' => 'required|regex:/\(\d{2,}\)\d{4,}\-\d{4}/',
            'email' => 'required|email',
        ];

    }

    public function commit()
    {
        Customer::create($this->all());
    }

    public function update(Customer $customer)
    {
        $customer->fill([
            'name' => $this->get('name'),
            'fantasy_name' => $this->get('fantasy_name'),
            'doc_number' => $this->get('doc_number'),
            'city' => $this->get('city'),
            'phone' => $this->get('phone'),
            'email' => $this->get('email'),
            'has_contract' => $this->has('has_contract'),
            'has_restriction' => $this->has('has_restriction'),
            'restriction_annotation' => $this->get('restriction_annotation')
        ]);
        $customer->save();
    }

}
