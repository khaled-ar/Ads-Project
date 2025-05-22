<?php

namespace App\Http\Requests\Drivers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Traits\Files;
use Illuminate\Support\Facades\DB;

class UpdateProfileRequest extends FormRequest
{
    use Files;
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
        $user = request()->user();
        return [
            'username' => ['string', 'between:3,15', 'unique:users,username,' . $user->id . ',id'],
            'email' => ['email', 'unique:users,email,' . $user->id . ',id'],
            'age' => ['integer', 'between:18,45'],
            'number' => ['string', 'between:3,15', 'unique:drivers,number,' . $user->driver->id . ',id'],
            'car_number' => ['string', 'between:3,50', 'unique:drivers,car_number,' . $user->driver->id . ',id'],
            'car_year' => ['integer', 'digits:4'],
            'car_name' => ['string', 'between:3,50'],
            'image' => ['image', 'mimes:png,jpg', 'max:4096'],
            'password' => ['string',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ],
        ];
    }

    public function update_profile() {
        return DB::transaction(function() {
            $user = request()->user();
            $user->update([
                'username' => $this->username ? $this->username :$user->username,
                'email' => $this->email ? $this->email :$user->email,
                'password' => $this->password ? $this->password :$user->password,
            ]);
            $user->driver()->update($this->except(['image', 'username', 'email', 'password', '_method']));
            if($this->hasFile('image')) {
                if(! is_null($user->image)) {
                    Files::deleteFile(public_path('Images') . "$user->id/$user->image");
                }
                $image_name = Files::moveFile(request()->file('image'), "Images/{$user->id}");
                $user->update([
                    'image' => $image_name,
                ]);
            }
            return 'Profile Updated Successfully.';
        });
    }
}

