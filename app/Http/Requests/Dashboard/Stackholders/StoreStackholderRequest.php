<?php

namespace App\Http\Requests\Dashboard\Stackholders;

use App\Models\{
    Stackholders,
    User
};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class StoreStackholderRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'string', 'unique:users,username'],
            'image' => ['nullable', 'image', 'mimes:png,jpg', 'max:4096'],
            'location' => ['required', 'string'],
            'number' => ['required', 'string'],
            'commercial_number' => ['required', 'string'],
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

    public function store() {
        return DB::transaction(function() {
            $user = User::create([
                'username' => $this->username,
                'password' => $this->password,
                'email'    => $this->email,
                'ip_address' => $this->ip(),
                'role' => 'معلن',
                'account_status' => 'active',
                'notes' => ''
            ]);
            $data = $this->except(['username', 'password', 'password', 'email', 'ip_address', 'role']);
            $data['user_id'] = $user->id;
            Stackholders::create($data);
            return 'Stackholder Account Created Successfully.';
        });
    }
}
