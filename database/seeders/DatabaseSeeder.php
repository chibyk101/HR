<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Subsidiary;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    for ($i=0; $i <= 5; $i++) { 
      \App\Models\User::factory(10)
        ->for(Designation::factory()->create())
        ->for(Branch::factory()
          ->for(Department::factory()
            ->for(Subsidiary::factory()->create())->create()))
        ->create();
    }
    foreach(User::all() as $user){
      $user->departments()->attach(rand(1,6));
    }
    $this->call(UserDatabaseSeeder::class);
    // $this->call(SubsidiarySeeder::class);
  }
}
