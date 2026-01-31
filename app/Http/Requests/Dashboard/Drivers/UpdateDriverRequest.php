<?php

namespace App\Http\Requests\Dashboard\Drivers;

use App\Models\User;
use App\Traits\Files;
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
            'work_status' => ['string', 'in:سائق حر,يعمل ضمن برنامج توصيل,لا يعمل ضمن أي برنامج'],
            'program_name' => ['required_if:work_status,يعمل ضمن برنامج توصيل', 'string', 'between:3,50'],
            'birth_date' => ['date'],
            'number' => ['string', 'between:3,15'],
            'nationality' => ['string', 'in:سوري,مصري'],
            'gender' => ['string', 'in:انثى,ذكر'],
            'car_model' => ['string', 'between:3,50'],
            'car_color' => ['string', 'between:3,15'],
            'car_number' => ['string', 'between:3,50'],
            'car_year' => ['integer', 'digits:4'],
            'personal_id_image' => ['image', 'mimes:png,jpg', 'max:4096'],
            'driving_license_image' => ['image', 'mimes:png,jpg', 'max:4096'],
            'car_mechanics_image' => ['image', 'mimes:png,jpg', 'max:4096'],
            'image' => ['image', 'mimes:png,jpg', 'max:4096'],
        ];
    }

    public function update($driver) {
        $user = $driver->user;
        if($this->username) {
            $user->update([
                'username' => $this->username,
            ]);
        }
        if($this->file('image')) {
            if($user->image) {
                Files::deleteFile(public_path("Images/{$user->id}/{$user->image}"));
            }
            $new_image = Files::moveFile($this->image, "Images/{$user->id}");
            $user->update(['image' => $new_image]);
        }

        if($this->file('personal_id_image')) {
            Files::deleteFile(public_path("Drivers_Images/{$user->driver->personal_id_image}"));
            $new_image = Files::moveFile($this->personal_id_image, "Drivers_Images");
            $user->driver()->update(['personal_id_image' => $new_image]);
        }

        if($this->file('driving_license_image')) {
            Files::deleteFile(public_path("Drivers_Images/{$user->driver->driving_license_image}"));
            $new_image = Files::moveFile($this->driving_license_image, "Drivers_Images");
            $user->driver()->update(['driving_license_image' => $new_image]);
        }

        if($this->file('car_mechanics_image')) {
            Files::deleteFile(public_path("Drivers_Images/{$user->driver->car_mechanics_image}"));
            $new_image = Files::moveFile($this->car_mechanics_image, "Drivers_Images");
            $user->driver()->update(['car_mechanics_image' => $new_image]);
        }

        if ($this->work_status == 'يعمل ضمن برنامج توصيل') {
            $this->merge(['work_status' => $this->work_status . ', ' . $this->program_name]);
        }

        $driver->update($this->except(['program_name', 'car_mechanics_image', 'driving_license_image', 'personal_id_image', 'image', 'username', '_method']));

    }
}
