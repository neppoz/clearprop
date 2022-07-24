<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\User;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        artisan::call('db:seed', array(
            '--class' => 'RolesTableSeeder'
        ));

        artisan::call('db:seed', array(
            '--class' => 'PermissionsTableSeeder'
        ));

        artisan::call('db:seed', array(
            '--class' => 'PermissionRoleTableSeeder'
        ));

        $instructors = User::where('instructor', 1)->get();
        foreach ($instructors as $user) {
            $user->roles()->sync(User::IS_INSTRUCTOR);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('instructor');
        });

    }

};
