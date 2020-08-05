<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'plane_create',
            ],
            [
                'id'    => '18',
                'title' => 'plane_edit',
            ],
            [
                'id'    => '19',
                'title' => 'plane_show',
            ],
            [
                'id'    => '20',
                'title' => 'plane_delete',
            ],
            [
                'id'    => '21',
                'title' => 'plane_access',
            ],
            [
                'id'    => '22',
                'title' => 'factor_create',
            ],
            [
                'id'    => '23',
                'title' => 'factor_edit',
            ],
            [
                'id'    => '24',
                'title' => 'factor_show',
            ],
            [
                'id'    => '25',
                'title' => 'factor_delete',
            ],
            [
                'id'    => '26',
                'title' => 'factor_access',
            ],
            [
                'id'    => '27',
                'title' => 'type_create',
            ],
            [
                'id'    => '28',
                'title' => 'type_edit',
            ],
            [
                'id'    => '29',
                'title' => 'type_show',
            ],
            [
                'id'    => '30',
                'title' => 'type_delete',
            ],
            [
                'id'    => '31',
                'title' => 'type_access',
            ],
            [
                'id'    => '32',
                'title' => 'setting_access',
            ],
            [
                'id'    => '33',
                'title' => 'activity_create',
            ],
            [
                'id'    => '34',
                'title' => 'activity_edit',
            ],
            [
                'id'    => '35',
                'title' => 'activity_show',
            ],
            [
                'id'    => '36',
                'title' => 'activity_delete',
            ],
            [
                'id'    => '37',
                'title' => 'activity_access',
            ],
            [
                'id'    => '38',
                'title' => 'security_access',
            ],
            [
                'id'    => '39',
                'title' => 'booking_create',
            ],
            [
                'id'    => '40',
                'title' => 'booking_edit',
            ],
            [
                'id'    => '41',
                'title' => 'booking_show',
            ],
            [
                'id'    => '42',
                'title' => 'booking_delete',
            ],
            [
                'id'    => '43',
                'title' => 'booking_access',
            ],
            [
                'id'    => '44',
                'title' => 'parameter_create',
            ],
            [
                'id'    => '45',
                'title' => 'parameter_edit',
            ],
            [
                'id'    => '46',
                'title' => 'parameter_show',
            ],
            [
                'id'    => '47',
                'title' => 'parameter_delete',
            ],
            [
                'id'    => '48',
                'title' => 'parameter_access',
            ],
            [
                'id'    => '49',
                'title' => 'activity_management_access',
            ],
            [
                'id'    => '50',
                'title' => 'activity_report_access',
            ],
            [
                'id'    => '51',
                'title' => 'expense_management_access',
            ],
            [
                'id'    => '52',
                'title' => 'expense_category_create',
            ],
            [
                'id'    => '53',
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => '54',
                'title' => 'expense_category_show',
            ],
            [
                'id'    => '55',
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => '56',
                'title' => 'expense_category_access',
            ],
            [
                'id'    => '57',
                'title' => 'income_category_create',
            ],
            [
                'id'    => '58',
                'title' => 'income_category_edit',
            ],
            [
                'id'    => '59',
                'title' => 'income_category_show',
            ],
            [
                'id'    => '60',
                'title' => 'income_category_delete',
            ],
            [
                'id'    => '61',
                'title' => 'income_category_access',
            ],
            [
                'id'    => '62',
                'title' => 'expense_create',
            ],
            [
                'id'    => '63',
                'title' => 'expense_edit',
            ],
            [
                'id'    => '64',
                'title' => 'expense_show',
            ],
            [
                'id'    => '65',
                'title' => 'expense_delete',
            ],
            [
                'id'    => '66',
                'title' => 'expense_access',
            ],
            [
                'id'    => '67',
                'title' => 'income_create',
            ],
            [
                'id'    => '68',
                'title' => 'income_edit',
            ],
            [
                'id'    => '69',
                'title' => 'income_show',
            ],
            [
                'id'    => '70',
                'title' => 'income_delete',
            ],
            [
                'id'    => '71',
                'title' => 'income_access',
            ],
            [
                'id'    => '72',
                'title' => 'expense_report_create',
            ],
            [
                'id'    => '73',
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => '74',
                'title' => 'expense_report_show',
            ],
            [
                'id'    => '75',
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => '76',
                'title' => 'expense_report_access',
            ],
        ];

        Permission::insertOrIgnore($permissions);
    }
}
