<?php

namespace App\Http\Requests\Dashboard\Cars;

use App\Models\CarsYears;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateCarRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:100'],
            'years' => ['nullable', 'string'],
        ];
    }

    public function update($car)
    {
        return DB::transaction(function () use ($car) {
            $car->update(['name' => $this->name]);
            if ($this->years) {
                $car->years()->delete();
                $years = explode(',', $this->years);
                foreach ($years as $year) {
                    CarsYears::create([
                        'car_id' => $car->id,
                        'year' => $year
                    ]);
                }
            }
            return 'Car Updated Suuccessfully.';
        });
    }
}
