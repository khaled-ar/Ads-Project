<?php

namespace App\Http\Requests\Appointements;

use Illuminate\Foundation\Http\FormRequest;

class GetSingleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = request()->user();
        if($user->role != 'ادمن') {
            return in_array(request()->appointment->id, $user->driver->appointments()->pluck('id')->toArray());
        }
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
            //
        ];
    }
}
