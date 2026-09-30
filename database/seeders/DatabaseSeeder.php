<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $admin = User::where('email', 'admin@gmail.com')->firstOrFail();
        $mechanics = User::where('role', 'mechanic')->get();
        foreach ($mechanics as $mechanic) {
            Staff::firstOrCreate(
                ['user_id' => $mechanic->id],
                [
                    'staff_first' => $mechanic->first_name,
                    'staff_middle' => $mechanic->middle_name,
                    'staff_last' => $mechanic->last_name,
                    'contact_number' => 9000000000,
                    'address' => 'Not provided',
                    'created_by' => $admin->id,
                ]
            );
        }

        if (Customer::count() === 0) {
            $customer = Customer::create([
                'first_name' => 'Juan', 'middle_name' => null, 'last_name' => 'Dela Cruz',
                'contact_number' => '09171234567', 'address' => 'Davao City', 'created_by' => $admin->id,
            ]);
            Vehicle::create([
                'cust_id' => $customer->cust_id, 'plate_number' => 'ABC-1234',
                'make' => 'Toyota Vios 2022', 'engine_model' => '2NR-FE',
            ]);
        }

        if (Service::count() === 0) {
            foreach ([
                ['Oil Change', 'Engine oil and filter replacement', 1500],
                ['Brake Repair', 'Inspection and repair of brake system', 2500],
                ['Engine Check', 'Engine diagnostics and inspection', 3000],
                ['Suspension Check', 'Suspension and underchassis inspection', 2200],
            ] as [$name, $desc, $price]) {
                Service::create(['service_name' => $name, 'job_desc' => $desc, 'price' => $price]);
            }
        }
    }
}
