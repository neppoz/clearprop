<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;
use App\Enums\PaymentType;

class IncomeCategorySeeder extends Seeder
{
    public function run(): void
    {
        IncomeCategory::firstOrCreate(
            ['deposit' => PaymentType::Deposit->value],
            [
                'name' => 'Activity deposit',
                'deposit' => PaymentType::Deposit->value,
            ]
        );
    }
}
