<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApiCredential;

class ApiCredentialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiCredential::create([
            'api_name' => 'Hanron API 1',
            'api_url' => 'https://www.hanronjewellery.com/site/api.php?m=products-xml-1',
            'username' => 'pressurejewellers@gmail.com',
            'password' => 'Fiverr.123',
            'access_token' => null,
        ]);

        ApiCredential::create([
            'api_name' => 'Hanron API 2',
            'api_url' => 'https://www.hanronjewellery.com/site/api3.php?m=products-xml-1',
            'username' => 'pressurejewellers@gmail.com',
            'password' => 'Fiverr.123',
            'access_token' => null,
        ]);

        ApiCredential::create([
            'api_name' => 'Hanron API 3',
            'api_url' => 'https://www.hanronjewellery.com/site/api4.php?m=products-xml-1',
            'username' => 'pressurejewellers@gmail.com',
            'password' => 'Fiverr.123',
            'access_token' => null,
        ]);
    }
}
