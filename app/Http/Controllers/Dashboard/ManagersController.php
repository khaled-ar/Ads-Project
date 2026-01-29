<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ManagersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        return $this->generalResponse(User::whereRole('ادمن')->where('id', '<>', $user->id)->latest()->get(
            ['id', 'username']
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'unique:users,username'],
            'password' => ['required', 'string',
                Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                ]
        ]);
        $data['role'] = 'ادمن';
        $data['ip_address'] = $request->ip();
        $data['notes'] = '';
        $data['account_status'] = 'active';
        $data['email'] = "{$data['username']}@gmail.com";
        $data['ememail_verified_atail'] = now();
        User::create($data);
        return $this->generalResponse(null, null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $manager)
    {
        $manager->delete();
        return $this->generalResponse(null, null, 200);
    }
}
