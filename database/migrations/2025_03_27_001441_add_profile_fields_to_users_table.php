<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('email'); // Profile Picture
            $table->string('student_id')->nullable()->after('profile_photo'); // Student ID
            $table->string('address')->nullable()->after('student_id'); // Address
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo', 'student_id', 'address']);
        });
    }
};
