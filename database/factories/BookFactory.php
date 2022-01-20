<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factories\ $factory */

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name,
            'count' => $this->faker->biasedNumberBetween(0, 20),
            'amount' => $this->faker->biasedNumberBetween(50, 200),
            'seller_id' => function () {
//                return Book::all()->random()->seller_id;
                return Book::orderBy(DB::raw('random()'))->first()->seller_id;
            }
        ];
    }

}
