<?php

namespace App\Http\Requests\Stackholders\Ads;

use Illuminate\Foundation\Http\FormRequest;

class ShowAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return in_array(request()->ad->id, request()->user()->ads()->pluck('id')->toArray());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
