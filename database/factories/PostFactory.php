<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */ 
    public function definition()
    {
        return [
            'user_id' => 3,
            'body' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(1920,1080)
        ];
    }
}
