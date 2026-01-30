<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['title' => ['required', 'string'], 'body' => ['required', 'string']]);
        if(request('username')) {
            $user = User::whereUsername(request('username'))->first();
            $user->notify(new FcmNotification($request->title, $request->body));
            $user->notify(new DatabaseNotification($request->body, $request->title, 'static_notification'));
            return $this->generalResponse(null);
        }
        User::whereRole('سائق')->get()->map(function($user) use($request) {
            $user->notify(new FcmNotification($request->title, $request->body));
            $user->notify(new DatabaseNotification($request->body, $request->title, 'static_notification'));
        });
        return $this->generalResponse(null);
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
    public function destroy(string $id)
    {
        //
    }
}
