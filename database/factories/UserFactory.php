<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $avatars = [
            '/uploads/images/avatars/202110/08/1_1633662910_FfhylzCCKh.jpeg',
            '/uploads/images/avatars/202110/08/1_1633663018_kNWnmZHqDu.jpeg',
            '/uploads/images/avatars/202110/08/1_1633663265_QME4Z7sWwr.jpg',
            '/uploads/images/avatars/202110/08/1_1633663333_0pML8lMf9s.jpg',
            '/uploads/images/avatars/202110/08/1_1633663363_wMQcA28omC.jpg',
        ];

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'introduction' => $this->faker->sentence(),
            'avatar' => $this->faker->randomElement($avatars),
            'created_at' => getRandomTime(-14,-2)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
