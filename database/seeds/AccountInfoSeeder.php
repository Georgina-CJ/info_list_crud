<?php

use Illuminate\Database\Seeder;

class AccountInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\AccountInfo::class, 15)->create();
        App\Models\AccountInfo::reguard();
    }
}
