<?php

namespace App\Http\Controllers;

use App\Models\Profits;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ProfitsController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'destroy']);
        $this->middleware('driver')->only('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profits = Profits::with('driver')->get();
        $final = [];
        foreach($profits as $profit) {
            $final[] = [
                'id' => $profit->id,
                'account_id' => $profit->account_id,
                'profits' => round($profit->profits, 2),
                'driver_name' => $profit->driver->user->username,
                'driver_number' => $profit->driver->number,
                'driver_place' => $profit->driver->place_of_residence,
                'driver_nationality' => $profit->driver->nationality,
            ];
        }
        return $this->generalResponse($final);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sham_cash_id = $request->validate([
            'account_id' => 'required', 'string', 'max:100', 'unique:profits,account_id'
        ])['account_id'];

        $profits = $request->user()->driver->ads()->whereStatus('done')->sum('profits');
        $in_progress = $request->user()->driver->ads()->whereStatus('in_progress')->sum('profits');

        if($profits == 0 && $in_progress == 0) {
            return $this->generalResponse(null, 'You do not have any profits yet, please work harder!', 400);
        }

        if($profits == 0 && $in_progress > 0) {
            return $this->generalResponse(null, 'Profits cannot be withdrawn until the advertising campaign period ends.', 400);
        }

        Profits::create([
            'driver_id' => $request->user()->driver->id,
            'account_id' => $sham_cash_id,
            'profits' => $profits
        ]);
        $request->user()->driver->trips()->delete();
        $request->user()->driver->ads()->whereStatus('done')->update(['profits' => 0]);
        $notifiables = User::whereRole('ادمن')->get();
        $body = "لقد قام {$request->user()->username} بتقديم طلب سحب ارباح";
        $subject = 'طلب سحب ارباح جديد';
        foreach($notifiables as $notifiable) {
            $notifiable->notify(new FcmNotification($subject, $body));
        }
        Notification::send($notifiables, new DatabaseNotification($body, $subject, 'new_profits_request'));
        return $this->generalResponse(null, 'Your Request Sent To Admin Successfully, PLease Wait for 24 Hours Maximum.');
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
    public function destroy(Profits $profit)
    {
        $profit->delete();
        return $this->generalResponse(null, 'Deleted Successfully.');
    }
}
