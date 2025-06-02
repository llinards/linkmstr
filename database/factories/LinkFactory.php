<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Link::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'original_url' => $this->faker->url(),
            'short_code' => $this->faker->unique()->regexify('[a-zA-Z0-9]{6}'),
            'title' => $this->faker->optional()->sentence(3),
            'description' => $this->faker->optional()->paragraph(1),
            'clicks' => $this->faker->numberBetween(0, 1000),
            'is_active' => $this->faker->boolean(80),
            'expires_at' => $this->faker->optional(30)->dateTimeBetween('now', '+1 year'),
        ];
    }

    /**
     * Indicate that the link is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'expires_at' => null,
        ]);
    }

    /**
     * Indicate that the link is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the link is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'expires_at' => now()->subDay(),
        ]);
    }

    /**
     * Indicate that the link expires in the future.
     */
    public function expiresInFuture(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'expires_at' => now()->addDays(30),
        ]);
    }
}
