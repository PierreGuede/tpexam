<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Owe;
use App\Models\OweBy;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name'=>'Adam'
        ]);
        User::create([
            'name'=>'Bob'
        ]);
        User::create([
            'name'=>'Chuck'
        ]);
        User::create([
            'name'=>'Dan'
        ]);

        Owe::create([
            'user_id'=>1,
            'ower'=>'Bob',
            'amount'=>"12.0"
        ]);
        Owe::create([
            'user_id'=>1,
            'ower'=>'Chuck',
            'amount'=>"4.0"

        ]);
        Owe::create([
            'user_id'=>1,
            'ower'=>'Dan',
            'amount'=>"9.5"
        ]);

        OweBy::create([
            'user_id'=>1,
            'ower_by'=>'Bob',
            'amount'=>"6.5"

        ]);
        OweBy::create([
            'user_id'=>1,
            'ower_by'=>'Dan',
            'amount'=>"12.0"
        ]);
    }
}
