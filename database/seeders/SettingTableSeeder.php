<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            [
                'key' => 'large_image_width',
                'value' => '900',
                'section' => 'media',
                'type' => "text",
                'autoload' => 0,
            ],
            [
                'key' => 'thumbnail_width',
                'value' => '300',
                'section' => 'media',
                'type' => "text",
                'autoload' => 0,
            ],
            [
                'key' => 'small_image_width',
                'value' => '150',
                'section' => 'media',
                'type' => "text",
                'autoload' => 0,
            ],
            [
                'key' => 'small_image_height',
                'value' => '150',
                'section' => 'media',
                'type' => "text",
                'autoload' => 0,
            ],
            [
                'key' => 'privacy-policy',
                'value' => " ",
                'section' => 'content',
                'type' => "richText",
                'autoload' => 1,
            ],
            [
                'key' => 'terms-and-condition',
                'value' => " ",
                'section' => 'content',
                'type' => "richText",
                'autoload' => 1,
            ],
            [
                'key' => 'google_analytics',
                'value' => " ",
                'section' => 'head',
                'type' => "textarea",
                'autoload' => 1,
            ],
        ];
        foreach ($setting as $key => $value) {
            Setting::firstOrCreate(
                ['key' => $value['key']],
                [
                    'value' => $value['value'],
                    'section' => $value['section'],
                    'type' => $value['type'],
                    'autoload' => $value['autoload'],
                ]
            );
        }
    }
}
