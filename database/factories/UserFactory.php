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
            'uploads/images/avatars/202109/29/1_1632886686_J0lYwxT6SK.jpeg',
            'uploads/images/avatars/202109/29/1_1632887997_u3oe7JyguF.jpeg',
            'uploads/images/avatars/202109/29/1_1632893469_l4pQd4TCNm.jpeg',
            'uploads/images/avatars/202109/29/1_1632893526_7FOaX28ywJ.jpeg',
            'uploads/images/avatars/202109/29/1_1632893534_6MejtMEDi3.jpeg',
            'uploads/images/avatars/202109/29/1_1632893578_NUO3zgmwPS.jpeg',
            'uploads/images/avatars/202109/29/1_1632893629_MxeONHW1Cu.jpeg',
            'uploads/images/avatars/202109/29/1_1632893828_cD288GZQCC.jpeg',
            'uploads/images/avatars/202109/29/1_1632893867_6c6GnwPB1n.jpeg'
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
