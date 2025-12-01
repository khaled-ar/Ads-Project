<?php

namespace App\Http\Requests\Auth;

use App\Models\{
    Driver,
    User
};
use App\Notifications\{
    DatabaseNotification,
    EmailVerificationCode
};
use App\Services\Whatsapp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'username' => ['required', 'string', 'between:3,15', 'unique:users,username'],
            'email' => ['nullable', 'required_without:number', 'email', 'unique:users,email'],
            'place_of_residence' => ['required', 'string', 'exists:regions,name'],
            'work_status' => ['required', 'string', 'in:سائق حر,يعمل ضمن برنامج توصيل,لا يعمل ضمن أي برنامج'],
            'program_name' => ['required_if:work_status,يعمل ضمن برنامج توصيل', 'string', 'exists:delivery_programs,name'],
            'birth_date' => ['required', 'date'],
            'km_per_day' => ['required', 'integer', 'min:1'],
            'km_per_month' => ['required', 'integer', 'min:1'],
            'number' => ['nullable', 'required_without:email', 'string'],
            'nationality' => ['required', 'string', 'in:سوري,مصري'],
            'gender' => ['required', 'string', 'in:انثى,ذكر'],
            'car_model' => ['required', 'string', 'exists:cars,name'],
            'car_color' => ['required', 'string', 'between:3,15'],
            'car_number' => ['required', 'string', 'between:3,50'],
            'car_year' => ['required', 'integer'],
            'personal_id_image' => ['required', 'image', 'mimes:png,jpg', 'max:4096'],
            'driving_license_image' => ['required', 'image', 'mimes:png,jpg', 'max:4096'],
            'car_mechanics_image' => ['required', 'image', 'mimes:png,jpg', 'max:4096'],
            'password' => ['required', 'string',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ]
        ];
    }

    // Store User Data
    public function store() {
        return DB::transaction(function() {
            $user = User::create([
                'username' => $this->username,
                'password' => $this->password,
                'email'    => $this->email,
                'ip_address' => $this->ip(),
                'notes' => ''
            ]);
            $data = $this->except(['username', 'password', 'program_name', 'email', 'ip_address']);
            $data['user_id'] = $user->id;
            Driver::create($data);
            if($this->email) {
                $user->notify(new EmailVerificationCode());
            } else {
                Whatsapp::send_code($this->number);
            }
            $admin = User::whereRole('ادمن')->first();
            $subject = "لقد تم انشاء حساب سائق جديد، يرجى الاطلاع";
            $body = [
                'driver_name' => $user->username,
                'driver_number' => $user->driver->number,
            ];

            $admin->notify(new DatabaseNotification($body, $subject, 'new_driver'));

            return 'Please confirm your account now, your membership request is under review by the system administrator.';
        });
    }
}
