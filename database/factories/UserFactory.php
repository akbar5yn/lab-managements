<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'nim' => $this->faker->unique()->randomNumber(8), // Menghasilkan NIM acak yang unik
            'username' => $this->faker->unique()->userName(), // Menghasilkan username yang unik
            'password' => Hash::make('password'), // Menghasilkan password yang telah di-hash
            'role' => $this->faker->randomElement(['laboran', 'mahasiswa']), // Menghasilkan peran acak
        ];
    }

    /**
     * State untuk menghasilkan mahasiswa.
     *
     * @return static
     */
    public function mahasiswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'mahasiswa', // Atur role menjadi mahasiswa
        ]);
    }
}
