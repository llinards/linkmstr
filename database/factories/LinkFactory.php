<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'original_url' => $this->faker->url(),
            'short_code' => $this->faker->unique()->regexify('[A-Za-z0-9]{6}'),
            'title' => $this->faker->optional(0.8)->sentence(3),
            'description' => $this->faker->optional(0.6)->paragraph(1),
            'is_active' => true,
            'expires_at' => $this->faker->optional(0.3)->dateTimeBetween('now', '+1 year'),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
