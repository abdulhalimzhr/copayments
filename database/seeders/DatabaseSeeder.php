<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\User::factory()->create([
      'name' => 'test user',
      'email' => 'test@test.com',
      'password' => bcrypt('password'),
      'created_at' => now(),
      'updated_at' => now()
    ]);
  }
}
