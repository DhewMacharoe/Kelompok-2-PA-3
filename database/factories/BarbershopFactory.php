<?php

namespace Database\Factories;

use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barbershop>
 */
class BarbershopFactory extends Factory
{
    protected $model = Barbershop::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company() . ' Barbershop';
        return [
            'nama' => $name,
            'slug' => Str::slug($name),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'deskripsi' => $this->faker->sentence(),
            'logo' => null,
        ];
    }
}
