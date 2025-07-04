<?php

namespace App\Http\Requests\Dashboard\Cars;

use App\Models\Car;
use App\Models\CarsYears;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreCarRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'years' => ['required', 'string'],
        ];
    }

    public function store() {
        return DB::transaction(function () {
            $car = Car::create(['name' => $this->name]);
            $years = explode(',', $this->years);
            foreach($years as $year) {
                CarsYears::create([
                    'car_id' => $car->id,
                    'year' => $year
                ]);
            }
            return 'Car Created Suuccessfully.';
        });

    }
}
