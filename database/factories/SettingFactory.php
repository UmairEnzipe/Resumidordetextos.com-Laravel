<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = array(
            [
                'key' => 'thumbnail_width',
                'value' => '300',
            ],
            [
                'key' => 'thumbnail_height',
                'value' => '100',
            ],
            [
                'key' => 'small_image_width',
                'value' => '150',
            ],
            [
                'key' => 'small_image_height',
                'value' => '150',

            ],
        );
        return $data;
    }
}
