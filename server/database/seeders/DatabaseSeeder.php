<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Sparepart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@webtech.id',
            'role' => 'admin',
            'password' => 'password'
        ]); 
        
        User::create([
            'name' => 'staff',
            'email' => 'staff@webtech.id',
            'role' => 'staff',
            'password' => 'password'
        ]); 
        
        User::create([
            'name' => 'user',
            'email' => 'user@webtech.id',
            'role' => 'user',
            'password' => 'password'
        ]);

        User::factory(10)->create();
        
        Category::factory(10)->create();
        Sparepart::factory(30)->create();
        Transaction::factory(10)->create();
        TransactionDetail::factory(30)->create();
    }
}
