<?php

namespace Database\Factories;

use App\Helper;
use App\Models\Code;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Code::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 2,
            'account_code' => Helper::randomString(11, User::latest()->first()->user_id ?? ''),
        ];
    }
}
