<?php

namespace App\Http\Requests\Dashboard\Drivers;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateDriverRequest extends FormRequest
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
            'username' => ['string', 'between:3,15', 'unique:users,username,' . request()->driver->user_id . ',id'],
            'place_of_residence' => ['string', 'between:3,50'],
            'work_status' => ['string', 'in:سائق حر,يعمل ضمن برنامج توصيل,لا يعمل ضمن أي برنامج'],
            'program_name' => ['required_if:work_status,يعمل ضمن برنامج توصيل', 'string', 'between:3,50'],
            'age' => ['integer', 'between:18,45'],
            'number' => ['string', 'between:3,15'],
            'nationality' => ['string', 'in:سوري,مصري'],
            'gender' => ['string', 'in:انثى,ذكر'],
            'car_name' => ['string', 'between:3,50'],
            'car_color' => ['string', 'between:3,15'],
            'car_number' => ['string', 'between:3,50'],
            'car_year' => ['integer', 'digits:4'],
            'details_file' => ['file', 'mimes:pdf', 'max:4096'],
        ];
    }

    public function update($driver) {
        $user = $driver->user;
        $user->update([
            'username' => $this->username,
        ]);
        $driver->update($this->except(['details_file', 'username', '_method']));
    }
}
