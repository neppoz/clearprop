<?php

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstrutorBookingPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_instructor', function (Blueprint $table) {
            $table->unsignedInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        $instructorBookings = Reservation::whereNotNull('instructor_id')->select('id', 'instructor_id')->get();

        foreach ($instructorBookings as $instructorBooking) {
            $instructorBooking->bookingInstructors()->syncWithoutDetaching($instructorBooking->instructor_id, 'user_id');
        }

        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('instructor_needed')->change()->nullable()->default(null);
            $table->dropForeign('instructor_fk_bookings');
            $table->dropColumn('instructor_id');
        });
    }

}
