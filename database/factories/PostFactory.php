<?php

namespace Database\Factories;

use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id, 
            'content' => $this->faker->text,
        ];
    }
}
