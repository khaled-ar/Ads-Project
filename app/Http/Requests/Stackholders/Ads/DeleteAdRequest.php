<?php

namespace App\Http\Requests\Stackholders\Ads;

use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Notifications\FcmNotification;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class DeleteAdRequest extends FormRequest
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

    public function delete($ad) {
        DB::transaction(function() use ($ad){
            $ad->delete();
            $notifiables = User::whereRole('ادمن')->get();
            $body = "لقد قام {$ad->user->username} بمسح الاعلان رقم {$ad->id}";
            $subject = 'حذف اعلان';
            foreach($notifiables as $notifiable) {
                $notifiable->notify(new FcmNotification($subject, $body));
                $notifiable->notify(new DatabaseNotification($body, $subject, 'ad_deletion'));
            }
        });
    }
}
