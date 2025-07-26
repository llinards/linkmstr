<?php

namespace Database\Factories;

use App\Models\Link;
use App\Models\LinkClick;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkClickFactory extends Factory
{
    protected $model = LinkClick::class;

    public function definition(): array
    {
        return [
            'link_id' => Link::factory(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'referer' => $this->faker->optional(0.7)->url(),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
