<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run()
    {
        $platforms = [
            ['name' => 'Twitter', 'peak_hour' => '18:00:00', 'type' => 'twitter'],
            ['name' => 'Instagram', 'peak_hour' => '20:00:00', 'type' => 'instagram'],
            ['name' => 'LinkedIn', 'peak_hour' => '09:00:00', 'type' => 'linkedin'],
        ];

        foreach ($platforms as $platform) {
            Platform::updateOrCreate(['name' => $platform['name']], $platform);
        }
    }
}
