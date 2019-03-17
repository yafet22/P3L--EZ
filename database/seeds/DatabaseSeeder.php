<?php

use Illuminate\Database\Seeder;
use App\Procurement;
use App\Supplier;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(MotorBrandSeeder::class);
        $this->call(MotorTypeSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(SalesSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(MotorcycleSeeder::class);
        $this->call(SparepartTypeSeeder::class);
        $this->call(SparepartSeeder::class);
        $this->call(ProcurementSeeder::class);
        $this->call(ProcurementDetailSeeder::class);
        $this->call(MechanicOnDutySeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(DetailServiceSeeder::class);
        $this->call(DetailSparepartSeeder::class);
        $this->call(EmployeeOnDutySeeder::class);
        $this->call(CompatibilitySeeder::class);
    }
}
