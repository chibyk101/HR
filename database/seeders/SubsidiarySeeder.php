<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\OfficeType;
use App\Models\Subsidiary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubsidiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $subsidiaries = [
        [
          'name' => 'Great possibilizers limited',
          'departments' => [
            [
              'name' => 'Nestle',
              'locations' => [
                'eket',
                'uyo'
  
              ]
            ],
            [
              'name' => 'P&G',
              'locations' => [
                'Calabar',
                'Uyo'
              ]
            ]
  
          ]
        ],
        [
          'name' => 'Grab & Munch Limited',
          'departments' => [
            [
              'name' => 'Tantalizers',
              'locations' => [
                'Abak Rd',
                'Nwaniba'
              ],
            ],
            [
              'name' => 'Suntory',
              'locations' => []
            ],
            [
              'name' => 'Grab & Munch Eatry',
              'locations' => [
                'Tropicana'
              ]
  
            ]
          ]
        ],
        [
          'name' => 'Everyday Fish Limited',
  
          'departments' => [
            [
              'name' => 'Cold Room',
              'locations' => []
            ],
            [
              'name' => '2Sure',
              'locations' => []
            ],
            [
              'name' => 'Nukipro',
              'locations' => []
            ],
          ]
        ],
        [
          'name' => 'Everyday Mart',
          'departments' => []
        ]
      ];

      foreach ($subsidiaries as $subsidiary) {
        $sub =  new Subsidiary([
          'name' => $subsidiary['name']
        ]);
        $sub->save();
        if (count($subsidiary['departments'])) {
          foreach ($subsidiary['departments'] as $dept) {
            $department = new Department([
              'name' => $dept['name']
            ]);
            $sub->departments()->save($department);
  
            if (count($dept['locations'])) {
              foreach ($dept['locations'] as $location) {
                $branch = new Branch([
                  'name' => $location
                ]);
                $department->branches()->save($branch);
              }
            }
          }
        }
      }

      $officeTypes = [
        ['name' => 'Front office'],
        ['name' => 'back office'],
      ];
      OfficeType::insert($officeTypes);
    }
}
