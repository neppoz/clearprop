<?php

namespace Database\Seeders;

use Database\Seeders\ExpenseCategoriesTableSeeder;
use Database\Seeders\FactorTableSeeder;
use Database\Seeders\FactorTypeTableSeeder;
use Database\Seeders\IncomeCategoriesTableSeeder;
use Database\Seeders\PlaneTableSeeder;
use Database\Seeders\TypeTableSeeder;
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
use App\Booking;
use App\Events\ActivityCostCalculation;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

/**
 * Class DummyDataSeeder
 */
class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run()
    {
        /* Seed the details */
        $this->call([
            TypeTableSeeder::class,
            FactorTableSeeder::class,
            FactorTypeTableSeeder::class,
            IncomeCategoriesTableSeeder::class,
            ExpenseCategoriesTableSeeder::class,
            PlaneTableSeeder::class,
        ]);

        $faker = Faker::create('it_IT');
        $dt = $faker->dateTimeBetween($startDate = '-12 months', $endDate = '+5 months');
        $date = $dt->format('Y-m-d');

        $users = [
            [
                'id' => 2,
                'name' => 'Demo Admin',
                'email' => 'demo.admin@clearprop.aero',
                'password' => Hash::make('demoadmin'),
                'remember_token' => null,
                'medical_due' => null,
                'license' => $faker->numberBetween(5000, 50000),
                'lang' => 'EN',
                'factor_id' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
        ];

        User::insert($users);

        /** Generate Users */
        foreach (range(1, 30) as $index) {
            $dt = $faker->dateTimeBetween($startDate = '-12 months', $endDate = '+5 months');
            $date = $dt->format('Y-m-d');
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'remember_token' => null,
                'lang' => 'IT',
                'taxno' => $faker->taxid,
                'phone_1' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'address' => $faker->address,
                'city' => $faker->city,
                'license' => $faker->numberBetween(5000, 50000),
                'medical_due' => $date,
                'factor_id' => Factor::all()->random()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
        /** Sync roles*/
        User::findOrFail(2)->roles()->sync(User::IS_ADMIN);
        $members = User::where('id', '>', 2)->get();
        foreach ($members as $member) {
            $member->roles()->sync(User::IS_MEMBER);
        }

        /** Generate billings */
        foreach (range(1, 20) as $index) {
            $user_id = User::where('id', '>', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format(config('panel.date_format'));
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
            $user_id = User::where('id', '>', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format(config('panel.date_format'));
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
            $counter_stop = $counter_start + $faker->randomFloat(2, 1, 3);
            $user_id = User::where('id', '>', 1)->get()->random()->id;
            $dt = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
            $date = $dt->format(config('panel.date_format'));
            $activity = Activity::create([
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
            event(new ActivityCostCalculation($activity));
        }

        /** Generate reservations */
//        foreach (range(1, 500) as $index) {
//            $user_id = User::where('id', '>', 1)->get()->random()->id;
//            $dt_start = $faker->dateTimeBetween($startDate = '-1 months', $endDate = '+ 2 months');
//            $dt_start_clone = clone $dt_start;
//            $dt_stop = $faker->dateTimeBetween($dt_start, $dt_start_clone->modify('+2 hours'));
//            $reservation_start = Carbon::parse($dt_start)->format(config('panel.date_format') . ' ' . config('panel.time_format'));
//            $reservation_stop = Carbon::parse($dt_stop)->format(config('panel.date_format') . ' ' . config('panel.time_format'));
//            Booking::create([
//                'reservation_start' => $reservation_start,
//                'reservation_stop' => $reservation_stop,
//                'description' => $faker->sentence(6, true),
//                'status' => rand(0, 1),
//                'user_id' => $user_id,
//                'instructor_id' => $instructor_id,
//                'plane_id' => Plane::all()->random()->id,
//                'created_by_id' => $user_id,
//                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
//            ]);
//        }
    }
}
