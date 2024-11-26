<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CryptocurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fa_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'rank' => 'required',
        ];
    }
    public function massage(): array
    {
        return [
            'fa_name.required' => 'لطفا نام فارسی ارز را وارد کنید.',
            'name.required' => 'لطفا نام انگلیسی ارز را وارد کنید.',
            'symbol.required' => 'لطفا سمیبل ارز را وارد کنید.',
            'rank.required' => 'لطفا رنک ارز را وارد کنید.'
        ];
    }
}
