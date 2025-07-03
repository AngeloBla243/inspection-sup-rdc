<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['actif', 'suspendu'])->default('actif')->after('profile_picture');
            $table->decimal('last_login_latitude', 10, 8)->nullable()->after('status');
            $table->decimal('last_login_longitude', 11, 8)->nullable()->after('last_login_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'last_login_latitude', 'last_login_longitude']);
        });
    }
};
