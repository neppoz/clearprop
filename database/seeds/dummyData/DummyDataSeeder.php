<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Activity;
use App\User;
use App\Plane;
use App\Type;
use App\Factor;
use App\Income;
use App\IncomeCategory;
use App\ExpenseCategory;

use Faker\Factory as Faker;

/**
 * Class DummyDataSeeder
 */
class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        $faker = Faker::create('it_IT');

        /** Generate Users */
        foreach (range(1, 50) as $index) {
            $dt = $faker->dateTimeBetween($startDate = '-12 months', $endDate = '+5 months');
            $date = $dt->format("d.m.Y");
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'remember_token' => null,
                'lang'           => 'IT',
                'taxno'          => $faker->taxid,
                'phone_1'        => $faker->phoneNumber,
                'phone_2'        => $faker->phoneNumber,
                'address'        => $faker->address,
                'city'           => $faker->city,
                'license'        => $faker->numberBetween(5000, 50000),
                'medical_due'    => $date,
                'factor_id'      => Factor::all()->random()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        /** Generate billings */
        foreach (range(1, 20) as $index) {
            $user_id = User::where('id', '!=', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format("d.m.Y");
            Income::create([
                'entry_date' => $date,
                'amount' => $faker->randomFloat(0, 100, 2500),
                'description' => $faker->sentence(6, true),
                'income_category_id' => IncomeCategory::all()->random()->id,
                'user_id' => $user_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
        foreach (range(1, 50) as $index) {
            $user_id = User::where('id', '!=', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format("d.m.Y");
            Income::create([
                'entry_date' => $date,
                'amount' => $faker->randomFloat(0, 100, 2500),
                'description' => $faker->sentence(6, true),
                'income_category_id' => 1, // only activity deposits
                'user_id' => $user_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        /** Generate activities */
        foreach (range(1, 500) as $index) {
            $counter_start = $faker->randomFloat(2, 1, 999);
            $counter_stop = $counter_start+$faker->randomFloat(2, 1, 3);
            $user_id = User::where('id', '!=', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format("d.m.Y");
            Activity::create([
                'counter_start' => $counter_start,
                'counter_stop' => $counter_stop,
                'departure' => $faker->city,
                'arrival' => $faker->city,
                'event' => $date,
                'description' => $faker->sentence(6, true),
                'user_id' => $user_id,
                'plane_id' => Plane::all()->random()->id,
                'type_id' => Type::whereIN('id', [1, 2, 3])->get()->random()->id,
                'created_by_id' => $user_id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
